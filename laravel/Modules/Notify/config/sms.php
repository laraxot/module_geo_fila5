<?php

declare(strict_types=1);

return [
    /*
     * |--------------------------------------------------------------------------
     * | Default SMS Driver
     * |--------------------------------------------------------------------------
     * |
     * | This option controls the default SMS driver that will be used when
     * | sending SMS messages. Supported drivers: "smsfactor", "twilio", "nexmo",
     * | "plivo", "gammu", "netfun"
     * |
     */

    'default' => 'smsfactor',
    /*
     * |--------------------------------------------------------------------------
     * | SMS Drivers
     * |--------------------------------------------------------------------------
     * |
     * | Here you may configure the SMS drivers for your application. Out of
     * | the box, Laravel supports several drivers including SMSFactor, Twilio,
     * | Nexmo, Plivo, and Gammu.
     * |
     */

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
    /*
     * |--------------------------------------------------------------------------
     * | Global Debug Mode
     * |--------------------------------------------------------------------------
     * |
     * | Enable or disable debug mode for all SMS drivers. This will log
     * | detailed information about SMS sending attempts and responses.
     * |
     */

    'debug' => false,
    /*
     * |--------------------------------------------------------------------------
     * | SMS Queue
     * |--------------------------------------------------------------------------
     * |
     * | This option allows you to specify the queue that should be used for
     * | sending SMS messages. This is useful for handling large volumes of
     * | SMS messages without blocking your application.
     * |
     */

    'queue' => 'default',
    /*
     * |--------------------------------------------------------------------------
     * | SMS Retry Configuration
     * |--------------------------------------------------------------------------
     * |
     * | Here you may configure the retry settings for failed SMS messages.
     * | You can specify the number of retries and the delay between retries.
     * |
     */

    'retry' => [
        'attempts' => 3,
        'delay' => 60,
    ],
    /*
     * |--------------------------------------------------------------------------
     * | SMS Rate Limiting
     * |--------------------------------------------------------------------------
     * |
     * | Here you may configure the rate limiting settings for SMS messages.
     * | This helps prevent abuse and ensures fair usage of the SMS service.
     * |
     */

    'rate_limit' => [
        'enabled' => true,
        'max_attempts' => 60,
        'decay_minutes' => 1,
    ],
    /*
     * |--------------------------------------------------------------------------
     * | SMS Circuit Breaker
     * |--------------------------------------------------------------------------
     * |
     * | Here you may configure the circuit breaker settings for SMS messages.
     * | This helps prevent cascading failures when the SMS service is down.
     * |
     */

    'circuit_breaker' => [
        'enabled' => true,
        'threshold' => 5,
        'timeout' => 60,
    ],
    /*
     * |--------------------------------------------------------------------------
     * | SMS Timeout
     * |--------------------------------------------------------------------------
     * |
     * | Here you may configure the timeout settings for SMS messages.
     * | This helps prevent hanging requests when the SMS service is slow.
     * |
     */

    'timeout' => 30,
    /*
     * |--------------------------------------------------------------------------
     * | SMS Logging
     * |--------------------------------------------------------------------------
     * |
     * | Here you may configure the logging settings for SMS messages.
     * | This helps track the delivery status and troubleshoot issues.
     * |
     */

    'logging' => [
        'enabled' => true,
        'channel' => 'stack',
    ],
    /*
     * |--------------------------------------------------------------------------
     * | SMS Validation
     * |--------------------------------------------------------------------------
     * |
     * | Here you may configure the validation settings for phone numbers.
     * | This helps ensure that only valid phone numbers are used.
     * |
     */

    'validation' => [
        'enabled' => true,
        'pattern' => '/^\+[1-9]\d{1,14}$/',
    ],
];
