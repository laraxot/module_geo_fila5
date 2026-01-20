<?php

declare(strict_types=1);

return [
    'title' => 'PTVX - Performance Management System',
    'description' => 'Sistema di gestione performance per enti pubblici',
    'sitename' => 'PTVX',
    'subtitle' => 'Performance & HR Management',
    'author' => 'Laraxot Team',
    'copyright' => '© 2025 PTVX. All rights reserved.',
    
    'navigation' => [
        'name' => 'Meta Tag',
        'plural' => 'Meta Tags',
        'group' => [
            'name' => 'System',
            'description' => 'Meta tag and SEO management',
        ],
        'label' => 'metatag',
        'sort' => '16',
        'icon' => 'xot-metatag',
    ],
    
    'fields' => [
        'basic' => [
            'title' => [
                'label' => 'Title',
                'placeholder' => 'Enter page title',
                'help' => 'Meta title - max 60 characters',
            ],
            'description' => [
                'label' => 'Description',
                'placeholder' => 'Enter page description',
                'help' => 'Meta description - max 160 characters',
            ],
            'keywords' => [
                'label' => 'Keywords',
                'placeholder' => 'Enter keywords separated by comma',
                'help' => 'Meta keywords - max 10 keywords',
            ],
        ],
    ],
];
