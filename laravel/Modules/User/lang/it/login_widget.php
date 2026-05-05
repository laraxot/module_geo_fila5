<?php

declare(strict_types=1);

return [
    'auth' => [
        'email_address' => [
            'key' => 'auth.email_address',
            'text' => 'Indirizzo email',
            'description' => 'Etichetta per il campo email nel modulo di login,\\nutilizzato per l\'autenticazione via OAuth ed email\\nstandard',
        ],
        'password' => [
            'key' => 'auth.password',
            'text' => 'Password',
            'description' => 'Password dell\'account per autenticazione\\nutilizzata in combinazione con Socialite dove disponibile',
        ],
        'remember' => [
            'key' => 'auth.remember',
            'text' => 'Ricordami',
            'description' => 'Opzione per mantenere attiva la sessione per 30 giorni dopo il login',
        ],
        'login_success' => [
            'key' => 'auth.login_success',
            'text' => 'Accesso effettuato con successo',
            'description' => 'Messaggio visualizzato dopo autenticazione\\nsuccessiva',
        ],
        'login_error' => [
            'key' => 'auth.login_error',
            'text' => 'Errore durante l\'accesso',
            'description' => 'Messaggio d\'errore in caso di autenticazione\\nnon valida',
        ],
    ],
    'ui' => [
        'login_button' => [
            'key' => 'ui.login_button',
            'text' => 'Accedi',
            'description' => 'Pulsante principale per completare il login',
        ],
        'forgot_password' => [
            'key' => 'ui.forgot_password',
            'text' => 'Password dimenticata?',
            'description' => 'Link per richiedere reimpostazione password',
        ],
    ],
    'fields' => [
        'remember' => [
            'description' => 'remember',
            'helper_text' => 'remember',
            'placeholder' => 'remember',
            'label' => 'remember',
        ],
        'password' => [
            'description' => 'password',
            'helper_text' => 'password',
            'placeholder' => 'password',
            'label' => 'password',
        ],
        'email' => [
            'description' => 'email',
            'helper_text' => 'email',
            'placeholder' => 'email',
            'label' => 'email',
        ],
    ],
    'actions' => [
        'hidePassword' => [
            'tooltip' => 'hidePassword',
            'icon' => 'hidePassword',
            'label' => 'hidePassword',
        ],
        'showPassword' => [
            'tooltip' => 'showPassword',
            'icon' => 'showPassword',
            'label' => 'showPassword',
        ],
    ],
];
