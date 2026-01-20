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
    ],
];
