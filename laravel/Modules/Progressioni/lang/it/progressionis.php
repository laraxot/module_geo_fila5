<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'progressione',
        'plural' => 'progressioni',
        'group' => [
            'name' => 'Gestione Progressioni',
            'description' => 'Gestione completa delle progressioni di carriera',
        ],
    ],
    'actions' => [
        'import' => [
            'name' => 'Importa da file',
            'fields' => [
                'import_file' => 'Seleziona un file XLS o CSV da caricare',
            ],
        ],
        'export' => [
            'name' => 'Esporta dati',
            'filename_prefix' => 'Aree al',
            'columns' => [
                'name' => 'Nome area',
                'parent_name' => 'Nome area livello superiore',
            ],
        ],
    ],
    'fields' => [
        'name' => 'Nome',
        'parent' => 'Padre',
        'parent.name' => 'Padre',
        'parent_name' => 'Padre',
        'assets' => 'assets',
        'id' => [
            'label' => 'id',
        ],
        'id_placeholder' => ' ',
        'cognome' => [
            'label' => 'cognome',
        ],
        'cognome_placeholder' => ' ',
        'nome' => 'Nome',
        'nome_placeholder' => ' ',
        'ente' => 'ente',
        'matr' => [
            'label' => 'matr',
        ],
        'ha_diritto' => [
            'label' => 'ha_diritto',
        ],
        'motivo' => [
            'label' => 'motivo',
        ],
        'motivo_placeholder' => ' ',
        'stabi' => 'stabi',
        'stabi_txt' => 'stabi_txt',
        'repar' => 'repar',
        'repar_txt' => 'repar_txt',
        'rep2kd' => 'rep2kd',
        'rep2ka' => 'rep2ka',
        'propro' => 'propro',
        'posfun' => 'posfun',
        'qua2kd' => 'qua2kd',
        'qua2ka' => 'qua2ka',
        'categoria_eco' => 'categoria_eco',
        'anno' => [
            'label' => 'anno',
        ],
        'criteri' => [
            'label' => 'criteri',
        ],
        'gg' => [
            'label' => 'gg',
        ],
        'gg_no_asz' => [
            'label' => 'gg_no_asz',
        ],
        'gg_asz' => [
            'label' => 'gg_asz',
        ],
        'gg_cateco_no_posfun_no_asz' => [
            'label' => 'gg_cateco_no_posfun_no_asz',
        ],
        'eta' => [
            'label' => 'eta',
        ],
        'periodo' => [
            'label' => 'periodo',
        ],
        'dal' => [
            'label' => 'dal',
        ],
        'al' => [
            'label' => 'al',
        ],
    ],
    'schede' => [
        'field' => [
            'stabi' => 'stabi',
            'valutatore_id' => 'Valutatore',
            'valutatore_id_placeholder' => '---',
            'year' => 'Anno',
            'year_placeholder' => 'anno es 2019',
            'sort_by_placeholder' => '  ',
            'sort_order_placeholder' => '  ',
        ],
    ],
    'tab' => [
        'index' => 'lista',
        'create' => 'Aggiungi.',
    ],
];
