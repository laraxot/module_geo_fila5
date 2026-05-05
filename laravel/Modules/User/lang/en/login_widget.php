<?php

declare(strict_types=1);

/**
 * Login widget translations in English following 5-element structure
 * Automatically resolved by LangServiceProvider.
 */

/*
 * Login widget translations in English following 5-element structure
 * Automatically resolved by LangServiceProvider.
 */

return [
    'auth' => [
        'email_address' => [
            'key' => 'auth.email_address',
            'text' => 'Email address',
            'description' => 'Label for the email input field on the login form,\\nused for both OAuth and standard email authentication',
        ],

        'password' => [
            'key' => 'auth.password',
            'text' => 'Password',
            'description' => 'User password for authentication\\nUsed in combination with Socialite where available',
        ],

        'remember' => [
            'key' => 'auth.remember',
            'text' => 'Remember me',
            'description' => 'Option to keep session active for 30 days\\nafter login',
        ],

        'login_success' => [
            'key' => 'auth.login_success',
            'text' => 'Login successful',
            'description' => 'Message displayed after successful authentication',
        ],

        'login_error' => [
            'key' => 'auth.login_error',
            'text' => 'Login error',
            'description' => 'Error message in case of invalid authentication',
        ],

        'login_success' => [
            'key' => 'auth.login_success',
            'text' => 'Login successful',
            'description' => 'Message displayed after successful authentication',
        ],

        'login_error' => [
            'key' => 'auth.login_error',
            'text' => 'Login error',
            'description' => 'Error message in case of invalid authentication',
        ],
    ],

    'ui' => [
        'login_button' => [
            'key' => 'ui.login_button',
            'text' => 'Login',
            'description' => 'Main button to complete the login process',
        ],

        'forgot_password' => [
            'key' => 'ui.forgot_password',
            'text' => 'Forgot password?',
            'description' => 'Link to request password reset',
        ],
    ],
];
