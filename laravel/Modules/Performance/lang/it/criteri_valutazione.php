<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Criteri di Valutazione',
        'plural' => 'Criteri di Valutazione',
        'group' => [
            'name' => 'Criteri',
            'description' => 'Gestione dei criteri di valutazione',
        ],
        'label' => 'Criteri di Valutazione',
        'sort' => 53,
        'icon' => 'performance-criteria-outline',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome del criterio',
            'help' => 'Nome identificativo del criterio',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci la descrizione',
            'help' => 'Descrizione dettagliata del criterio',
        ],
        'peso' => [
            'label' => 'Peso',
            'placeholder' => 'Inserisci il peso',
            'help' => 'Peso del criterio nella valutazione (1-100)',
        ],
        'tipo' => [
            'label' => 'Tipo',
            'placeholder' => 'Seleziona il tipo',
            'help' => 'Tipologia del criterio',
            'options' => [
                'quantitativo' => 'Quantitativo',
                'qualitativo' => 'Qualitativo',
            ],
        ],
        'attivo' => [
            'label' => 'Attivo',
            'help' => 'Indica se il criterio è attualmente in uso',
        ],
        'guard_name' => [
            'label' => 'Sistema di Protezione',
            'placeholder' => 'Seleziona il sistema',
            'help' => 'Sistema di autenticazione utilizzato',
        ],
        'permissions' => [
            'label' => 'Permessi',
            'placeholder' => 'Seleziona i permessi',
            'help' => 'Permessi associati al criterio',
        ],
        'updated_at' => [
            'label' => 'Ultimo aggiornamento',
            'help' => 'Data e ora dell\'ultima modifica',
        ],
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome del valutatore',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome',
            'help' => 'Cognome del valutatore',
        ],
        'select_all' => [
            'label' => 'Seleziona Tutto',
            'message' => 'Seleziona tutti gli elementi disponibili',
        ],
        'created_at' => [
            'label' => 'created_at',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'value' => [
            'label' => 'value',
        ],
        'delete' => [
            'label' => 'delete',
        ],
        'id_padre' => [
            'label' => 'id_padre',
        ],
        'nome' => [
            'label' => 'nome',
        ],
        'label' => [
            'label' => 'label',
        ],
        'descr' => [
            'label' => 'descr',
        ],
        'post_type' => [
            'label' => 'post_type',
        ],
        'posizione' => [
            'label' => 'posizione',
        ],
        'anno' => [
            'label' => 'anno',
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
        'created_by' => [
            'label' => 'created_by',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuovo Criterio',
            'success' => 'Criterio creato con successo',
        ],
        'edit' => [
            'label' => 'Modifica',
            'success' => 'Criterio aggiornato con successo',
        ],
        'delete' => [
            'label' => 'Elimina',
            'success' => 'Criterio eliminato con successo',
        ],
        'import' => [
            'label' => 'Importa',
            'fields' => [
                'import_file' => [
                    'label' => 'File da importare',
                    'placeholder' => 'Seleziona un file XLS o CSV',
                    'help' => 'Formati supportati: XLS, XLSX, CSV',
                ],
            ],
        ],
        'export' => [
            'label' => 'Esporta',
            'filename_prefix' => 'Criteri_Valutazione_',
            'columns' => [
                'name' => [
                    'label' => 'Nome Criterio',
                    'help' => 'Nome del criterio di valutazione',
                ],
                'parent_name' => [
                    'label' => 'Gruppo',
                    'help' => 'Gruppo di appartenenza del criterio',
                ],
            ],
        ],
    ],
    'messages' => [
        'validation' => [
            'peso' => [
                'required' => 'Il peso è obbligatorio',
                'numeric' => 'Il peso deve essere numerico',
                'min' => 'Il peso minimo è 1',
                'max' => 'Il peso massimo è 100',
            ],
        ],
        'import' => [
            'success' => 'Importazione completata con successo',
            'error' => 'Errore durante l\'importazione',
        ],
        'export' => [
            'success' => 'Esportazione completata con successo',
            'error' => 'Errore durante l\'esportazione',
        ],
        'save' => [
            'success' => 'Criterio salvato con successo',
            'error' => 'Errore durante il salvataggio',
        ],
        'delete' => [
            'success' => 'Criterio eliminato con successo',
            'error' => 'Errore durante l\'eliminazione',
        ],
    ],
    'model' => [
        'label' => 'criteri valutazione.model',
    ],
];
