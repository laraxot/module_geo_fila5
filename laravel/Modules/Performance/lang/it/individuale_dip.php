<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Scheda Dipendenti',
        'plural' => 'Scheda Dipendenti',
        'group' => [
            'name' => 'Scheda',
            'description' => 'Gestione delle schede di valutazione dei dipendenti',
        ],
        'label' => 'Scheda Dipendenti',
        'sort' => 31,
        'icon' => 'performance-region-document',
    ],
    'fields' => [
        'dipendente' => [
            'label' => 'Dipendente',
            'placeholder' => 'Seleziona il dipendente',
            'help' => 'Dipendente da valutare',
        ],
        'matricola' => [
            'label' => 'Matricola',
            'placeholder' => 'Inserisci la matricola',
            'help' => 'Numero di matricola del dipendente',
        ],
        'periodo' => [
            'label' => 'Periodo',
            'placeholder' => 'Seleziona il periodo',
            'help' => 'Periodo di valutazione',
            'options' => [
                'mensile' => 'Mensile',
                'trimestrale' => 'Trimestrale',
                'semestrale' => 'Semestrale',
                'annuale' => 'Annuale',
            ],
        ],
        'risultati_ottenuti' => 'Contributo al conseguimento degli obiettivi',
        'qualita_prestazione' => 'Rapporto con l\'utenza interna ed esterna',
        'arricchimento_professionale' => 'Proposte di azioni migliorative',
        'impegno' => 'Clima sociale interno',
        'note' => [
            'label' => 'Note',
            'placeholder' => 'Inserisci eventuali note',
            'help' => 'Note aggiuntive sulla valutazione',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'ha_diritto' => [
            'label' => 'ha_diritto',
        ],
        'motivo' => [
            'label' => 'motivo',
        ],
        'mail_sended_at' => [
            'label' => 'mail_sended_at',
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
        'disci1' => [
            'label' => 'disci1',
        ],
        'disci1_txt' => [
            'label' => 'disci1_txt',
        ],
        'stabi' => [
            'label' => 'stabi',
        ],
        'stabi_txt' => [
            'label' => 'stabi_txt',
        ],
        'repar' => [
            'label' => 'repar',
        ],
        'repar_txt' => [
            'label' => 'repar_txt',
        ],
        'dal' => [
            'label' => 'dal',
        ],
        'al' => [
            'label' => 'al',
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
        'value' => [
            'label' => 'value',
        ],
        'fill' => [
            'label' => 'compila',
            'icon' => 'performance-region-document',
        ],
        'esperienza_acquisita' => 'Gestione delle risorse',
        'valutatore_id' => [
            'label' => 'valutatore_id',
        ],
        'pdf' => [
            'label' => 'pdf',
        ],
        'layout' => [
            'label' => 'layout',
        ],
        'anno_valutatore' => [
            'label' => 'anno_valutatore',
        ],
        'motivo/invio_email' => [
            'label' => 'motivo/invio_email',
        ],
    ],
    'actions' => [
        'evaluate' => [
            'label' => 'Valuta',
            'success' => 'Valutazione completata con successo',
        ],
        'approve' => [
            'label' => 'Approva',
            'success' => 'Valutazione approvata con successo',
        ],
        'reject' => [
            'label' => 'Rifiuta',
            'success' => 'Valutazione rifiutata',
        ],
        'create' => [
            'label' => 'create',
        ],
        'copy_from_organizzativa' => [
            'label' => 'copy_from_organizzativa',
        ],
        'populate_year' => [
            'label' => 'populate_year',
        ],
        'copy_from_last_year_' => [
            'label' => 'copy_from_last_year_',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
            'label' => 'logout',
        ],
    ],
    'messages' => [
        'validation' => [
            'required' => 'Campo obbligatorio',
            'numeric' => 'Il valore deve essere numerico',
            'min' => 'Il valore minimo è :min',
            'max' => 'Il valore massimo è :max',
        ],
        'status' => [
            'draft' => 'Bozza',
            'pending' => 'In Attesa',
            'approved' => 'Approvata',
            'rejected' => 'Rifiutata',
        ],
    ],
    'model' => [
        'label' => 'individuale dip.model',
    ],
];
