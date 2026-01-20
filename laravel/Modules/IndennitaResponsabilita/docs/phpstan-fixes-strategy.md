# PHPStan Level 10 - Strategia di Risoluzione Errori

## Stato Attuale
- **Errori Totali**: 229
- **Livello PHPStan**: 10 (massimo)
- **Data Analisi**: 2025-11-12

## Categorizzazione Errori

### 1. Metodi Mancanti nei Modelli (Priorità ALTA)
**Impatto**: 15+ errori

#### IndennitaResponsabilita Model
- ✅ `msg()` - IMPLEMENTATO
- ✅ `getRatings()` - IMPLEMENTATO
- ✅ `getRatingsRules()` - IMPLEMENTATO
- ✅ `getRatingsValidationAttributes()` - IMPLEMENTATO

#### Rating Model
- `withExtraAttributes()` - Metodo statico mancante (usato in 4+ luoghi)

### 2. Proprietà non Definite (Priorità ALTA)
**Impatto**: 50+ errori

#### Proprietà Mancanti su Modelli
- `IndennitaResponsabilita`: `$anno`, `$dal`, `$al` - accessibili tramite mixed
- `LettF`: `$dalf`, `$alf`, `$repar`, `$importi`, `$complessita`, `$coordinamento`, `$responsabilita`
- `LettI`: `$dali`, `$ali`, `$propro`, `$posfun`, `$posiz`

**Soluzione**: Dichiarare esplicitamente nel `@property` PHPDoc o aggiungere ai `$fillable`

### 3. Mixed Type Operations (Priorità ALTA)
**Impatto**: 80+ errori

#### Pattern Comuni
```php
// ❌ ERRATO
$data['anno']  // mixed
$issue['column']  // mixed
$record->property  // mixed

// ✅ CORRETTO
$anno = is_int($data['anno']) ? $data['anno'] : null;
$column = isset($issue['column']) && is_string($issue['column']) ? $issue['column'] : '';
```

**File Critici**:
- `CompilaIndennitaResponsabilita.php` (46 errori)
- `LettI.php` (53 errori)
- `LettF.php` (31 errori)

### 4. Return Type Mismatch (Priorità MEDIA)
**Impatto**: 20+ errori

#### Esempi
```php
// ❌ Method should return array<string, Component> but returns array<int, Component>
public function getHeaderActions(): array

// ✅ Usare chiavi stringa
return [
    'delete' => DeleteAction::make(),
    'export' => ExportAction::make(),
];
```

### 5. Undefined Methods/Properties (Priorità MEDIA)
**Impatto**: 15+ errori

- `isCompiled()` / `isNotCompiled()` - Scope methods già definiti ma usati come statici
- `$previousUrl` property su CompilaIndennitaResponsabilita
- Classe `Modules\Cms\Actions\GetViewAction` non trovata

## Piano di Implementazione

### Fase 1: Fix Modelli Base (Giorno 1)
1. ✅ IndennitaResponsabilita - Aggiungere metodi mancanti
2. Rating - Aggiungere `withExtraAttributes()`
3. LettF - Dichiarare proprietà e fix type hints
4. LettI - Dichiarare proprietà e fix type hints

### Fase 2: Fix Actions (Giorno 2)
1. MakePdf.php - Type checking su array access
2. Populate.php - Cast esplicito per year parameter
3. SendMailByRecord.php - Verificare metodo msg()

### Fase 3: Fix Filament Pages (Giorno 3)
1. CompilaIndennitaResponsabilita - Pattern type-safe per form data
2. ListIndennitaResponsabilitas - Return types corretti
3. UpdateDiriByCsv - Type checking su file paths

### Fase 4: Fix Resource Classes (Giorno 4)
1. IndennitaResponsabilitaResource - Array associativi
2. RatingResource - Type hints e return types
3. Widgets/Livewire - Property types

### Fase 5: Verifica Finale
- Run PHPStan su ogni fix
- Documentare pattern comuni
- Update delle rules e memories

## Pattern di Fix Comuni

### Pattern 1: Safe Array Access
```php
// Prima
$value = $data['key'];

// Dopo
$value = isset($data['key']) && is_string($data['key']) ? $data['key'] : null;
```

### Pattern 2: Property Access su Modelli
```php
// Prima
$model->property

// Dopo
$property = $model->getAttribute('property');
if (is_string($property)) {
    // use $property
}
```

### Pattern 3: Collection Methods
```php
// Prima
$model->ratings->sum('value')

// Dopo
$ratings = $model->ratings;
if ($ratings instanceof Collection) {
    $sum = $ratings->sum('value');
}
```

### Pattern 4: Return Types Filament
```php
// Prima
public function getTableActions(): array
{
    return [
        ViewAction::make(),
        EditAction::make(),
    ];
}

// Dopo
/**
 * @return array<string, Action|ActionGroup>
 */
public function getTableActions(): array
{
    return [
        'view' => ViewAction::make(),
        'edit' => EditAction::make(),
    ];
}
```

## Note Importanti

1. **Non modificare phpstan.neon** - Il codice deve passare al livello 10
2. **Usare union types** quando necessario (es. `int|string|null`)
3. **Evitare mixed** quando possibile
4. **Aggiungere PHPDoc** dettagliati per proprietà dinamiche
5. **Test dopo ogni fix** per evitare regressioni

## Risorse

- [PHPStan Level 10 Guide](https://phpstan.org/blog/reach-level-max)
- [Laravel Eloquent PHPStan](https://github.com/nunomaduro/larastan)
- [Filament PHPStan Integration](https://filamentphp.com/docs)

## Ultimo Aggiornamento
- Data: 2025-11-12
- Autore: Sistema di Fix Automatico
- Versione: 1.0
