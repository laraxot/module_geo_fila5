<?php

declare(strict_types=1);

return [
    /*
     * |--------------------------------------------------------------------------
     * | Company Configuration
     * |--------------------------------------------------------------------------
     * |
     * | Configuration for company-specific information that can be customized
     * | per project without modifying the module code.
     * |
     */
    'company' => [
        'name' => 'Default Company',
        'team' => 'Default Team',
        'webhook_base' => 'https://api.example.com',
        'clinic_name' => 'Default Clinic',
        'repository_url' => 'https://github.com/example/repo',
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Default Test Data
     * |--------------------------------------------------------------------------
     * |
     * | Default values for test data that should be generic and reusable
     * | across different projects.
     * |
     */
    'test_data' => [
        'default_subject' => 'Benvenuto su {{company_name}}',
        'default_content' => 'Grazie per esserti registrato al nostro servizio.',
        'default_welcome_content' => 'Ciao {{user_name}}, benvenuto su {{company_name}}!',
        'default_clinic_name' => '{{clinic_name}}',
        'default_team_name' => '{{team_name}}',
        'default_theme_name' => '{{company_name}} Professional',
        'default_theme_description' => 'Tema professionale per {{company_name}}',
        'default_author' => '{{team_name}}',
        'default_repository' => '{{repository_url}}',
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Webhook Configuration
     * |--------------------------------------------------------------------------
     * |
     * | Default webhook endpoints that can be customized per project.
     * |
     */
    'webhooks' => [
        'notification_delivered' => '{{webhook_base}}/webhooks/notification-delivered',
        'notification_bounced' => '{{webhook_base}}/webhooks/notification-bounced',
        'notification_clicked' => '{{webhook_base}}/webhooks/notification-clicked',
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Email Configuration
     * |--------------------------------------------------------------------------
     * |
     * | Default email settings that can be customized per project.
     * |
     */
    'email' => [
        'default_from_address' => config('mail.from.address', 'noreply@example.com'),
        'default_from_name' => config('mail.from.name', '{{company_name}}'),
        'default_admin_email' => 'admin@example.com',
        'default_developer_email' => 'developer@example.com',
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Path Configuration
     * |--------------------------------------------------------------------------
     * |
     * | Default paths that can be customized per project.
     * |
     */
    'paths' => [
        'default_avatar_path' => '/images/avatars/default.svg',
        'default_image_path' => '/images/default.jpg',
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Template Variables
     * |--------------------------------------------------------------------------
     * |
     * | Available template variables that can be used in notification templates.
     * |
     */
    'template_variables' => [
        'company_name' => '{{company_name}}',
        'team_name' => '{{team_name}}',
        'clinic_name' => '{{clinic_name}}',
        'webhook_base' => '{{webhook_base}}',
        'repository_url' => '{{repository_url}}',
        'user_name' => '{{user_name}}',
        'appointment_date' => '{{appointment_date}}',
        'appointment_time' => '{{appointment_time}}',
    ],
];
