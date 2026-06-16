<?php

declare(strict_types=1);

return [
    'default' => 'smsfactor',

    'drivers' => [
        'smsfactor' => [
            'token' => null,
            'base_url' => 'https://api.smsfactor.com',
        ],
        'twilio' => [
            'account_sid' => null,
            'auth_token' => null,
        ],
        'nexmo' => [
            'key' => null,
            'secret' => null,
        ],
        'plivo' => [
            'auth_id' => null,
            'auth_token' => null,
        ],
        'gammu' => [
            'path' => '/usr/bin/gammu',
            'config' => '/etc/gammurc',
        ],
        'netfun' => [
            'token' => null,
            'api_url' => 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json',
            'circuit_breaker' => [
                'threshold' => 5,
                'timeout' => 60,
            ],
        ],
        'agiletelecom' => [
            'username' => null,
            'password' => null,
            'sender' => 'MyApp',
            'endpoint' => 'https://secure.agiletelecom.com/services/sms/send',
        ],
    ],

    'debug' => false,
    'queue' => 'default',
    'retry' => [
        'attempts' => 3,
        'delay' => 60,
    ],
    'rate_limit' => [
        'enabled' => true,
        'max_attempts' => 60,
        'decay_minutes' => 1,
    ],
    'circuit_breaker' => [
        'enabled' => true,
        'threshold' => 5,
        'timeout' => 60,
    ],
    'timeout' => 30,
    'logging' => [
        'enabled' => true,
        'channel' => 'stack',
    ],
    'validation' => [
        'enabled' => true,
        'pattern' => '/^\+[1-9]\d{1,14}$/',
    ],
];
