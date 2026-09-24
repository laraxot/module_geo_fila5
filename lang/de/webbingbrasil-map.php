<?php

declare(strict_types=1);

// Geo translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: ≥5% comment lines on files >100 LOC.
// Canon: Modules/Geo/docs/wiki — domain i18n only.
// File: lang/de/webbingbrasil-map.php
return [
    'navigation' => [
        'label' => 'Mappa Webbingbrasil',
        'group' => 'Gestione Territorio',
        'icon' => 'heroicon-o-map',
        'sort' => '60',
    ],
    'controls' => [
        'zoom' => [
            'in' => 'Aumenta zoom',
            'out' => 'Diminuisci zoom',
        ],
        'fullscreen' => 'Schermo intero',
        'layers' => 'Cambia layer',
    ],
    'markers' => [
        'add' => 'Aggiungi marker',
        'remove' => 'Rimuovi marker',
        'edit' => 'Modifica marker',
    ],
    'messages' => [
        'marker_added' => 'Marker aggiunto con successo',
        'marker_removed' => 'Marker rimosso con successo',
        'marker_updated' => 'Marker aggiornato con successo',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'fields' => [
    ],
    'actions' => [
    ],
];
