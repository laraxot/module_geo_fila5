# Standard di Codifica per il Modulo Performance

## Short Array Syntax (REGOLA CRITICA)

### ✅ SEMPRE usare `[]` in tutti i file PHP
```php
// CORRETTO
$data = [
    'key' => 'value',
    'items' => ['a', 'b', 'c'],
    'nested' => [
        'deep' => [
            'value' => 1,
        ],
    ],
];
```

### ❌ MAI usare `array()` nei file .php
```php
// VIETATO in produzione
$data = array(
    'key' => 'value',
    'items' => array('a', 'b', 'c'),
);
```

### Eccezione Didattica
Può essere usato `array()` SOLO quando si sta spiegando come NON usare qualcosa.

## Dichiarazioni Obbligatorie

Ogni file PHP deve iniziare con la seguente dichiarazione:

```php
<?php

declare(strict_types=1);
```

Questo assicura:
- Type checking rigoroso per le chiamate di funzione
- Maggiore sicurezza del tipo
- Prevenzione della coercizione implicita dei tipi
- Compatibilità con PHPStan livello 7

## Namespace e Use

- Tutti i file devono dichiarare il proprio namespace
- Gli import devono essere ordinati alfabeticamente
- Preferire import espliciti invece di utilizzare alias

## Tipizzazione

- Utilizzare tipi di ritorno espliciti per tutti i metodi
- Utilizzare type hints per tutti i parametri dei metodi
- Documentare le proprietà con annotazioni PHPDoc
- Utilizzare `list<string>` invece di `array<int, string>` per array sequenziali
- Utilizzare `array<string, mixed>` per array associativi

## Action Pattern (CRITICO)

- **MAI** usare constructor dependency injection
- **SEMPRE** usare `app(ActionClass::class)->execute()`
- Le Actions devono avere un singolo metodo pubblico `execute()`
- Usare Spatie QueueableAction, MAI Services

```php
// ✅ CORRETTO
app(CreateClientAction::class)->execute($data);

// ❌ VIETATO - constructor DI
public function __construct(
    private readonly DatabaseManager $dbManager,
    private readonly LoggerInterface $logger,
) {}

// ❌ VIETATO - metodo custom
app(CreateClientAction::class)->createPersonalAccessClient();
```

## Composer & Moduli

- Nuovi pacchetti vanno nel `composer.json` del **modulo**, MAI in `laravel/composer.json`
- Eseguire `composer go` dalla cartella `laravel/` per il merge
- wikimedia/composer-merge-plugin gestisce il merge automatico

## Filament Resources

- Estendere `XotBaseResource` (da Modules\Xot), MAI `Filament\Resources\Resource`
- Utilizzare type hints per tutti i metodi
- Dichiarare esplicitamente il model con `protected static ?string $model`
- NO label/placeholder/helperText hardcodati - usare traduzioni

## Models

- Estendere `BaseModel` del modulo, MAI `Illuminate\Database\Eloquent\Model`
- Documentare tutte le proprietà con PHPDoc
- Utilizzare `casts()` method, MAI `protected $casts` property
- Utilizzare `isset()` per magic properties, MAI `property_exists()`
- Dichiarare esplicitamente i tipi per `$fillable`

## Git

- MAI eseguire `git remote set-url` - solo il proprietario del progetto
- Git va solo in avanti - mai ripristinare vecchie versioni
- Ogni errore corretto: git commit + GitHub issue + GitHub discussion