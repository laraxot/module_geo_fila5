<?php

declare(strict_types=1);

return [
    'name' => 'Notify',
    'description' => 'Modulo per la gestione delle notifiche e comunicazioni',
    'icon' => 'heroicon-o-bell',
    'navigation' => [
        'enabled' => true,
        'sort' => 70,
    ],
    'routes' => [
        'enabled' => true,
        'middleware' => ['web', 'auth'],
    ],
    'providers' => [
        'Modules\\Notify\\Providers\\NotifyServiceProvider',
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Email Layout Configuration
     * |--------------------------------------------------------------------------
     * |
     * | This file contains the configuration for email layouts and templates.
     * |
     */

    // Logo URL for email headers
    'logo_url' => null,
    // Footer text for all emails
    // 'footer_text' => '© ' . date('Y') . ' ' . config('app.name') . '. All rights reserved.',

    // Social media links
    'social_links' => [
        'facebook' => null,
        'twitter' => null,
        'instagram' => null,
        'linkedin' => null,
    ],
    // Unsubscribe URL
    'unsubscribe_url' => null,
    /*
     * |--------------------------------------------------------------------------
     * | Mail Templates
     * |--------------------------------------------------------------------------
     * |
     * | Configuration for mail templates
     * |
     */

    // Default layout to use
    'default_layout' => 'notify::mail-layouts.base.default',
    // Available layouts
    'layouts' => [
        'default' => 'notify::mail-layouts.base.default',
        // Add more layouts here
    ],
    // Available templates
    'templates' => [
        'welcome' => 'notify::mail-layouts.templates.welcome',
        // Add more templates here
    ],
];
