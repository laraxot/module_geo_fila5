<?php

declare(strict_types=1);

<<<<<<< HEAD
=======
// Geo translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: ≥5% comment lines on files >100 LOC.
// Canon: Modules/Geo/docs/wiki — domain i18n only.
// File: lang/it/location_map_table.php
>>>>>>> laraxot/dev
return [
    'navigation' => [
        'label' => 'Navigation Label',
        'group' => 'Geo',
    ],
    'label' => 'Location Map Table',
    'plural_label' => 'Location Map Table (Plurale)',
    'fields' => [
        'id' => [
            'label' => 'Identificativo',
            'tooltip' => 'Identificativo univoco del record',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Location Map Table',
        ],
        'edit' => [
            'label' => 'Modifica Location Map Table',
        ],
        'delete' => [
            'label' => 'Elimina Location Map Table',
        ],
    ],
];
