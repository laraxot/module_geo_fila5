<?php

declare(strict_types=1);

// Geo translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: ≥5% comment lines on files >100 LOC.
// Canon: Modules/Geo/docs/wiki — domain i18n only.
// File: lang/en/latitude_longitude_input.php
return [
    'actions' => [
        'fullscreen_enter' => 'View fullscreen',
        'fullscreen_exit' => 'Exit fullscreen',
        'use_current_position' => 'Use current position',
    ],
    'layers' => [
        'osm' => 'Map',
        'satellite' => 'Satellite',
        'terrain' => 'Terrain',
    ],
    'fields' => [
        'latitude' => [
            'label' => 'latitude',
            'placeholder' => 'latitude',
            'helper_text' => 'latitude',
            'description' => 'latitude',
        ],
        'longitude' => [
            'label' => 'longitude',
            'placeholder' => 'longitude',
            'helper_text' => 'longitude',
            'description' => 'longitude',
        ],
    ],
];
