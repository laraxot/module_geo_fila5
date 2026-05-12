<?php

declare(strict_types=1);

return [
    'actions' => [
        'copy_valutatore_id' => [
            'label' => 'Copia valutatore da Individuale',
            'success' => 'Valutatori copiati con successo: :count record aggiornati.',
            'error' => 'Errore durante la copia dei valutatori.',
            'confirm' => 'Vuoi copiare il campo valutatore_id da performance_individuale per tutte le righe con stesso anno, ente, matr, stabi?',
        ],
        'create' => [
            'label' => 'create',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'copy_from_last_year_' => [
            'label' => 'copy_from_last_year_',
            'icon' => 'copy_from_last_year_',
            'tooltip' => 'copy_from_last_year_',
        ],
        'populate_year' => [
            'label' => 'populate_year',
            'icon' => 'populate_year',
            'tooltip' => 'populate_year',
        ],
        'trova_esclusi' => [
            'label' => 'trova_esclusi',
            'icon' => 'trova_esclusi',
            'tooltip' => 'trova_esclusi',
        ],
        'export_xls' => [
            'label' => 'export_xls',
            'icon' => 'export_xls',
            'tooltip' => 'export_xls',
        ],
        'copy_valutatore_id_from_individuale' => [
            'label' => 'copy_valutatore_id_from_individuale',
            'icon' => 'copy_valutatore_id_from_individuale',
            'tooltip' => 'copy_valutatore_id_from_individuale',
        ],
        'view' => [
            'label' => 'view',
            'icon' => 'view',
            'tooltip' => 'view',
        ],
        'edit' => [
            'label' => 'edit',
            'icon' => 'edit',
            'tooltip' => 'edit',
        ],
        'delete' => [
            'label' => 'delete',
            'icon' => 'delete',
            'tooltip' => 'delete',
        ],
        'layout' => [
            'label' => 'layout',
            'icon' => 'layout',
            'tooltip' => 'layout',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
            'icon' => 'applyFilters',
            'tooltip' => 'applyFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
            'icon' => 'openFilters',
            'tooltip' => 'openFilters',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
            'icon' => 'resetFilters',
            'tooltip' => 'resetFilters',
        ],
        'applyTableColumnManager' => [
            'label' => 'applyTableColumnManager',
            'icon' => 'applyTableColumnManager',
            'tooltip' => 'applyTableColumnManager',
        ],
        'openColumnManager' => [
            'label' => 'openColumnManager',
            'icon' => 'openColumnManager',
            'tooltip' => 'openColumnManager',
        ],
        'resetColumnManager' => [
            'label' => 'resetColumnManager',
            'icon' => 'resetColumnManager',
            'tooltip' => 'resetColumnManager',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
            'icon' => 'reorderRecords',
            'tooltip' => 'reorderRecords',
        ],
        'profile' => [
            'label' => 'profile',
            'icon' => 'profile',
            'tooltip' => 'profile',
        ],
        'logout' => [
            'label' => 'logout',
            'icon' => 'logout',
            'tooltip' => 'logout',
        ],
        'compila' => [
            'label' => 'compila',
            'icon' => 'compila',
            'tooltip' => 'compila',
        ],
        'pdf' => [
            'label' => 'pdf',
            'icon' => 'pdf',
            'tooltip' => 'pdf',
        ],
        'send_mail' => [
            'label' => 'send_mail',
            'icon' => 'send_mail',
            'tooltip' => 'send_mail',
        ],
        'zip_schede' => [
            'label' => 'zip_schede',
            'icon' => 'zip_schede',
            'tooltip' => 'zip_schede',
        ],
    ],
    'model' => [
        'label' => 'organizzativa.model',
    ],
    'navigation' => [
        'name' => 'Organizzativa',
        'plural' => 'Organizzative',
        'label' => 'Organizzative',
        'sort' => 80,
        'icon' => 'heroicon-o-chart-bar',
        'group' => 'Performance',
    ],
    'fields' => [
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'type' => [
            'label' => 'type',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'ha_diritto' => [
            'label' => 'ha_diritto',
        ],
        'motivo' => [
            'label' => 'motivo',
        ],
        'perc_parttimepond_dalal' => [
            'label' => 'perc_parttimepond_dalal',
        ],
        'gg_presenza_dalal' => [
            'label' => 'gg_presenza_dalal',
        ],
        'gg_assenza_dalal' => [
            'label' => 'gg_assenza_dalal',
        ],
        'hh_assenza_dalal' => [
            'label' => 'hh_assenza_dalal',
        ],
        'quota_teorica' => [
            'label' => 'quota_teorica',
        ],
        'budget_assegnato' => [
            'label' => 'budget_assegnato',
        ],
        'quota_effettiva' => [
            'label' => 'quota_effettiva',
        ],
        'resti' => [
            'label' => 'resti',
        ],
        'resti_pond' => [
            'label' => 'resti_pond',
        ],
        'importo_totale' => [
            'label' => 'importo_totale',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'valutatore_id' => [
            'label' => 'valutatore_id',
        ],
        'soldi' => [
            'label' => 'soldi',
        ],
        'info' => [
            'label' => 'info',
        ],
        'anno' => [
            'label' => 'anno',
        ],
        'value' => [
            'label' => 'value',
            'placeholder' => 'value',
            'helper_text' => 'value',
            'description' => 'value',
        ],
    ],
    'label' => 'organizzativa',
];
