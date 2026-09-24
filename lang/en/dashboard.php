<?php

declare(strict_types=1);

// Geo translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: ≥5% comment lines on files >100 LOC.
// Canon: Modules/Geo/docs/wiki — domain i18n only.
// File: lang/en/dashboard.php
return [
    'navigation' => [
        'name' => 'Dashboard Geo',
        'plural' => 'Dashboard Geo',
        'group' => [
            'name' => 'Geo',
            'description' => 'Panoramica delle informazioni geografiche',
        ],
        'label' => 'Dashboard',
        'sort' => '30',
        'icon' => 'ui-dashboard',
    ],
    'widgets' => [
        'total_locations' => 'Totale Località',
        'total_places' => 'Totale Luoghi',
        'recent_activity' => 'Attività Recente',
        'popular_places' => 'Luoghi Popolari',
    ],
    'charts' => [
        'locations_by_type' => 'Località per Tipo',
        'places_by_category' => 'Luoghi per Categoria',
        'activity_timeline' => 'Timeline Attività',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'fields' => [
    ],
    'actions' => [
    ],
];
