<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Criterio di Valutazione',
        'plural' => 'Criteri di Valutazione',
        'group' => [
            'name' => 'Gestione Progressioni',
            'description' => 'Gestione completa delle progressioni di carriera',
        ],
        'sort' => 3,
        'icon' => 'heroicon-o-clipboard-document-list',
        'label' => 'Criteri di Valutazione',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome del criterio',
            'help' => 'Nome del criterio di valutazione',
        ],
        'parent' => [
            'label' => 'Criterio Padre',
            'placeholder' => 'Seleziona il criterio padre',
            'help' => 'Criterio di livello superiore',
        ],
        'parent_name' => [
            'label' => 'Nome Criterio Padre',
            'help' => 'Nome del criterio di livello superiore',
        ],
        'assets' => [
            'label' => 'Risorse',
            'help' => 'Risorse associate al criterio',
        ],
        'toggleColumns' => [
            'label' => 'Mostra/Nascondi Colonne',
            'help' => 'Gestisci la visibilità delle colonne nella tabella',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'value' => [
            'description' => 'value',
            'helper_text' => 'value',
            'placeholder' => 'value',
            'label' => 'value',
        ],
        'updated_at' => [
            'description' => 'updated_at',
            'helper_text' => 'updated_at',
            'placeholder' => 'updated_at',
            'label' => 'updated_at',
        ],
        'created_at' => [
            'description' => 'created_at',
            'helper_text' => 'created_at',
            'placeholder' => 'created_at',
            'label' => 'created_at',
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
        'layout' => [
            'label' => 'layout',
        ],
    ],
    'actions' => [
        'import' => [
            'label' => 'Importa da file',
            'success' => 'Criteri importati con successo',
            'error' => 'Errore durante l\'importazione dei criteri',
            'confirmation' => 'Sei sicuro di voler importare questo file?',
            'fields' => [
                'import_file' => [
                    'label' => 'Seleziona un file XLS o CSV da caricare',
                    'placeholder' => 'Scegli un file XLS o CSV',
                    'help' => 'Formati supportati: XLS, XLSX, CSV. Dimensione massima: 10MB',
                ],
            ],
        ],
        'export' => [
            'label' => 'Esporta dati',
            'success' => 'Dati esportati con successo',
            'error' => 'Errore durante l\'esportazione',
            'confirmation' => 'Sei sicuro di voler esportare i dati?',
            'filename_prefix' => 'Criteri_Valutazione_',
            'columns' => [
                'name' => [
                    'label' => 'Nome criterio',
                    'help' => 'Nome del criterio di valutazione',
                ],
                'parent_name' => [
                    'label' => 'Nome criterio padre',
                    'help' => 'Nome del criterio di livello superiore',
                ],
            ],
        ],
        'create' => [
            'label' => 'Nuovo criterio',
            'success' => 'Criterio di valutazione creato con successo',
            'error' => 'Errore durante la creazione del criterio',
        ],
        'edit' => [
            'label' => 'Modifica criterio',
            'success' => 'Criterio di valutazione aggiornato con successo',
            'error' => 'Errore durante l\'aggiornamento del criterio',
        ],
        'delete' => [
            'label' => 'Elimina criterio',
            'success' => 'Criterio di valutazione eliminato con successo',
            'error' => 'Errore durante l\'eliminazione del criterio',
            'confirmation' => 'Sei sicuro di voler eliminare questo criterio? Questa azione è irreversibile.',
        ],
        'view' => [
            'label' => 'Visualizza criterio',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
            'label' => 'logout',
        ],
        'profile' => [
            'tooltip' => 'profile',
            'icon' => 'profile',
        ],
    ],
    'tab' => [
        'index' => [
            'label' => 'Lista',
            'help' => 'Visualizza tutti i criteri di valutazione',
        ],
        'create' => [
            'label' => 'Aggiungi',
            'help' => 'Crea un nuovo criterio di valutazione',
        ],
        'edit' => [
            'label' => 'Modifica',
            'help' => 'Modifica il criterio di valutazione',
        ],
    ],
    'messages' => [
        'created' => 'Criterio di valutazione creato con successo',
        'updated' => 'Criterio di valutazione aggiornato con successo',
        'deleted' => 'Criterio di valutazione eliminato con successo',
        'import_success' => 'Importazione completata con successo',
        'export_success' => 'Esportazione completata con successo',
        'error' => 'Si è verificato un errore',
        'warning' => 'Attenzione',
        'info' => 'Informazione',
    ],
    'validation' => [
        'required' => 'Il campo :attribute è obbligatorio',
        'string' => 'Il campo :attribute deve essere una stringa',
        'max' => 'Il campo :attribute non può superare :max caratteri',
        'unique' => 'Il valore del campo :attribute è già presente',
    ],
    'model' => [
        'label' => 'Modello Criteri Valutazione',
        'placeholder' => 'Seleziona modello criteri valutazione',
        'tooltip' => 'Modello dati per i criteri di valutazione',
        'helper_text' => 'Rappresentazione del modello dati utilizzato per definire i criteri di valutazione delle progressioni',
        'help' => 'Modello che definisce la struttura dati per i criteri di valutazione',
    ],
    'label' => 'criteri valutazione',
];
