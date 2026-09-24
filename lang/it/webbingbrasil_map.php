<?php

declare(strict_types=1);

// Geo translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: ≥5% comment lines on files >100 LOC.
// Canon: Modules/Geo/docs/wiki — domain i18n only.
// File: lang/it/webbingbrasil_map.php
return [
    'navigation' => [
        'label' => 'Navigation Label',
        'group' => 'Geo',
    ],
    'label' => 'Webbingbrasil Map',
    'plural_label' => 'Webbingbrasil Map (Plurale)',
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
            'label' => 'Crea Webbingbrasil Map',
        ],
        'edit' => [
            'label' => 'Modifica Webbingbrasil Map',
        ],
        'delete' => [
            'label' => 'Elimina Webbingbrasil Map',
        ],
    ],
];
