<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OneLogin\Saml2\Auth;
use OneLogin\Saml2\Utils;
use App\Models\Application;
use Illuminate\Support\Facades\Auth as UserAuth;
use Illuminate\Support\Facades\Log;

class NiaController extends Controller
{
    private function getSamlAuth()
    {
        return new Auth(config('nia'));
    }

    public function metadata()
    {
        try {
            $auth = $this->getSamlAuth();
            $settings = $auth->getSettings();
            $metadata = $settings->getSPMetadata();
            $errors = $settings->validateMetadata($metadata);

            if (empty($errors)) {
                return response($metadata, 200, ['Content-Type' => 'text/xml']);
            } else {
                throw new \Exception('Invalid SP Metadata: ' . implode(', ', $errors));
            }
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    public function login($applicationId)
    {
        $auth = $this->getSamlAuth();
        session(['nia_application_id' => $applicationId]);

        $settings = new \OneLogin\Saml2\Settings(config('nia'));
        $authnRequest = new \OneLogin\Saml2\AuthnRequest($settings);
        $xml = $authnRequest->getXML();

        $extensionsXml = <<<XML
        <samlp:Extensions xmlns:eidas="http://eidas.europa.eu/saml-extensions">
            <eidas:SPType>public</eidas:SPType>
            <eidas:RequestedAttributes>
                <eidas:RequestedAttribute Name="http://eidas.europa.eu/attributes/naturalperson/CurrentGivenName" isRequired="true" NameFormat="urn:oasis:names:tc:SAML:2.0:attrname-format:uri"/>
                <eidas:RequestedAttribute Name="http://eidas.europa.eu/attributes/naturalperson/CurrentFamilyName" isRequired="true" NameFormat="urn:oasis:names:tc:SAML:2.0:attrname-format:uri"/>
                <eidas:RequestedAttribute Name="http://eidas.europa.eu/attributes/naturalperson/DateOfBirth" isRequired="true" NameFormat="urn:oasis:names:tc:SAML:2.0:attrname-format:uri"/>
                <eidas:RequestedAttribute Name="http://eidas.europa.eu/attributes/naturalperson/PersonIdentifier" isRequired="true" NameFormat="urn:oasis:names:tc:SAML:2.0:attrname-format:uri"/>
                <eidas:RequestedAttribute Name="http://eidas.europa.eu/attributes/naturalperson/CurrentAddress" isRequired="false" NameFormat="urn:oasis:names:tc:SAML:2.0:attrname-format:uri"/>
            </eidas:RequestedAttributes>
        </samlp:Extensions>
        XML;

        $issuerCloseTag = '</saml:Issuer>';
        $position = strpos($xml, $issuerCloseTag) + strlen($issuerCloseTag);
        $xml = substr_replace($xml, $extensionsXml, $position, 0);

        $signedXml = \OneLogin\Saml2\Utils::addSign(
            $xml,
            $settings->getSPkey(),
            $settings->getSPcert(),
            $settings->getSecurityData()['signatureAlgorithm'],
            $settings->getSecurityData()['digestAlgorithm']
        );

        $ssoUrl = $settings->getIdPData()['singleSignOnService']['url'];
        $encodedRequest = base64_encode($signedXml);
        $relayState = $applicationId;

        return response(<<<HTML
            <!DOCTYPE html><html><head><meta charset="utf-8"></head><body onload="document.forms[0].submit()">
            <form method="post" action="{$ssoUrl}"><input type="hidden" name="SAMLRequest" value="{$encodedRequest}" /><input type="hidden" name="RelayState" value="{$relayState}" /></form>
            </body></html>
            HTML
        );
    }

    public function acs(Request $request)
    {
        Log::info('NIA Callback hit! Processing response...');

        if (!UserAuth::check()) {
            return redirect()->route('login')->with('error', 'Relace vypršela.');
        }

        $auth = $this->getSamlAuth();

        try {
            $auth->processResponse();
        } catch (\Exception $e) {
            // TODO
        }

        $rawXml = $auth->getLastResponseXML();

        if (empty($rawXml)) {
            return redirect()->route('dashboard')->with('error', 'NIA neposlala žádná data (Empty XML).');
        }

        Log::info('NIA Raw XML Received (Parsing Manually...)');

        $attributes = $this->parseAttributesManually($rawXml);

        Log::info('NIA Manually Parsed Attributes:', $attributes);

        if (empty($attributes)) {
             return redirect()->route('dashboard')->with('error', 'Nepodařilo se načíst atributy z NIA odpovědi.');
        }

        $niaData = [
            'first_name' => $attributes['http://eidas.europa.eu/attributes/naturalperson/CurrentGivenName'] ?? null,
            'last_name' => $attributes['http://eidas.europa.eu/attributes/naturalperson/CurrentFamilyName'] ?? null,
            'birth_date' => $attributes['http://eidas.europa.eu/attributes/naturalperson/DateOfBirth'] ?? null,
            'birth_number' => $attributes['http://eidas.europa.eu/attributes/naturalperson/PersonIdentifier'] ?? null,
        ];

        $rawAddress = $attributes['http://eidas.europa.eu/attributes/naturalperson/CurrentAddress'] ?? null;
        if ($rawAddress) {
            $parsedAddress = $this->parseEidasAddress($rawAddress);
            $niaData = array_merge($niaData, $parsedAddress);
        }

        $this->saveDataToApplication($niaData);

        $appId = session('nia_application_id');
        return redirect()->route('application.step1', $appId)
            ->with('success', 'Identita byla úspěšně ověřena (Data načtena).');
    }

    private function parseAttributesManually($xmlString)
    {
        $attributes = [];
        try {
            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadXML($xmlString);
            libxml_clear_errors();

            $xpath = new \DOMXPath($dom);
            $xpath->registerNamespace('saml', 'urn:oasis:names:tc:SAML:2.0:assertion');

            $nodes = $xpath->query('//saml:Attribute');

            foreach ($nodes as $node) {
                $name = $node->getAttribute('Name');
                $valueNode = $xpath->query('./saml:AttributeValue', $node)->item(0);

                if ($valueNode) {
                    $attributes[$name] = trim($valueNode->textContent);
                }
            }
        } catch (\Exception $e) {
            Log::error('Manual XML Parse Error: ' . $e->getMessage());
        }
        return $attributes;
    }

    private function getAttr($attributes, $key)
    {
        return isset($attributes[$key]) ? $attributes[$key][0] : null;
    }

    private function parseEidasAddress($base64Xml)
    {
        try {
            $xmlString = base64_decode($base64Xml);
            $xmlString = str_replace(['eidas:', 'xmlns:eidas'], ['', 'ignore'], $xmlString);

            $xml = new \SimpleXMLElement($xmlString);

            $street = (string)$xml->Thoroughfare;
            $houseNum = (string)$xml->LocatorDesignator;
            $city = (string)$xml->CvaddressArea ?: (string)$xml->PostName;
            $zip = (string)$xml->PostCode;

            $fullStreet = $street ? "$street $houseNum" : "$city $houseNum";

            return [
                'street' => $fullStreet,
                'city' => $city,
                'zip' => str_replace(' ', '', $zip),
                'country' => 'Česká republika',
            ];
        } catch (\Exception $e) {
            Log::error('Address Parse Error: ' . $e->getMessage());
            return [];
        }
    }

    private function saveDataToApplication($niaData)
    {
        $appId = session('nia_application_id');
        if (!$appId) return;

        $application = Application::where('user_id', UserAuth::id())->findOrFail($appId);
        $details = $application->details;
        $details->nia_data = $niaData;
        $verifiedFields = [];

        foreach ($niaData as $key => $value) {
            if (!empty($value)) {
                $details->$key = $value;
                $verifiedFields[] = $key;
            }
        }
        $details->verified_fields = $verifiedFields;
        $details->save();
    }
}
