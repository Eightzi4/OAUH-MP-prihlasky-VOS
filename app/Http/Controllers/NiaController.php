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
        $settings = config('nia');

        return new Auth($settings);
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

        return $auth->login();
    }

    public function acs(Request $request)
    {
        $auth = $this->getSamlAuth();
        $auth->processResponse();
        $errors = $auth->getErrors();

        if (!empty($errors)) {
            Log::error('NIA SAML Errors: ' . implode(', ', $errors));
            Log::error($auth->getLastErrorReason());
            return redirect()->route('dashboard')->with('error', 'Chyba při ověřování identity: ' . $auth->getLastErrorReason());
        }

        if (!$auth->isAuthenticated()) {
            return redirect()->route('dashboard')->with('error', 'Ověření neproběhlo úspěšně.');
        }

        $attributes = $auth->getAttributes();

        Log::info('NIA Attributes received:', $attributes);

        $niaData = [
            'first_name' => $attributes['FirstName'][0] ?? $attributes['http://eidas.europa.eu/attributes/naturalperson/CurrentGivenName'][0] ?? null,
            'last_name' => $attributes['LastName'][0] ?? $attributes['http://eidas.europa.eu/attributes/naturalperson/CurrentFamilyName'][0] ?? null,
            'birth_date' => $attributes['BirthDate'][0] ?? $attributes['http://eidas.europa.eu/attributes/naturalperson/DateOfBirth'][0] ?? null,
            'birth_number' => $attributes['PersonIdentifier'][0] ?? $attributes['http://eidas.europa.eu/attributes/naturalperson/PersonIdentifier'][0] ?? null,

            'street' => $attributes['Street'][0] ?? null,
            'city' => $attributes['City'][0] ?? null,
            'zip' => $attributes['PostCode'][0] ?? null,
        ];

        $this->saveDataToApplication($niaData);

        $appId = session('nia_application_id');

        return redirect()->route('application.step1', $appId)
            ->with('success', 'Identita byla úspěšně ověřena.');
    }

    private function saveDataToApplication($niaData)
    {
        $appId = session('nia_application_id');
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
