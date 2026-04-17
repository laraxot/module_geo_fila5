<?php

declare(strict_types=1);

return [

    'default' => 'test',
    

    'test' => [
        'kid' => env('PDND_KID', 'vrfKQdxk39qIif0LRJIZcD2g4pl1cXDaJ2TA4goHv8U'),
        'issuer' => env('PDND_ISSUER', '6993a2cb-7cbe-45f0-bb26-1373b891f845'),
        'clientId' => env('PDND_CLIENT_ID', '6993a2cb-7cbe-45f0-bb26-1373b891f845'),
        'privKeyPath' => env('PDND_PRIVATE_KEY_PATH', storage_path('pdnd/C030/client-test-ricerca_domicilio.rsa.priv')),
        'authUrl' => env('PDND_AUTH_URL', 'https://auth.interop.pagopa.it/token.oauth2'),
        'audience' => env('PDND_AUDIENCE', 'auth.interop.pagopa.it/client-assertion'),
        'apiBaseUrlTest' => env('PDND_API_BASE_URL_TEST', 'https://modipa-val.anpr.interno.it/govway/rest/in/MinInternoPortaANPR-PDND/'),
    ],

    'prod' => [
        'kid' => env('PDND_KID', 'vrfKQdxk39qIif0LRJIZcD2g4pl1cXDaJ2TA4goHv8U'),
        'issuer' => env('PDND_ISSUER', '91301dcd-bb35-4ea1-bf5a-cbb259822851'),
        'clientId' => env('PDND_CLIENT_ID', '91301dcd-bb35-4ea1-bf5a-cbb259822851'),
        'privKeyPath' => env('PDND_PRIVATE_KEY_PATH', storage_path('pdnd/C030/client-test-ricerca_domicilio.rsa.priv')),
        'authUrl' => env('PDND_AUTH_URL', 'https://auth.interop.pagopa.it/token.oauth2'),
        'audience' => env('PDND_AUDIENCE', 'auth.interop.pagopa.it/client-assertion'),
        'apiBaseUrlTest' => env('PDND_API_BASE_URL_TEST', 'https://modipa.anpr.interno.it/govway/rest/in/MinInternoPortaANPR-PDND/'),
    ],

];
