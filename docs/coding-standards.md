# Standard di Codifica per il Modulo Performance

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

## Filament Resources

- Estendere `Filament\Resources\Resource`
- Utilizzare type hints per tutti i metodi
- Dichiarare esplicitamente il model con `protected static ?string $model`

## Models

- Estendere `Illuminate\Database\Eloquent\Model`
- Documentare tutte le proprietà con PHPDoc
- Utilizzare type hints per i metodi di query
- Dichiarare esplicitamente i tipi per `$fillable` e `$casts` 