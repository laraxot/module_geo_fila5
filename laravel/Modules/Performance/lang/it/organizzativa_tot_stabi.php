<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Totale Stabilimenti',
        'plural' => 'Totali Stabilimenti',
        'group' => [
            'name' => 'Valutazione',
            'description' => 'Gestione dei totali per stabilimento',
        ],
        'label' => 'totali',
        'sort' => 85,
        'icon' => 'performance-building',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome dello stabilimento',
        ],
        'totale' => [
            'label' => 'Totale',
            'placeholder' => 'Inserisci il totale',
            'help' => 'Totale performance dello stabilimento',
        ],
        'periodo' => [
            'label' => 'Periodo',
            'placeholder' => 'Seleziona il periodo',
            'help' => 'Periodo di riferimento',
        ],
        'guard_name' => [
            'label' => 'Sistema di Protezione',
            'placeholder' => 'Seleziona il sistema',
            'help' => 'Sistema di autenticazione utilizzato',
        ],
        'permissions' => [
            'label' => 'Autorizzazioni',
            'placeholder' => 'Seleziona le autorizzazioni',
            'help' => 'Autorizzazioni associate allo stabilimento',
        ],
        'updated_at' => [
            'label' => 'Ultimo aggiornamento',
            'help' => 'Data e ora dell\'ultima modifica',
        ],
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome del responsabile',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome',
            'help' => 'Cognome del responsabile',
        ],
        'select_all' => [
            'label' => 'Seleziona Tutto',
            'message' => 'Seleziona tutti gli elementi disponibili',
        ],
        'dipendenti' => [
            'label' => 'Dipendenti',
            'placeholder' => 'Numero dipendenti',
            'help' => 'Numero totale dei dipendenti',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuovo Totale',
            'success' => 'Totale creato con successo',
        ],
        'edit' => [
            'label' => 'Modifica',
            'success' => 'Totale aggiornato con successo',
        ],
        'delete' => [
            'label' => 'Elimina',
            'success' => 'Totale eliminato con successo',
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
            'filename_prefix' => 'Totali_Stabilimenti_',
            'columns' => [
                'name' => [
                    'label' => 'Nome Stabilimento',
                    'help' => 'Nome dello stabilimento',
                ],
                'parent_name' => [
                    'label' => 'Area',
                    'help' => 'Area di appartenenza',
                ],
            ],
        ],
    ],
    'messages' => [
        'validation' => [
            'totale' => [
                'required' => 'Il totale è obbligatorio',
                'numeric' => 'Il totale deve essere numerico',
                'min' => 'Il totale deve essere maggiore di zero',
            ],
            'periodo' => [
                'required' => 'Il periodo è obbligatorio',
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
            'success' => 'Totale salvato con successo',
            'error' => 'Errore durante il salvataggio',
        ],
        'delete' => [
            'success' => 'Totale eliminato con successo',
            'error' => 'Errore durante l\'eliminazione',
        ],
    ],
];
