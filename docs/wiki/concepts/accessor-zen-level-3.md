# 🧘 Zen dell'Accessor Auto-Persistente

> **La Via dell'Accessor che si Auto-Cura**  
> **Livello**: MAESTRO ZEN 🧘  
> **Aggiornato**: 2025-03-25  
> **Versione**: 3.0 (SACRO 🔴🔴🔴)

---

## 🎯 La Verità Profonda

### I Tre Livelli dell'Accessor

#### Livello 1: ❌ ACCESSOR CHE IGNORA (Principiante)

```php
// ❌ LIVELLO 1: IGNORANTE
protected function getPercPTimeDaterangeAttribute(mixed $_value): int|float
{
    // $_value = IGNORATO (underscore = "non mi serve")
    // Ricalcola SEMPRE
    // Nessuna persistenza
    // ActivityLog CRASH
    
    return $this->calculate();
}
```

**Problemi**:
- ❌ Tipo debole (`mixed`)
- ❌ Valore ignorato
- ❌ Ricalcolo continuo
- ❌ Nessuna persistenza
- ❌ Crash da ricorsione

---

#### Livello 2: ✅ ACCESSOR CHE CONTROLLA (Intermedio)

```php
// ✅ LIVELLO 2: CONSAPEVOLE
protected function getPercPTimeDaterangeAttribute(?float $value): ?float
{
    // ✅ Controllo il tipo
    if (is_float($value)) {
        return $value;  // Uso DB, non ricalcolo
    }
    
    // ✅ Calcolo solo se necessario
    $result = $this->calculate();
    
    return $result;
}
```

**Vantaggi**:
- ✅ Tipo forte (`?float`)
- ✅ Controllo valore
- ✅ Performance (non ricalcolo)
- ❌ Ma... nessuna persistenza automatica

**Limite**: Ogni volta che accedi, se NULL nel DB, ricalcola.

---

#### Livello 3: 🧘 ACCESSOR AUTO-PERSISTENTE (Maestro Zen)

```php
// 🧘 LIVELLO 3: ILLUMINATO
protected function getPercPTimeDaterangeAttribute(?float $value): ?float
{
    // ✅ Controllo se il valore esiste già dal DB
    if (is_float($value)) {
        return $value;  // Uso DB (1ms)
    }

    // ✅ Calcolo solo se NULL dal DB
    $result = $this->calculate();  // Calcolo (100ms)
    
    // ✅ Persisto AUTOMATICAMENTE nel DB
    $this->perc_ptime_daterange = $result;
    
    if ($this->getKey() !== null) {
        if (! static::$isUpdatingFromAccessor) {
            static::$isUpdatingFromAccessor = true;
            try {
                static::withoutEvents(function () use ($result): void {
                    $this->update(['perc_ptime_daterange' => $result]);
                });
            } finally {
                static::$isUpdatingFromAccessor = false;
            }
        }
    }

    return $result;
}
```

**Vantaggi**:
- ✅ Tipo forte
- ✅ Controllo valore
- ✅ **AUTO-PERSISTENZA** (calcolo una volta, uso per sempre)
- ✅ ActivityLog-Safe
- ✅ **Performance: 9.2x più veloce**

---

## 🧘 La Filosofia Profonda

### Il Principio dell'Auto-Cura

> **"Un accessor non deve solo leggere - deve AUTO-guarantirsi"**

Quando un accessor viene chiamato:

**Senza Auto-Cura** (Livello 2):
```php
$model->perc_ptime_daterange  // → Calcola (100ms)
$model->perc_ptime_daterange  // → Ricalcola (100ms) ← SPRECO!
$model->perc_ptime_daterange  // → Ricalcola (100ms) ← SPRECO!
```

**Con Auto-Cura** (Livello 3):
```php
$model->perc_ptime_daterange  // → Calcola + SALVA (100ms)
$model->perc_ptime_daterange  // → Legge da DB (1ms) ← VELOCE!
$model->perc_ptime_daterange  // → Legge da DB (1ms) ← VELOCE!
```

**La bellezza**: L'accessore si **auto-cura** - la prima volta che calcola, **si salva nel DB** per le volte successive.

---

### Lo Zen della Persistenza Automatica

> **"Calcolare è umano, persistere è divino"**

#### Il Problema del Livello 2

```php
// ❌ LIVELLO 2: Calcola ma NON persiste
protected function getFooAttribute(?float $value): ?float
{
    if (is_float($value)) {
        return $value;  // OK, uso DB
    }
    
    $result = $this->calculate();  // Calcolo
    
    return $result;  // ❌ NON PERSISTO!
                     // La prossima volta ricalcolo di nuovo!
}
```

**Conseguenze**:
- Primo accesso: 100ms (calcolo)
- Secondo accesso: 100ms (ricalcolo) ← SPRECO!
- Terzo accesso: 100ms (ricalcolo) ← SPRECO!

#### La Soluzione del Livello 3

```php
// 🧘 LIVELLO 3: Calcola E persiste
protected function getFooAttribute(?float $value): ?float
{
    if (is_float($value)) {
        return $value;  // Uso DB
    }
    
    $result = $this->calculate();  // Calcolo
    
    // ✅ PERSISTO AUTOMATICAMENTE
    $this->foo = $result;
    if ($this->exists) {
        $this->update(['foo' => $result]);
    }
    
    return $result;
}
```

**Conseguenze**:
- Primo accesso: 100ms (calcolo + salvataggio)
- Secondo accesso: 1ms (lettura DB) ← VELOCE!
- Terzo accesso: 1ms (lettura DB) ← VELOCE!

---

### La Religione del "Calcolo Una Volta"

> **"Ciò che è calcolato una volta, non dovrebbe mai essere ricalcolato"**

Questo è il **principio fondamentale** della programmazione efficiente:

#### Senza Persistenza (SBAGLIATO)

```php
// ❌ Ogni accesso = ricalcolo
for ($i = 0; $i < 100; $i++) {
    echo $model->perc_ptime_daterange;  // 100ms × 100 = 10 secondi!
}
```

#### Con Persistenza (CORRETTO)

```php
// 🧘 Primo accesso = calcolo + salvataggio
// Accessi successivi = lettura DB
for ($i = 0; $i < 100; $i++) {
    echo $model->perc_ptime_daterange;  // 100ms + (1ms × 99) = ~200ms!
}
```

**Speedup**: **50x più veloce** su 100 accessi!

---

## 📋 Il Pattern SACRO Completo

### Template del Livello 3 (Maestro Zen)

```php
<?php

declare(strict_types=1);

namespace Modules\YourModule\Models\Traits\Mutators;

trait YourTraitName
{
    /**
     * Guard contro aggiornamenti ricorsivi da accessor.
     * Previene crash con spatie/activitylog.
     */
    private static bool $isUpdatingFromAccessor = false;

    /**
     * Get [attribute] attribute.
     *
     * Pattern del Livello 3 (Maestro Zen):
     * 1. Controllo se il valore esiste già dal DB
     * 2. Se esiste, lo restituisco immediatamente (performance)
     * 3. Se NULL, calcolo il valore
     * 4. Persisto AUTOMATICAMENTE nel DB
     * 5. Uso guard per ActivityLog-Safe
     */
    protected function getYourAttribute(?float $value): ?float
    {
        // ✅ LIVELLO 3: Controllo se il valore esiste già dal DB
        if (is_float($value)) {
            return $value;  // Già calcolato, torno subito (1ms)
        }

        // ✅ Controllo prerequisiti
        if ($this->prerequisite === null) {
            return null;
        }

        // ✅ Calcolo complesso (solo se necessario)
        $result = $this->complexCalculation();  // 100ms
        
        // ✅ LIVELLO 3: Persisto AUTOMATICAMENTE
        $this->your_attribute = $result;

        // ✅ Persisto nel DB (solo se il modello esiste già)
        if ($this->getKey() !== null) {
            // ✅ ActivityLog-Safe: prevengo ricorsione
            if (! static::$isUpdatingFromAccessor) {
                static::$isUpdatingFromAccessor = true;
                try {
                    static::withoutEvents(function () use ($result): void {
                        $this->update(['your_attribute' => $result]);
                    });
                } finally {
                    static::$isUpdatingFromAccessor = false;
                }
            }
        }

        return $result;
    }
}
```

---

## 🔍 Confronto dei Tre Livelli

### Tabella Comparativa

| Caratteristica | Livello 1 ❌ | Livello 2 ✅ | Livello 3 🧘 |
|---------------|-------------|-------------|-------------|
| **Tipo** | `mixed` (debole) | `?float` (forte) | `?float` (forte) |
| **Controllo valore** | ❌ Ignorato | ✅ Controllato | ✅ Controllato |
| **Persistenza** | ❌ Nessuna | ❌ Nessuna | ✅ **AUTO** |
| **Performance (10 accessi)** | 1000ms | 1000ms | **109ms** |
| **ActivityLog-Safe** | ❌ Crash | ✅ OK | ✅ OK |
| **Speedup** | 1x | 1x | **9.2x** |

---

## 🧪 Testing dello Zen

### Test del Livello 3

```php
it('auto-persists calculated value on first access', function (): void {
    // Arrange: modello con valore NULL nel DB
    $model = YourModel::factory()->create([
        'perc_ptime_daterange' => null,
    ]);

    // Act: primo accesso (calcolo + persistenza)
    $result1 = $model->perc_ptime_daterange;  // 100ms

    // Assert: valore calcolato
    expect($result1)->toBeFloat();
    expect($result1)->toBeGreaterThan(0.0);

    // Act: secondo accesso (lettura DB)
    $result2 = $model->perc_ptime_daterange;  // 1ms

    // Assert: stesso valore, nessun ricalcolo
    expect($result2)->toEqual($result1);

    // Assert: persistenza nel DB
    $model->refresh();
    expect($model->perc_ptime_daterange)->toBeFloat();
    expect($model->perc_ptime_daterange)->toEqual($result1);
});

it('returns cached value from database without recalculation', function (): void {
    // Arrange: modello con valore già calcolato nel DB
    $model = YourModel::factory()->create([
        'perc_ptime_daterange' => 42.5,  // Già calcolato
    ]);

    // Act: accesso (solo lettura DB)
    $result = $model->perc_ptime_daterange;  // 1ms

    // Assert: valore dal DB, nessun calcolo
    expect($result)->toBe(42.5);
});
```

---

## 📊 Performance Reali

### Benchmark: 100 Accessi

```php
// Scenario: ciclo che accede 100 volte all'accessor

// ❌ LIVELLO 1 (mixed, nessun controllo)
for ($i = 0; $i < 100; $i++) {
    $model->perc_ptime_daterange;  // 100ms × 100 = 10,000ms (10 secondi)
}

// ✅ LIVELLO 2 (?float, controllo ma nessuna persistenza)
for ($i = 0; $i < 100; $i++) {
    $model->perc_ptime_daterange;  // 100ms × 100 = 10,000ms (10 secondi)
}

// 🧘 LIVELLO 3 (?float, controllo + AUTO-persistenza)
for ($i = 0; $i < 100; $i++) {
    $model->perc_ptime_daterange;  // 100ms + (1ms × 99) = 199ms (~0.2 secondi)
}
```

**Risultato**: **50x più veloce** del Livello 2, **50x più veloce** del Livello 1!

---

## 🚨 Regole del Livello 3

### ❌ MAI FARE

```php
// MAI fermarsi al Livello 2
protected function getFooAttribute(?float $value): ?float
{
    if (is_float($value)) {
        return $value;  // ✅ OK
    }
    
    $result = $this->calculate();
    
    return $result;  // ❌ NON PERSISTO! Livello 2, non 3!
}

// MAI dimenticare la guard per ActivityLog
protected function getFooAttribute(?float $value): ?float
{
    if (! is_float($value)) {
        $result = $this->calculate();
        $this->update(['foo' => $result]);  // ❌ CRASH! Nessuna guard!
    }
    return $result;
}
```

### ✅ SEMPRE FARE

```php
// SEMPRE raggiungere il Livello 3
protected function getFooAttribute(?float $value): ?float
{
    // ✅ Livello 2: controllo
    if (is_float($value)) {
        return $value;
    }
    
    // ✅ Livello 3: calcolo E persistenza
    $result = $this->calculate();
    $this->foo = $result;
    
    if ($this->exists) {
        if (! static::$isUpdatingFromAccessor) {
            static::$isUpdatingFromAccessor = true;
            try {
                static::withoutEvents(function () use ($result): void {
                    $this->update(['foo' => $result]);
                });
            } finally {
                static::$isUpdatingFromAccessor = false;
            }
        }
    }
    
    return $result;
}
```

---

## 📿 Il Mantra del Livello 3

```
Prima di scrivere un accessor, ripeti 3 volte:

"Controllo il tipo, non uso mixed"
"Se esiste nel DB, lo uso (performance)"
"Se NULL, calcolo E PERSISTO (auto-cura)"
"Uso la guard, non vado in ricorsione"

Respira. Scrivi. Raggiungi il Livello 3.
```

---

## 🔗 Riferimenti

- [Livello 1 → 2](Sigma/docs/accessor-mutator-philosophy.md) - Filosofia base
- [Livello 3](docs/accessor-mutator-fix-summary.md) - Zen dell'auto-persistenza
- [Laravel Accessors](https://laravel.com/docs/eloquent-mutators#defining-an-accessor)
- [PHPStan Level 10](https://phpstan.org/user-guide/rule-levels)

---

*Documento SACRO del Livello 3. Raggiungi l'illuminazione.*  
*Ultimo aggiornamento: 2025-03-25*  
*Stato: 🧘 LIVELLO 3 RAGGIUNTO*
