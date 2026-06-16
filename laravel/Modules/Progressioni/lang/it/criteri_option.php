<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Opzione Criterio',
        'plural' => 'Opzioni Criteri',
        'group' => [
            'name' => 'Gestione Progressioni',
            'description' => 'Gestione completa delle progressioni di carriera',
        ],
        'sort' => 12,
        'icon' => 'heroicon-o-cog-6-tooth',
        'label' => 'Opzioni Criteri',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome dell\'opzione',
            'help' => 'Nome identificativo dell\'opzione criteri',
        ],
        'parent' => [
            'label' => 'Elemento Padre',
            'placeholder' => 'Seleziona l\'elemento padre',
            'help' => 'Elemento di livello superiore nella gerarchia',
        ],
        'parent_name' => [
            'label' => 'Nome Elemento Padre',
            'placeholder' => 'Nome dell\'elemento padre',
            'help' => 'Nome dell\'elemento di livello superiore',
        ],
        'assets' => [
            'label' => 'Risorse',
            'placeholder' => 'Seleziona le risorse associate',
            'help' => 'Risorse collegate a questa opzione criteri',
        ],
        'toggleColumns' => [
            'label' => 'Mostra/Nascondi Colonne',
            'help' => 'Gestisci la visibilità delle colonne nella tabella',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
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
        'gg_asz_cateco_posfun_fuori_sede' => [
            'description' => 'gg_asz_cateco_posfun_fuori_sede',
        ],
        'created_at' => [
            'description' => 'created_at',
            'helper_text' => 'created_at',
            'placeholder' => 'created_at',
            'label' => 'created_at',
        ],
        'note' => [
            'description' => 'note',
            'helper_text' => 'note',
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
            'success' => 'File importato con successo',
            'error' => 'Errore durante l\'importazione del file',
            'confirmation' => 'Sei sicuro di voler importare questo file?',
            'fields' => [
                'import_file' => [
                    'label' => 'File da importare',
                    'placeholder' => 'Seleziona un file XLS o CSV da caricare',
                    'help' => 'Formati supportati: XLS, XLSX, CSV. Dimensione massima: 10MB',
                ],
            ],
        ],
        'export' => [
            'label' => 'Esporta dati',
            'success' => 'Dati esportati con successo',
            'error' => 'Errore durante l\'esportazione',
            'confirmation' => 'Sei sicuro di voler esportare i dati?',
            'filename_prefix' => 'Opzioni_Criteri_',
            'columns' => [
                'name' => [
                    'label' => 'Nome opzione criteri',
                    'help' => 'Nome dell\'opzione criteri',
                ],
                'parent_name' => [
                    'label' => 'Nome elemento padre',
                    'help' => 'Nome dell\'elemento di livello superiore',
                ],
            ],
        ],
        'create' => [
            'label' => 'Nuova opzione',
            'success' => 'Opzione criteri creata con successo',
            'error' => 'Errore durante la creazione dell\'opzione',
        ],
        'edit' => [
            'label' => 'Modifica opzione',
            'success' => 'Opzione criteri aggiornata con successo',
            'error' => 'Errore durante l\'aggiornamento dell\'opzione',
        ],
        'delete' => [
            'label' => 'Elimina opzione',
            'success' => 'Opzione criteri eliminata con successo',
            'error' => 'Errore durante l\'eliminazione dell\'opzione',
            'confirmation' => 'Sei sicuro di voler eliminare questa opzione? Questa azione è irreversibile.',
        ],
        'view' => [
            'label' => 'Visualizza opzione',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
            'label' => 'logout',
        ],
        'profile' => [
            'tooltip' => 'profile',
            'icon' => 'profile',
            'label' => 'profile',
        ],
        'reorderRecords' => [
            'tooltip' => 'reorderRecords',
        ],
    ],
    'tabs' => [
        'index' => [
            'label' => 'Lista',
            'description' => 'Visualizza tutte le opzioni criteri',
        ],
        'create' => [
            'label' => 'Aggiungi',
            'description' => 'Crea una nuova opzione criteri',
        ],
        'edit' => [
            'label' => 'Modifica',
            'description' => 'Modifica l\'opzione criteri selezionata',
        ],
    ],
    'messages' => [
        'created' => 'Opzione criteri creata con successo',
        'updated' => 'Opzione criteri aggiornata con successo',
        'deleted' => 'Opzione criteri eliminata con successo',
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
        'label' => 'Modello Criteri Opzioni',
        'placeholder' => 'Seleziona modello criteri opzioni',
        'tooltip' => 'Modello dati per le opzioni dei criteri',
        'helper_text' => 'Rappresentazione del modello dati utilizzato per gestire le opzioni e configurazioni dei criteri',
        'help' => 'Modello che definisce la struttura dati per le opzioni dei criteri',
    ],
    'label' => 'criteri option',
];
