<?php

return [
    // -------------------------------------------------------------------------
    // SERVICE PROVIDER
    // -------------------------------------------------------------------------
    'sp' => [
        'entityId' => env('APP_URL') . '/auth/nia',

        'assertionConsumerService' => [
            'url' => env('APP_URL') . '/auth/nia/callback',
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
        ],

        'singleLogoutService' => [
            'url' => env('APP_URL') . '/auth/nia/logout',
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ],

        'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:persistent',

        'x509cert' => file_get_contents(storage_path('certs/saml.crt')),
        'privateKey' => file_get_contents(storage_path('certs/saml.key')),

        'attributeConsumingService' => [
            'serviceName' => 'E-prihlaska VOS',
            'serviceDescription' => 'Identifikace uchazece o studium',
            'requestedAttributes' => [
                [
                    'name' => 'http://eidas.europa.eu/attributes/naturalperson/CurrentGivenName',
                    'isRequired' => true,
                    'friendlyName' => 'FirstName',
                ],
                [
                    'name' => 'http://eidas.europa.eu/attributes/naturalperson/CurrentFamilyName',
                    'isRequired' => true,
                    'friendlyName' => 'LastName',
                ],
                [
                    'name' => 'http://eidas.europa.eu/attributes/naturalperson/DateOfBirth',
                    'isRequired' => true,
                    'friendlyName' => 'DateOfBirth',
                ],
                [
                    'name' => 'http://eidas.europa.eu/attributes/naturalperson/PersonIdentifier',
                    'isRequired' => true,
                    'friendlyName' => 'PersonIdentifier',
                ],
                [
                    'name' => 'http://eidas.europa.eu/attributes/naturalperson/CurrentAddress',
                    'isRequired' => false,
                    'friendlyName' => 'CurrentAddress',
                ],
            ]
        ],
    ],

    // -------------------------------------------------------------------------
    // IDENTITY PROVIDER
    // -------------------------------------------------------------------------
    'idp' => [
            'entityId' => 'urn:microsoft:cgg2010:fpsts',

            'singleSignOnService' => [
                'url' => 'https://nia.identita.gov.cz/fpsts/saml2/basic',
                'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
            ],

            'singleLogoutService' => [
                'url' => 'https://nia.identita.gov.cz/fpsts/saml2/basic',
                'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
            ],

            'x509cert' => file_get_contents(storage_path('certs/nia.crt')),
        ],

    // -------------------------------------------------------------------------
    // SECURITY & ALGORITHMS
    // -------------------------------------------------------------------------
    'security' => [
        'authnRequestsSigned' => true,
        'logoutRequestSigned' => true,
        'logoutResponseSigned' => true,
        'wantMessagesSigned' => true,
        'wantAssertionsSigned' => true,
        'wantNameId' => false,

        'signatureAlgorithm' => 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256',
        'digestAlgorithm' => 'http://www.w3.org/2001/04/xmlenc#sha256',

        'requestedAuthnContext' => [
            'http://eidas.europa.eu/LoA/low',
        ],

        'requestedAuthnContextComparison' => 'minimum',
    ],

    // -------------------------------------------------------------------------
    // SETTINGS
    // -------------------------------------------------------------------------
    'strict' => false,
    'debug' => true,
    'baseurl' => env('APP_URL'),
];
