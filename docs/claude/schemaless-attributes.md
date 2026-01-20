# Spatie Laravel Schemaless Attributes - Guida Completa PTVX

> **📘 DOCUMENTAZIONE CORRETTA E VERIFICATA**: Pattern corretti per l'uso di schemaless attributes in PTVX

**Ultima Verifica**: 2025-01-02
**Status**: ✅ VERIFICATO - Pattern corretti confermati dal codice sorgente

---

## 🎯 Panoramica

Questo progetto utilizza il package `spatie/laravel-schemaless-attributes` per gestire attributi dinamici JSON su modelli Eloquent, principalmente per:

- **Rating**: Anno, configurazioni dinamiche per anno
- **BaseProfile** (User): Attributi extra utente
- **BaseExtra** (Xot): Attributi extra generici

---

## ✅ PATTERN CORRETTI

### Pattern 1: Array Parameter (RACCOMANDATO)

```php
// ✅ CORRETTO - Passa un array di condizioni
$ratings = Rating::withExtraAttributes(['anno' => 2025])->get();

// ✅ CORRETTO - Condizioni multiple
$ratings = Rating::withExtraAttributes([
    'anno' => 2025,
    'is_readonly' => false
])->get();

// ✅ CORRETTO - Con altre clausole where
$ratings = Rating::withExtraAttributes(['anno' => 2025])
    ->where('is_disabled', false)
    ->get();
```

### Pattern 2: String + Value Parameters (ALTERNATIVO)

```php
// ✅ CORRETTO - Passa chiave e valore separati
$ratings = Rating::withExtraAttributes('anno', 2025)->get();

// ⚠️ NOTA: Per condizioni multiple, usa il Pattern 1 (array)
```

### Pattern 3: Direct JSON Query (PER QUERY COMPLESSE)

```php
// ✅ CORRETTO - Query diretta su JSON path per casi specifici
$ratings = Rating::where('extra_attributes->anno', 2025)->get();

// ✅ CORRETTO - Query JSON complesse con operatori
$ratings = Rating::where('extra_attributes->anno', '>=', 2024)
    ->where('extra_attributes->is_readonly', false)
    ->get();
```

---

## 🔍 Come Funziona Internamente

### Il Meccanismo di Laravel Scopes

Quando chiami un metodo statico come `Rating::withExtraAttributes()`:

1. **Laravel cerca**: `scopeWithExtraAttributes()` nel modello
2. **Converte**: `Rating::withExtraAttributes('anno', 2025)`
   → `Rating::scopeWithExtraAttributes($query, 'anno', 2025)`
3. **Passa tutti i parametri** al metodo scope

### L'Implementazione in Rating.php

```php
/**
 * @param Builder<static> $query
 * @param string|array<string, mixed> $schemalessAttributes
 * @param mixed $value
 * @param string|null $operator
 * @return Builder<static>
 */
public function scopeWithExtraAttributes(
    Builder $query,
    string|array $schemalessAttributes = [],
    mixed $value = null,
    ?string $operator = null,
): Builder {
    // Delegates to Spatie\SchemalessAttributes\SchemalessAttributes::modelScope(),
    // which inspects the full argument list via debug_backtrace().
    return $this->extra_attributes->modelScope();
}
```

**IMPORTANTE**:
- Il metodo **ACCETTA** i parametri (`$schemalessAttributes`, `$value`, `$operator`)
- Non li usa direttamente nel corpo del metodo
- Delega a `modelScope()` che usa `debug_backtrace()` per ispezionare l'intera lista di argomenti
- Questo è un pattern avanzato di Spatie per gestire parametri in modo dinamico

---

## 🚨 PHPStan False Positive

### Il Problema

PHPStan segnala questo errore:

```
Static method Illuminate\Database\Eloquent\Builder<Modules\IndennitaResponsabilita\Models\Rating>::withExtraAttributes()
invoked with 2 parameters, 0 required.
```

### Perché è un False Positive

1. **PHPStan non capisce** il pattern Laravel scope magic methods
2. **Non vede** la signature completa di `scopeWithExtraAttributes()` con i parametri
3. **Analisi statica** non può tracciare `debug_backtrace()` usato da Spatie

### Soluzione: PHPDoc Annotation

Il modello Rating.php ha la corretta annotazione PHPDoc:

```php
/**
 * @method static Builder|Rating withExtraAttributes(string|array $schemalessAttributes = [], mixed $value = null)
 */
class Rating extends BaseModel
{
    // ...
}
```

**Questa annotazione**:
- ✅ Dichiara la signature corretta del metodo
- ✅ Permette agli IDE di auto-completare
- ⚠️ Ma PHPStan potrebbe ancora segnalare false positive

### Fix per PHPStan

**Opzione 1: Supprimere il Singolo Errore**

```php
// @phpstan-ignore-next-line arguments.count
$ratings = Rating::withExtraAttributes('anno', $anno)->get();
```

**Opzione 2: Aggiungere a phpstan.neon**

```yaml
parameters:
    ignoreErrors:
        - '#Static method.*withExtraAttributes\(\) invoked with .* parameters, 0 required#'
```

**Opzione 3: Laravel IDE Helper (RACCOMANDATO)**

```bash
php artisan ide-helper:models --write
```

Questo genera PHPDoc più dettagliati che PHPStan può comprendere.

---

## 📋 Checklist Pattern Corretti

### ✅ Quando Usare Array Pattern

- [ ] Query con una singola condizione semplice
- [ ] Query con multiple condizioni
- [ ] Quando la leggibilità è priorità
- [ ] In codice Filament/Livewire

**Esempio**:
```php
$ratings = Rating::withExtraAttributes([
    'anno' => $this->anno,
    'is_readonly' => false
])->get();
```

### ✅ Quando Usare String + Value Pattern

- [ ] Query semplici con una sola condizione
- [ ] Quando serve brevità
- [ ] In metodi brevi o lambda

**Esempio**:
```php
$ratings = Rating::withExtraAttributes('anno', $anno)->get();
```

### ✅ Quando Usare Direct JSON Query

- [ ] Query con operatori complessi (`>=`, `LIKE`, etc.)
- [ ] Query su nested JSON paths
- [ ] Performance critical queries
- [ ] Quando serve massimo controllo SQL

**Esempio**:
```php
$ratings = Rating::where('extra_attributes->anno', '>=', $annoInizio)
    ->where('extra_attributes->anno', '<=', $annoFine)
    ->get();
```

---

## 🎓 Best Practices

### 1. Usa Type Hints

```php
/**
 * @param int $anno
 * @return \Illuminate\Database\Eloquent\Collection<int, Rating>
 */
public function getRatings(int $anno): EloquentCollection
{
    /** @var EloquentCollection<int, Rating> $rows */
    $rows = Rating::withExtraAttributes(['anno' => $anno])->get();

    return $rows;
}
```

### 2. Valida Input

```php
// ✅ CORRETTO - Validazione esplicita
public function getRatings(int $anno): Collection
{
    if ($anno < 2000 || $anno > 2100) {
        throw new \InvalidArgumentException("Anno non valido: {$anno}");
    }

    return Rating::withExtraAttributes(['anno' => $anno])->get();
}
```

### 3. Eager Loading

```php
// ✅ CORRETTO - Carica relazioni in anticipo
$ratings = Rating::withExtraAttributes(['anno' => $anno])
    ->with(['ratingMorphs', 'creator'])
    ->get();
```

### 4. Commenti Espliciti per PHPStan

```php
// ✅ CORRETTO - Aiuta PHPStan e sviluppatori
// Note: withExtraAttributes accepts parameters via Laravel scope magic.
// PHPStan may show false positive - this is expected and correct.
$ratings = Rating::withExtraAttributes('anno', $anno)->get();
```

---

## 📚 Riferimenti

### File Chiave

- **Implementazione**: `Modules/Rating/app/Models/Rating.php:133-142`
- **PHPDoc**: `Modules/Rating/app/Models/Rating.php:53`
- **Spatie Package**: `vendor/spatie/laravel-schemaless-attributes/src/SchemalessAttributesTrait.php`

### Documentazione Correlata

- **[Xot Schemaless Guide](../../laravel/Modules/Xot/docs/schemaless-attributes.md)** - Guida generale Xot
- **[Rating README](../../laravel/Modules/Rating/docs/README.md)** - Documentazione Rating module
- **[HasRatingsTrait](../../laravel/Modules/Rating/docs/has-ratings-trait.md)** - Uso del trait

### Package Documentation

- **[Spatie Laravel Schemaless Attributes](https://github.com/spatie/laravel-schemaless-attributes)** - Official docs

---

## ⚠️ Correzioni Storiche

### Documentazione Precedente Errata (2025-01-01)

Una versione precedente di questa documentazione dichiarava ERRONEAMENTE che:

- ❌ `Rating::withExtraAttributes('anno', $anno)` era SBAGLIATO
- ❌ I parametri venivano IGNORATI
- ❌ Bisognava usare solo `where('extra_attributes->anno', $anno)`

**Questo era COMPLETAMENTE ERRATO!**

### Correzione (2025-01-02)

Dopo studio approfondito del codice sorgente e test:

- ✅ `withExtraAttributes()` **ACCETTA** parametri
- ✅ I parametri **SONO USATI** (via `debug_backtrace()`)
- ✅ Tutti e tre i pattern documentati sono **VALIDI E CORRETTI**

**Riferimento Issue**: PHPStan false positive su `CompilaIndennitaResponsabilita.php:289`

---

**Versione**: 2.0 (Corretto)
**Data**: 2025-01-02
**Autore**: Development Team
**Status**: ✅ VERIFICATO
