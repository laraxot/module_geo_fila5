<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Dashboard',
        'icon' => 'heroicon-o-home',
        'sort' => 1,
    ],
    'sections' => [
        'stats' => [
            'label' => 'General Statistics',
            'description' => 'Summary of notifications sent and scheduled',
        ],
        'recent_activity' => [
            'label' => 'Recent Activity',
            'description' => 'Last notifications processed by the system',
        ],
        'charts' => [
            'label' => 'Activity Charts',
            'description' => 'Visual representation of notification trends',
        ],
    ],
    'widgets' => [
        'total_sent' => [
            'label' => 'Total Sent',
            'description' => 'Total number of notifications successfully sent',
        ],
        'pending' => [
            'label' => 'Pending',
            'description' => 'Notifications waiting to be processed',
        ],
        'failed' => [
            'label' => 'Failed',
            'description' => 'Notifications that encountered an error',
        ],
        'active_channels' => [
            'label' => 'Active Channels',
            'description' => 'Number of communication channels currently enabled',
        ],
    ],
    'messages' => [
        'success' => 'Operation completed successfully',
        'error' => 'An error occurred during the operation',
        'no_data' => 'No data available for the selected period',
        'loading' => 'Loading data...',
    ],
    'label' => 'Dashboard',
    'plural_label' => 'Dashboards',
    'fields' => [
    ],
    'actions' => [
    ],
];
