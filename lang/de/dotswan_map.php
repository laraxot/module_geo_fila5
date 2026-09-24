<?php

declare(strict_types=1);

// Geo translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: ≥5% comment lines on files >100 LOC.
// Canon: Modules/Geo/docs/wiki — domain i18n only.
// File: lang/de/dotswan_map.php
return [
    'navigation' => [
        'label' => 'Navigation Label',
        'group' => 'Geo',
    ],
    'fields' => [
        'location' => [
            'label' => 'location',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'actions' => [
    ],
];
