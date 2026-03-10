# Regola Critica: property_exists() NON può essere usato nei Modelli Eloquent

## ⚠️ REGOLA ASSOLUTA - NON DEROGABILE

**property_exists() NON può essere usato nei modelli Eloquent perché gli attributi sono magici.**

Questa è una regola fondamentale che deve essere sempre rispettata.

## Motivazione

Gli attributi Eloquent sono gestiti tramite **magic methods** (`__get()`, `__isset()`, `__set()`). La funzione `property_exists()` verifica solo le proprietà **fisicamente dichiarate** nella classe, non quelle gestite tramite magic methods.

### Esempio del Problema

```php
// ❌ ERRATO - property_exists() restituisce SEMPRE false per attributi DB
$user = User::find(1);
if (property_exists($user, 'email')) {  // ← SEMPRE false!
    echo $user->email;  // Non viene mai eseguito, anche se email esiste nel DB
}

// ✅ CORRETTO - isset() rispetta i magic methods __isset()
$user = User::find(1);
if (isset($user->email)) {  // ← Funziona correttamente!
    echo $user->email;
}
```

## Pattern di Sostituzione

### 1. Attributi del Modello
```php
// ❌ ERRATO
if (property_exists($model, 'email')) {
    $value = $model->email;
}

// ✅ CORRETTO
if (isset($model->email)) {
    $value = $model->email;
}

// ✅ ANCORA MEGLIO (null coalescing)
$value = $model->email ?? null;
```

### 2. Relazioni Eloquent
```php
// ❌ ERRATO
if (property_exists($record, 'user')) {
    $user = $record->user;
}

// ✅ CORRETTO
if (isset($record->user)) {
    $user = $record->user;
}

// ✅ ANCORA MEGLIO
$user = $record->user ?? null;
```

### 3. Pivot Tables
```php
// ❌ ERRATO
if ($pivot && property_exists($pivot, 'importo_attivita_dipendente')) {
    $sum += $pivot->importo_attivita_dipendente;
}

// ✅ CORRETTO
if ($pivot && isset($pivot->importo_attivita_dipendente)) {
    $sum += $pivot->importo_attivita_dipendente;
}
```

### 4. Verifica Struttura Database
```php
// ❌ ERRATO
if (property_exists($model, 'email')) {
    $model->email = $value;
}

// ✅ CORRETTO - Verifica schema database
if ($model->hasAttribute('email')) {
    $model->email = $value;
}

// ✅ OPPURE - Verifica fillable
if ($model->isFillable('email')) {
    $model->email = $value;
}
```

## Eccezioni (Quando property_exists() è ACCETTABILE)

### 1. Static Properties Dichiarate
```php
// ✅ ACCETTABILE - Static property fisicamente dichiarata
class State {
    public static string $name = 'draft';
}

if (property_exists(State::class, 'name')) {
    // OK - è una static property dichiarata
}
```

### 2. Oggetti stdClass o Plain Objects
```php
// ✅ ACCETTABILE - Oggetto stdClass senza magic methods
$obj = (object) ['name' => 'test'];
if (property_exists($obj, 'name')) {
    // OK - stdClass non ha magic methods
}
```

## Checklist per Code Review

- [ ] Nessun `property_exists()` su modelli Eloquent
- [ ] Nessun `property_exists()` su relazioni Eloquent
- [ ] Nessun `property_exists()` su pivot tables
- [ ] Sostituito con `isset()` per attributi/relazioni
- [ ] Sostituito con `hasAttribute()` per verifica schema
- [ ] Sostituito con `isFillable()` per verifica mass assignment
- [ ] PHPStan Level 10 passa senza errori
- [ ] PHPMD non segnala problemi
- [ ] PHPInsights non segnala problemi

## Comandi per Verifica

```bash
# Cercare tutti gli usi di property_exists
grep -r "property_exists" Modules/ --include="*.php" | grep -v "docs/" | grep -v "property-exists"

# Verificare con PHPStan
./vendor/bin/phpstan analyse Modules --level=10

# Verificare con PHPMD
./vendor/bin/phpmd Modules text cleancode
```

## Documentazione Correlata

- [Eloquent Magic Properties](../../Modules/Xot/docs/eloquent-magic-properties-rule.md)
- [Property Exists Elimination Philosophy](../../Modules/Xot/docs/property-exists-elimination-philosophy.md)
- [Property Exists Replacement Guide](../../Modules/Xot/docs/property-exists-replacement-guide.md)

## Ultimo Aggiornamento

24 Novembre 2025 - Regola critica aggiunta dopo feedback utente


