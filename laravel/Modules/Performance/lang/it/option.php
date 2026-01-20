<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Opzioni Performance',
        'plural' => 'Opzioni Performance',
        'group' => [
            'name' => 'Valutazione & KPI',
            'description' => 'Gestione delle opzioni di performance',
        ],
        'label' => 'performance_options',
        'sort' => 57,
        'icon' => 'performance-option-outline',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
        ],
        'guard_name' => 'Guard',
        'permissions' => 'Permessi',
        'updated_at' => [
            'label' => 'Aggiornato il',
        ],
        'first_name' => 'Nome',
        'last_name' => 'Cognome',
        'select_all' => [
            'name' => 'Seleziona Tutti',
            'message' => '',
        ],
        'post_type' => [
            'label' => 'post_type',
        ],
        'post_id' => [
            'label' => 'post_id',
        ],
        'meta_key' => [
            'label' => 'meta_key',
        ],
        'meta_value' => [
            'label' => 'meta_value',
        ],
        'created_at' => [
            'label' => 'created_at',
        ],
        'create' => [
            'label' => 'create',
        ],
        'view' => [
            'label' => 'view',
        ],
        'edit' => [
            'label' => 'edit',
        ],
        'delete' => [
            'label' => 'delete',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'year' => [
            'label' => 'year',
        ],
        'txt1' => [
            'label' => 'txt1',
        ],
        'txt' => [
            'label' => 'txt',
        ],
        'value' => [
            'label' => 'value',
        ],
        'id' => [
            'label' => 'id',
        ],
        'parent_id' => [
            'label' => 'parent_id',
        ],
        'option_type' => [
            'label' => 'option_type',
        ],
    ],
    'actions' => [
        'import' => [
            'fields' => [
                'import_file' => 'Seleziona un file XLS o CSV da caricare',
            ],
        ],
        'export' => [
            'filename_prefix' => 'Aree al',
            'columns' => [
                'name' => 'Nome area',
                'parent_name' => 'Nome area livello superiore',
            ],
        ],
        'create' => [
            'label' => 'create',
        ],
    ],
    'model' => [
        'label' => 'option.model',
    ],
];
