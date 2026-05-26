# Regola: Chiavi Stringa in getTableColumns

## ⚠️ REGOLA CRITICA

**TUTTE le colonne in `getTableColumns()` devono avere chiavi stringa esplicite.**

**Firma obbligatoria:** `public function getTableColumns(): array` (metodo di istanza, mai `public static function getTableColumns()`).

### ❌ ANTI-PATTERN (Vietato)

```php
public function getTableColumns(): array
{
    return [
        WorkerColumn::make('lavoratore'),           // ❌ Manca chiave stringa
        TextColumn::make('stabi')->searchable(),    // ❌ Manca chiave stringa
        TextColumn::make('repar')->searchable(),    // ❌ Manca chiave stringa
    ];
}
```

### ✅ PATTERN CORRETTO

```php
public function getTableColumns(): array
{
    return [
        'lavoratore' => WorkerColumn::make('lavoratore'),     // ✅ Chiave stringa
        'stabi' => TextColumn::make('stabi')->searchable(), // ✅ Chiave stringa
        'repar' => TextColumn::make('repar')->searchable(), // ✅ Chiave stringa
    ];
}
```

## Perché è Importante

### 1. Type Safety con PHPStan Level 10
L'array restituito deve essere tipizzato come `array<string, Column>`. Senza chiavi stringa, PHPStan segnala errori di tipo.

### 2. Identificazione Unica
Le chiavi stringa identificano univocamente ogni colonna, facilitando:
- Override di colonne specifiche nelle classi figlie
- Riferimento programmatico alle colonne
- Merge di array di colonne da diverse fonti

### 3. Compatibilità con TableLayoutEnum
Il sistema di layout delle tabelle si aspetta chiavi stringa per organizzare le colonne.

### 4. Chiarezza e Manutenibilità
Le chiavi stringa rendono il codice più leggibile e auto-documentante.

## Convenzioni di Naming

### Nome Chiave = Nome Campo
La convenzione standard è che la chiave stringa corrisponda al nome del campo:

```php
'nome_campo' => TextColumn::make('nome_campo'),
```

### Casi Speciali
Per colonne che mostrano relazioni o dati aggregati:

```php
// Relazione 'user', mostra nome completo
'utente' => TextColumn::make('user.name'),

// Colonna custom che aggrega dati
'lavoratore' => WorkerColumn::make('lavoratore'),

// Colonna con formattazione custom
'importo_formattato' => TextColumn::make('importo')
    ->money('EUR'),
```

## Implementazione

### Checklist per Code Review

- [ ] Ogni colonna ha una chiave stringa esplicita
- [ ] La chiave usa snake_case (es. `nome_campo`)
- [ ] La chiave è coerente con il nome del campo o il suo scopo
- [ ] Non ci sono colonne numeriche (es. `0`, `1`, `2`)

### Esempio Completo

```php
use Filament\Tables\Columns\TextColumn;
use Modules\Ptv\Filament\Columns\WorkerColumn;

/**
 * @return array<string, \Filament\Tables\Columns\Column>
 */
public function getTableColumns(): array
{
    return [
        // Chiave stringa => Definizione colonna
        'lavoratore' => WorkerColumn::make('lavoratore')
            ->sortable(),
        
        'stabi' => TextColumn::make('stabi')
            ->searchable()
            ->sortable(),
        
        'repar' => TextColumn::make('repar')
            ->searchable(),
        
        'indennita_tipo_dettaglio' => TextColumn::make('indennitaTipoDettaglio')
            ->wrap(),
        
        'quadrimestre' => TextColumn::make('quadrimestre')
            ->searchable(),
        
        'anno' => TextColumn::make('anno')
            ->searchable()
            ->sortable(),
    ];
}
```

## Errori Comuni

### Errore 1: Chiavi Numeriche
```php
// ❌ SBAGLIATO
return [
    WorkerColumn::make('lavoratore'),  // Chiave implicita = 0
    TextColumn::make('stabi'),           // Chiave implicita = 1
];

// ✅ CORRETTO
return [
    'lavoratore' => WorkerColumn::make('lavoratore'),
    'stabi' => TextColumn::make('stabi'),
];
```

### Errore 2: Chiavi Non Stringa
```php
// ❌ SBAGLIATO
return [
    0 => WorkerColumn::make('lavoratore'),  // Chiave numerica esplicita
];

// ✅ CORRETTO
return [
    'lavoratore' => WorkerColumn::make('lavoratore'),
];
```

## Collegamenti

- [WorkerColumn Rule](./WORKERCOLUMN-RULE.md)
- [Filament Best Practices](./FILAMENT-BEST-PRACTICES.md)
- [PHPStan Level 10](./PHPSTAN-LEVEL10.md)

---
**Ultimo aggiornamento**: 2025-02-17  
**Priorità**: Alta  
**Violazione**: Critica - Errori PHPStan
