<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NiaMockController extends Controller
{
    public function login($applicationId)
    {
        session(['nia_application_id' => $applicationId]);

        sleep(1);

        return redirect()->route('nia.mock.callback');
    }

    public function callback()
    {
        $samlAttributes = [
            'http://eidas.europa.eu/attributes/naturalperson/CurrentGivenName' => ['Pavla'],
            'http://eidas.europa.eu/attributes/naturalperson/CurrentFamilyName' => ['Dvořáková'],
            'http://eidas.europa.eu/attributes/naturalperson/DateOfBirth' => ['1955-06-07'],
            'http://eidas.europa.eu/attributes/naturalperson/PersonIdentifier' => ['CZ/CZ/225171f6-4662-4f04-a889-5e9b1870f608'],
            'http://eidas.europa.eu/attributes/naturalperson/Gender' => ['Žena'],
            'ParsedAddress_Street' => 'Arnoltice',
            'ParsedAddress_City' => 'Arnoltice u Děčína',
            'ParsedAddress_Zip' => '40714',
            'http://www.stork.gov.eu/1.0/eMail' => ['dvorakova_pavla@example.com'],
        ];

        $niaData = [
            'first_name' => $this->getAttr($samlAttributes, 'http://eidas.europa.eu/attributes/naturalperson/CurrentGivenName'),
            'last_name' => $this->getAttr($samlAttributes, 'http://eidas.europa.eu/attributes/naturalperson/CurrentFamilyName'),
            'gender' => $this->getAttr($samlAttributes, 'http://eidas.europa.eu/attributes/naturalperson/Gender'),

            'birth_date' => $this->getAttr($samlAttributes, 'http://eidas.europa.eu/attributes/naturalperson/DateOfBirth'),
            'birth_number' => '555607/1235',

            'street' => $samlAttributes['ParsedAddress_Street'],
            'city' => $samlAttributes['ParsedAddress_City'],
            'zip' => $samlAttributes['ParsedAddress_Zip'],
            'citizenship' => 'Česká republika',

            'email' => $this->getAttr($samlAttributes, 'http://www.stork.gov.eu/1.0/eMail'),
        ];

        $appId = session('nia_application_id');
        $application = Application::where('user_id', Auth::id())->findOrFail($appId);
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

        return redirect()->route('application.step1', $application->id)
            ->with('success', 'Identita byla úspěšně ověřena (Simulace NIA dle XML).');
    }

    private function getAttr($attributes, $key)
    {
        return $attributes[$key][0] ?? null;
    }
}
