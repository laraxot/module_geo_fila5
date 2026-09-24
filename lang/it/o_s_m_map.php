<?php

declare(strict_types=1);

// Geo translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: ≥5% comment lines on files >100 LOC.
// Canon: Modules/Geo/docs/wiki — domain i18n only.
// File: lang/it/o_s_m_map.php
return [
    'navigation' => [
        'label' => 'Navigation Label',
        'group' => 'Geo',
    ],
    'label' => 'O S M Map',
    'plural_label' => 'O S M Map (Plurale)',
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
            'label' => 'Crea O S M Map',
        ],
        'edit' => [
            'label' => 'Modifica O S M Map',
        ],
        'delete' => [
            'label' => 'Elimina O S M Map',
        ],
    ],
];
