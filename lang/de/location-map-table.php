<?php

declare(strict_types=1);

<<<<<<< HEAD
=======
// Geo translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: ≥5% comment lines on files >100 LOC.
// Canon: Modules/Geo/docs/wiki — domain i18n only.
// File: lang/de/location-map-table.php
>>>>>>> laraxot/dev
return [
    'navigation' => [
        'label' => 'Tabella Posizioni',
        'group' => 'Gestione Territorio',
        'icon' => 'ui-geo-location',
        'sort' => '15',
    ],
    'table' => [
        'columns' => [
            'name' => 'Nome',
            'address' => 'Indirizzo',
            'coordinates' => 'Coordinate',
            'actions' => 'Azioni',
        ],
        'filters' => [
            'with_coordinates' => 'Con coordinate',
            'without_coordinates' => 'Senza coordinate',
        ],
    ],
    'actions' => [
        'view_on_map' => 'Visualizza sulla mappa',
        'edit_coordinates' => 'Modifica coordinate',
        'export' => 'Esporta dati',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'fields' => [
    ],
];
