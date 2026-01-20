<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Messaggi',
        'plural' => 'Messaggi',
        'group' => [
            'name' => 'Gestione Progressioni',
            'description' => 'Gestione completa delle progressioni di carriera',
        ],
        'sort' => 9,
        'icon' => 'heroicon-o-chat-bubble-left-right',
        'label' => 'Messaggi',
    ],
    // Messaggi di importazione
    'import_ced_diff' => 'Importa CED Diff',
    'choose_xls_file' => 'Scegli il file XLS',
    'import_completed' => 'Importazione completata con successo.',
    'confirm_create_table' => 'Vuoi creare una nuova tabella con i dati importati?',

    // Messaggi di successo
    'success' => 'Operazione completata con successo',
    'created' => 'Record creato con successo',
    'updated' => 'Record aggiornato con successo',
    'deleted' => 'Record eliminato con successo',
    'saved' => 'Dati salvati con successo',
    'import_success' => 'Importazione completata con successo',
    'export_success' => 'Esportazione completata con successo',
    'upload_success' => 'File caricato con successo',
    'download_success' => 'Download completato con successo',

    // Messaggi di errore
    'error' => 'Si è verificato un errore',
    'error_occurred' => 'Si è verificato un errore durante l\'operazione',
    'not_found' => 'Record non trovato',
    'unauthorized' => 'Non hai i permessi per eseguire questa operazione',
    'validation_error' => 'Si sono verificati errori di validazione',
    'import_error' => 'Errore durante l\'importazione',
    'export_error' => 'Errore durante l\'esportazione',
    'upload_error' => 'Errore durante il caricamento del file',
    'download_error' => 'Errore durante il download',

    // Messaggi di avviso
    'warning' => 'Attenzione',
    'confirm_delete' => 'Sei sicuro di voler eliminare questo elemento?',
    'confirm_action' => 'Sei sicuro di voler eseguire questa azione?',
    'unsaved_changes' => 'Hai modifiche non salvate. Vuoi continuare?',
    'data_loss_warning' => 'Questa azione potrebbe causare la perdita di dati',

    // Messaggi informativi
    'info' => 'Informazione',
    'loading' => 'Caricamento in corso...',
    'processing' => 'Elaborazione in corso...',
    'no_data' => 'Nessun dato trovato',
    'no_results' => 'Nessun risultato trovato',
    'select_items' => 'Seleziona gli elementi da processare',
    'items_selected' => 'Elementi selezionati',

    // Messaggi di validazione
    'validation' => [
        'required' => 'Il campo :attribute è obbligatorio',
        'email' => 'Il campo :attribute deve essere un indirizzo email valido',
        'numeric' => 'Il campo :attribute deve essere numerico',
        'string' => 'Il campo :attribute deve essere una stringa',
        'max' => 'Il campo :attribute non può superare :max caratteri',
        'min' => 'Il campo :attribute deve essere almeno :min caratteri',
        'unique' => 'Il valore del campo :attribute è già presente',
        'exists' => 'Il valore del campo :attribute non è valido',
        'date' => 'Il campo :attribute deve essere una data valida',
        'date_format' => 'Il campo :attribute deve essere nel formato :format',
        'confirmed' => 'La conferma del campo :attribute non corrisponde',
        'different' => 'Il campo :attribute e :other devono essere diversi',
        'same' => 'Il campo :attribute e :other devono essere uguali',
        'between' => [
            'numeric' => 'Il campo :attribute deve essere tra :min e :max',
            'string' => 'Il campo :attribute deve essere tra :min e :max caratteri',
        ],
        'in' => 'Il valore del campo :attribute non è valido',
        'not_in' => 'Il valore del campo :attribute non è valido',
    ],

    // Messaggi specifici per progressioni
    'progression' => [
        'created' => 'Progressione creata con successo',
        'updated' => 'Progressione aggiornata con successo',
        'deleted' => 'Progressione eliminata con successo',
        'approved' => 'Progressione approvata con successo',
        'rejected' => 'Progressione rifiutata con successo',
        'pending' => 'Progressione in attesa di approvazione',
        'completed' => 'Progressione completata con successo',
    ],

    // Messaggi per file e upload
    'file' => [
        'upload_success' => 'File caricato con successo',
        'upload_error' => 'Errore durante il caricamento del file',
        'invalid_format' => 'Formato file non supportato',
        'too_large' => 'Il file è troppo grande',
        'not_found' => 'File non trovato',
        'download_success' => 'Download completato con successo',
        'download_error' => 'Errore durante il download',
    ],

    // Messaggi per operazioni batch
    'batch' => [
        'processing' => 'Elaborazione in corso...',
        'completed' => 'Elaborazione completata',
        'partial_success' => 'Alcune operazioni sono fallite',
        'all_success' => 'Tutte le operazioni completate con successo',
        'all_failed' => 'Tutte le operazioni sono fallite',
    ],
];
