<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Scheda PO',
        'plural' => 'Scheda PO',
        'group' => [
            'name' => 'Scheda',
            'description' => 'Gestione delle schede di valutazione delle Posizioni Organizzative',
        ],
        'label' => 'Scheda PO',
        'sort' => 32,
        'icon' => 'performance-region-document',
    ],
    'fields' => [
        'posizione' => [
            'label' => 'Posizione Organizzativa',
            'placeholder' => 'Seleziona la PO',
            'help' => 'Posizione Organizzativa da valutare',
        ],
        'responsabile' => [
            'label' => 'Responsabile',
            'placeholder' => 'Seleziona il responsabile',
            'help' => 'Responsabile della posizione organizzativa',
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
        'risultati_ottenuti' => 'Conseguimento degli obiettivi',
        'qualita_prestazione' => 'Monitoraggio delle attività afferenti i processi',
        'arricchimento_professionale' => 'Attuazione di strategie di miglioramento del "clima lavorativo"',
        'impegno' => 'Organizzazione della programmazione delle attività',
        'esperienza_acquisita' => 'Focalizzazione dei processi di comunicazione sulla condivisione dei risultati',
        'punteggio_totale' => [
            'label' => 'Punteggio Totale',
            'help' => 'Punteggio complessivo della valutazione',
        ],
        'updated_at' => [
            'label' => 'updated_at',
        ],
        'created_at' => [
            'label' => 'created_at',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
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
        'fill' => [
            'label' => 'fill',
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
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
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
        'calculate' => [
            'label' => 'Calcola Punteggio',
            'success' => 'Punteggio calcolato con successo',
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
            'pending' => 'In Attesa di Approvazione',
            'approved' => 'Approvata',
            'rejected' => 'Rifiutata',
        ],
    ],
    'model' => [
        'label' => 'individuale po.model',
    ],
    'label' => 'individuale po',
];
