<?php

declare(strict_types=1);

<<<<<<< HEAD
=======
// Geo translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: ≥5% comment lines on files >100 LOC.
// Canon: Modules/Geo/docs/wiki — domain i18n only.
// File: lang/en/setting.php
>>>>>>> laraxot/dev
return [
    'navigation' => [
        'name' => 'Impostazioni Geo',
        'plural' => 'Impostazioni Geo',
        'group' => [
            'name' => 'Geo',
            'description' => 'Configurazione del modulo geografico',
        ],
        'label' => 'Impostazioni',
        'sort' => '34',
        'icon' => 'ui-settings',
    ],
    'fields' => [
        'default_map_provider' => [
            'label' => 'Provider Mappa Predefinito',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'api_keys' => [
            'google_maps' => 'API Key Google Maps',
            'mapbox' => 'API Key Mapbox',
            'here' => 'API Key HERE Maps',
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'default_location' => [
            'lat' => 'Latitudine Predefinita',
            'lng' => 'Longitudine Predefinita',
            'zoom' => 'Zoom Predefinito',
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'display_options' => [
            'units' => 'Unità di Misura',
            'language' => 'Lingua Mappe',
            'theme' => 'Tema Mappe',
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'providers' => [
        'google' => 'Google Maps',
        'mapbox' => 'Mapbox',
        'here' => 'HERE Maps',
        'osm' => 'OpenStreetMap',
    ],
    'units' => [
        'metric' => 'Metrico',
        'imperial' => 'Imperiale',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'actions' => [
    ],
];
