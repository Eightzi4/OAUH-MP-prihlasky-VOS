<?php

return [
    // -------------------------------------------------------------------------
    // SERVICE PROVIDER
    // -------------------------------------------------------------------------
    'sp' => [
        'entityId' => env('APP_URL') . '/nia/metadata',

        'assertionConsumerService' => [
            'url' => env('APP_URL') . '/nia/acs',
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
        ],

        'singleLogoutService' => [
            'url' => env('APP_URL') . '/nia/logout',
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ],

        'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:persistent',

        'x509cert' => file_get_contents(storage_path('certs/sp.crt')),
        'privateKey' => file_get_contents(storage_path('certs/sp.key')),
    ],

    // -------------------------------------------------------------------------
    // IDENTITY PROVIDER (NIA Test Environment - TNIA)
    // -------------------------------------------------------------------------
    'idp' => [
        'entityId' => 'urn:microsoft:cgg2010:fpsts',

        'singleSignOnService' => [
            'url' => 'https://tnia.identita.gov.cz/FPSTS/saml2/basic',
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ],

        'singleLogoutService' => [
            'url' => 'https://tnia.identita.gov.cz/FPSTS/saml2/basic',
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ],

        'x509cert' => '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',
    ],

    // -------------------------------------------------------------------------
    // SETTINGS
    // -------------------------------------------------------------------------
    'strict' => false,
    'debug' => true,
    'baseurl' => env('APP_URL'),
];
