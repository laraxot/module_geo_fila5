<?php

declare(strict_types=1);

// Geo translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: ≥5% comment lines on files >100 LOC.
// Canon: Modules/Geo/docs/wiki — domain i18n only.
// File: lang/en/fields.php
return [
    'region' => [
        'label' => 'Region',
        'placeholder' => 'Select a region',
        'tooltip' => 'Select the region of belonging',
    ],
    'province' => [
        'label' => 'Province',
        'placeholder' => 'Select a province',
        'tooltip' => 'Select the province of belonging',
    ],
    'city' => [
        'label' => 'City',
        'placeholder' => 'Select a city',
        'tooltip' => 'Select the city of belonging',
    ],
    'cap' => [
        'label' => 'Postal Code',
        'placeholder' => 'Select a postal code',
        'tooltip' => 'Postal code of the selected city',
    ],
    'navigation' => [
        'label' => 'Missing Navigation Label',
        'plural_label' => 'Missing Navigation Plural Label',
        'group' => 'Missing Group',
        'icon' => 'heroicon-o-puzzle-piece',
        'sort' => 100,
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'fields' => [
    ],
    'actions' => [
    ],
];
