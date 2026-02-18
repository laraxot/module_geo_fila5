---
name: laraxot-translation-files
description: Regole per file di traduzione Laraxot: path, strict types, struttura completa e chiavi inglesi. Usare quando si aggiungono o modificano traduzioni.
---

# Laraxot Translation Files

## Scopo
Mantenere traduzioni coerenti, tipizzate e caricate correttamente.

## Regole critiche
- Path: `Modules/<Modulo>/lang/<locale>/`
- `declare(strict_types=1);` obbligatorio
- Solo sintassi array `[]`
- Chiavi in inglese, valori nella lingua target
- Struttura completa: `label`, `placeholder`, `help`
- Niente `->label()` in Filament (traduzioni automatiche)

## Struttura minima
```php
<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci nome',
            'help' => 'Nome completo',
        ],
    ],
];
```

## Struttura per XotBaseManageRelatedRecords

Per le pagine che estendono `XotBaseManageRelatedRecords` (es. `ManageProjectEmployees`), il metodo `getNavigationLabel()` usa `static::trans('navigation.label')`, quindi la struttura **deve** usare l'array nidificato:

```php
<?php

// Modules/Incentivi/lang/it/manage_project_employees.php
declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Dipendenti',  // <- OBBLIGATORIO per getNavigationLabel()
    ],
    'title' => 'Dipendenti',
    'heading' => 'Dipendenti',
    // ... altre chiavi
];
```

> **IMPORTANTE**: La chiave `navigation.label` (con punto) è obbligatoria. Non usare `navigation_label` (con underscore).
