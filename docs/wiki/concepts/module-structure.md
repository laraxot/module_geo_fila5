---
title: Struttura dei Moduli
description: Convenzioni e standard per la struttura dei moduli nel progetto PTVX
tags:
  - architecture
qmd: "module structure, directory layout, naming conventions, XotBase, nwidart modules"
created: 2026-04-15
updated: 2026-04-15
sources:
  - docs/architecture/modules.md
references:
  - type: concept
    module: User
    path: laravel/Modules/User/docs/wiki/index.md
  - type: concept
    module: Lang
    path: laravel/Modules/Lang/docs/wiki/index.md
  - type: concept
    module: Gdpr
    path: laravel/Modules/Gdpr/docs/wiki/index.md
  - type: concept
    module: Activity
    path: laravel/Modules/Activity/docs/wiki/index.md
  - type: concept
    module: Notify
    path: laravel/Modules/Notify/docs/wiki/index.md
  - type: concept
    module: Performance
    path: laravel/Modules/Performance/docs/wiki/index.md
  - type: concept
    module: Xot
    path: laravel/Modules/Xot/docs/wiki/index.md
  - type: concept
    module: Media
    path: laravel/Modules/Media/docs/wiki/index.md
  - type: concept
    module: UI
    path: laravel/Modules/UI/docs/wiki/index.md
---

# Struttura dei Moduli

## Struttura Standard dei Moduli

Ogni modulo deve seguire una struttura standard per garantire consistenza e manutenibilità:

```
ModuleName/
├── app/
│   ├── Actions/           # Spatie QueueableActions
│   ├── Datas/            # Spatie Data Objects
│   ├── Filament/
│   │   ├── Pages/
│   │   └── Resources/    # Filament Resources
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Requests/     # Form Requests
│   │   └── Resources/    # API Resources
│   └── Models/           # Eloquent Models
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── lang/            # File di traduzione per etichette
│   └── views/
└── routes/
    ├── api.php
    └── web.php
```

## Modulo Performance

Il modulo Performance gestisce le valutazioni e le performance del personale.

### Struttura Specifica

```
Performance/
├── app/
│   ├── Actions/
│   │   ├── Filament/
│   │   │   └── Filter/
│   │   │       └── GetYearFilter.php    # Filtro anni standard
│   │   └── Organizzativa/              # Azioni per gestione organizzativa
│   ├── Datas/
│   │   └── IndividualeData.php         # DTO per dati individuali
│   ├── Enums/
│   │   └── WorkerType.php              # Enumerazione tipi lavoratore
│   ├── Filament/
│   │   ├── Actions/
│   │   │   ├── Bulk/                   # Azioni bulk
│   │   │   ├── Header/                 # Azioni header
│   │   │   └── Table/                  # Azioni tabella
│   │   ├── Pages/
│   │   │   └── Dashboard.php
│   │   └── Resources/                  # Risorse Filament
│   ├── Mail/
│   │   ├── PerformanceMail.php
│   │   └── SchedaMail.php
│   ├── Models/
│   │   ├── Traits/                     # Traits per i modelli
│   │   │   ├── FunctionTrait.php
│   │   │   ├── MutatorTrait.php
│   │   │   └── RelationshipTrait.php
│   │   ├── Policies/                   # Policy per autorizzazioni
│   │   ├── BaseModel.php
│   │   ├── Individuale.php
│   │   └── Performance.php
│   ├── Providers/
│   │   ├── Filament/
│   │   │   └── AdminPanelProvider.php
│   │   └── PerformanceServiceProvider.php
│   └── Rules/
       └── ExcellenceRule.php           # Regole di validazione custom
```

## Convenzioni Specifiche

### File di Traduzione
I file di traduzione del modulo devono includere le seguenti chiavi per la navigazione:
```php
// Modules/ModuleName/Resources/lang/it/module-name.php
return [
    // Etichette di navigazione
    'navigation_icon' => 'heroicon-o-rectangle-stack', // Icona di navigazione
    'navigation_group' => 'Nome Gruppo',               // Gruppo nel menu
    'navigation_sort' => 10,                          // Ordine di visualizzazione
    
    // Altre traduzioni...
];
```

### Gestione Etichette
- **NON** utilizzare il metodo ->label() nei componenti Filament
- Le etichette vengono gestite automaticamente dal LangServiceProvider
- Definire le traduzioni nei file lang/ del modulo
- Il sistema utilizzerà automaticamente la chiave del campo come chiave di traduzione

### Pages
- Tutte le pagine List devono estendere `XotBaseListRecords`
- **OBBLIGATORIO**: Implementare il metodo astratto `getListTableColumns()`
- La mancata implementazione causerà l'errore "contains 1 abstract method"

### Resources
- Tutte le risorse devono estendere `XotBaseResource`
- **OBBLIGATORIO**: Implementare il metodo astratto `getFormSchema()`
- Utilizzare `heroicon-o-rectangle-stack` come icona di default

### Models
- Utilizzare Spatie Laravel Data per i DTO
- Implementare le relazioni con type hints

### Actions
- Utilizzare Spatie QueueableAction invece di Services
- Implementare l'interfaccia `ShouldQueue` per azioni pesanti

### Policies
- Ogni modello deve avere la sua Policy corrispondente
- Le Policy gestiscono le autorizzazioni per le operazioni CRUD

### Traits
- Utilizzare Traits per organizzare la logica dei modelli
- Separare le funzionalità in:
  - FunctionTrait: metodi di utilità
  - MutatorTrait: accessor e mutator
  - RelationshipTrait: relazioni con altri modelli

## Best Practices

### Campi Numerici
- Utilizzare sempre `->numeric()` per input numerici
- Aggiungere `->sortable()` alle colonne numeriche

### Filtri
- Utilizzare `GetYearFilter` per filtri anno
- Range anni: da (anno corrente - 3) a anno corrente

### Type Safety
- Utilizzare `declare(strict_types=1)` in ogni file
- Aggiungere type hints a tutti i metodi
- Utilizzare DTO per il trasferimento dati

## Vedi anche

- [BaseModel Pattern](../../../laravel/Modules/Xot/docs/wiki/BaseModel.md) — Pattern di base per i modelli
- [Actions Over Services](actions-over-services.md) — Pattern di azioni invece di servizi
- [Translation standards](../rules/translation-standards.md) — Sistema di traduzione automatica