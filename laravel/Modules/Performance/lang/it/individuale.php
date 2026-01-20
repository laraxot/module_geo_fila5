<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Performance Individuale',
        'plural' => 'Performance Individuali',
        'group' => 'Admin',
        'label' => 'Performance Individuale',
        'sort' => 37,
        'icon' => 'performance-individuale-outline',
    ],
    'fields' => [
        'ha_diritto' => [
            'label' => 'Ha Diritto',
            'placeholder' => 'Indica se ha diritto alla valutazione',
            'help' => 'Stato del diritto alla valutazione',
        ],
        'motivo' => [
            'label' => 'Motivo',
            'placeholder' => 'Specifica il motivo',
            'help' => 'Motivazione della valutazione',
        ],
        'mail_sended_at' => [
            'label' => 'Data Invio Mail',
            'placeholder' => 'Data di invio della mail',
            'help' => 'Data in cui è stata inviata la mail di notifica',
        ],
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome della performance individuale',
        ],
        'guard_name' => [
            'label' => 'Sistema di Protezione',
            'placeholder' => 'Seleziona il sistema',
            'help' => 'Sistema di protezione utilizzato',
        ],
        'permissions' => [
            'label' => 'Permessi',
            'placeholder' => 'Seleziona i permessi',
            'help' => 'Permessi associati',
        ],
        'updated_at' => [
            'label' => 'Aggiornato il',
            'help' => 'Data ultimo aggiornamento',
        ],
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome del dipendente',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome',
            'help' => 'Cognome del dipendente',
        ],
        'select_all' => [
            'label' => 'Seleziona Tutti',
            'message' => 'Seleziona tutti gli elementi',
        ],
        'risultati_ottenuti' => [
            'label' => 'Conseguimento degli obiettivi',
            'help' => 'Descrizione dei risultati ottenuti',
        ],
        'qualita_prestazione' => [
            'label' => 'Qualità della Prestazione',
            'help' => 'Valutazione della qualità della prestazione',
        ],
        'arricchimento_professionale' => [
            'label' => 'Arricchimento Professionale',
            'help' => 'Descrizione dell\'arricchimento professionale',
        ],
        'impegno' => [
            'label' => 'Impegno',
            'help' => 'Valutazione dell\'impegno',
        ],
        'esperienza_acquisita' => [
            'label' => 'Esperienza Acquisita',
            'help' => 'Descrizione dell\'esperienza acquisita',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'value' => [
            'label' => 'value',
        ],
        'fill' => [
            'label' => 'fill',
        ],
        'delete' => [
            'label' => 'delete',
        ],
        'edit' => [
            'label' => 'edit',
        ],
        'view' => [
            'label' => 'view',
        ],
        'create' => [
            'label' => 'create',
        ],
        'anno' => [
            'label' => 'anno',
            'description' => 'anno',
            'helper_text' => 'anno',
            'placeholder' => 'anno',
        ],
        'al' => [
            'label' => 'al',
            'description' => 'al',
        ],
        'dal' => [
            'label' => 'dal',
        ],
        'repar_txt' => [
            'label' => 'repar_txt',
        ],
        'repar' => [
            'label' => 'repar',
        ],
        'stabi_txt' => [
            'label' => 'stabi_txt',
        ],
        'stabi' => [
            'label' => 'stabi',
        ],
        'disci1_txt' => [
            'label' => 'disci1_txt',
        ],
        'disci1' => [
            'label' => 'disci1',
        ],
        'cognome' => [
            'label' => 'cognome',
        ],
        'nome' => [
            'label' => 'nome',
        ],
        'matr' => [
            'label' => 'matr',
        ],
        'email' => [
            'label' => 'email',
        ],
        'totale_punteggio' => [
            'label' => 'totale_punteggio',
        ],
        'propro' => [
            'label' => 'propro',
        ],
        'posfun' => [
            'label' => 'posfun',
        ],
        'categoria_eco' => [
            'label' => 'categoria_eco',
        ],
        'categoria_ecoval' => [
            'label' => 'categoria_ecoval',
        ],
        'posfunval' => [
            'label' => 'posfunval',
        ],
        'posiz' => [
            'label' => 'posiz',
        ],
        'posiz_txt' => [
            'label' => 'posiz_txt',
        ],
        'valutatore_id' => [
            'label' => 'valutatore_id',
        ],
        'hh_assenza_dalal' => [
            'description' => 'hh_assenza_dalal',
            'helper_text' => 'hh_assenza_dalal',
            'placeholder' => 'hh_assenza_dalal',
            'label' => 'hh_assenza_dalal',
        ],
        'gg_assenza_dalal' => [
            'description' => 'gg_assenza_dalal',
            'helper_text' => 'gg_assenza_dalal',
            'placeholder' => 'gg_assenza_dalal',
            'label' => 'gg_assenza_dalal',
        ],
        'pdf' => [
            'label' => 'pdf',
        ],
        'anno_valutatore' => [
            'label' => 'anno_valutatore',
        ],
        'motivo/invio_email' => [
            'label' => 'motivo/invio_email',
        ],
        'layout' => [
            'label' => 'layout',
        ],
    ],
    'actions' => [
        'copy_from_organizzativa' => [
            'label' => 'Copia da Organizzativa',
            'help' => 'Copia i dati dalla scheda organizzativa',
        ],
        'import' => [
            'fields' => [
                'import_file' => [
                    'label' => 'File da importare',
                    'placeholder' => 'Seleziona un file XLS o CSV',
                    'help' => 'Formati supportati: XLS, XLSX, CSV',
                ],
            ],
        ],
        'export' => [
            'filename_prefix' => 'Aree al',
            'columns' => [
                'name' => [
                    'label' => 'Nome area',
                    'help' => 'Nome dell\'area di performance',
                ],
                'parent_name' => [
                    'label' => 'Area Superiore',
                    'help' => 'Nome dell\'area di livello superiore',
                ],
            ],
        ],
        'populate_year' => [
            'label' => 'populate_year',
        ],
        'copy_from_last_year_' => [
            'label' => 'copy_from_last_year_',
        ],
    ],
    'messages' => [
        'import' => [
            'success' => 'Importazione completata con successo',
            'error' => 'Errore durante l\'importazione',
        ],
        'export' => [
            'success' => 'Esportazione completata con successo',
            'error' => 'Errore durante l\'esportazione',
        ],
        'save' => [
            'success' => 'Performance individuale salvata con successo',
            'error' => 'Errore durante il salvataggio',
        ],
        'delete' => [
            'success' => 'Performance individuale eliminata con successo',
            'error' => 'Errore durante l\'eliminazione',
        ],
    ],
    'title' => 'individuale',
    'model' => [
        'label' => 'individuale.model',
    ],
];
