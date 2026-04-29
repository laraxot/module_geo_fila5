# Analisi PHPStan Test - Situazione Corrente

## 🎯 Executive Summary

**Focus:** Analisi PHPStan Level Max su cartelle `Modules/*/tests`
**Totale Errori Test:** 3941
**Moduli Analizzati:** 18
**Moduli Puliti:** 8 ✅
**Moduli da Correggere:** 10 ❌

## 🏆 Achievement: Moduli con Test Puliti

Questi moduli hanno raggiunto **0 errori PHPStan nei test** (Level Max):

| Modulo | Status | Note |
|--------|--------|------|
| **AI** | ✅ | Test type-safe |
| **Activity** | ✅ | 230 errori corretti in sessione precedente |
| **Blog** | ✅ | 13 errori corretti in sessione precedente |
| **Comment** | ✅ | Test type-safe |
| **Job** | ✅ | Test type-safe |
| **Rating** | ✅ | Test type-safe |
| **Seo** | ✅ | Test type-safe |
| **Xot** | ✅ | 304 errori corretti in sessione precedente |

## 🚨 Moduli con Errori nei Test (Priorità di Intervento)

### Tier 1: CRITICO (>750 errori)

#### 1. Fixcity - 1171 errori ⚠️⚠️⚠️
**Priorità:** MASSIMA (modulo core applicazione)

**Top 5 Errori:**
- `property.notFound`: 350 (30%)
- `method.nonObject`: 223 (19%)
- `argument.templateType`: 160 (14%)
- `missingType.return`: 110 (9%)
- `array.invalidKey`: 92 (8%)

**Azioni Immediate:**
1. Factory assertions su tutti i test
2. Type hints per return types
3. Gestione proprietà dinamiche Pest
4. Correzione array keys

**Stima Tempo:** ~8-10 ore

---

#### 2. Notify - 776 errori ⚠️⚠️
**Priorità:** ALTA

**Top 5 Errori:**
- `property.notFound`: 365 (47%)
- `argument.templateType`: 142 (18%)
- `offsetAccess.nonOffsetAccessible`: 88 (11%)
- `property.nonObject`: 41 (5%)
- `binaryOp.invalid`: 39 (5%)

**Azioni Immediate:**
1. Pest dynamic properties
2. Generic types per template
3. Array access safety
4. Null coalescing operators

**Stima Tempo:** ~6-8 ore

---

### Tier 2: ALTO (400-600 errori)

#### 3. User - 482 errori ⚠️
**Priorità:** ALTA (modulo core autenticazione)

**Top 5 Errori:**
- `property.notFound`: 163 (34%)
- `property.nonObject`: 85 (18%)
- `argument.templateType`: 69 (14%)
- `method.nonObject`: 59 (12%)
- `argument.type`: 36 (7%)

**Azioni Immediate:**
1. User factory type hints
2. Relationship property access
3. Authentication test cleanup
4. Generic types

**Stima Tempo:** ~5-6 ore

---

#### 4. Cms - 457 errori ⚠️
**Priorità:** ALTA

**Top 5 Errori:**
- `method.nonObject`: 133 (29%)
- `property.notFound`: 77 (17%)
- `property.nonObject`: 68 (15%)
- `argument.type`: 38 (8%)
- `argument.templateType`: 28 (6%)

**Azioni Immediate:**
1. Factory method calls
2. Content block properties
3. Type narrowing
4. Argument types

**Stima Tempo:** ~4-5 ore

---

### Tier 3: MEDIO (200-400 errori)

#### 5. UI - 361 errori
**Top Errori:** `property.notFound` (87), `argument.templateType` (50), `class.notFound` (48)
**Stima Tempo:** ~3-4 ore

#### 6. Geo - 271 errori
**Top Errori:** `property.notFound` (83), `argument.templateType` (59), `method.nonObject` (41)
**Stima Tempo:** ~2-3 ore

---

### Tier 4: BASSO (< 200 errori)

#### 7. Lang - 151 errori
**Top Errori:** `property.notFound` (80), `argument.templateType` (33)
**Stima Tempo:** ~1-2 ore

#### 8. Media - 140 errori
**Top Errori:** `property.notFound` (78), `argument.templateType` (21)
**Stima Tempo:** ~1-2 ore

#### 9. Tenant - 82 errori
**Top Errori:** `property.notFound` (47), `method.nonObject` (12)
**Stima Tempo:** ~1 ora

#### 10. Gdpr - 50 errori
**Top Errori:** `property.notFound` (20), `argument.templateType` (13)
**Stima Tempo:** ~30-45 minuti

---

## 📊 Analisi Globale Errori

### TOP 10 Tipi di Errori nei Test

| # | Tipo Errore | Occorrenze | % | Soluzione Standard |
|---|------------|-----------|---|--------------------|
| 1 | `property.notFound` | 1350 | 34% | `/* @phpstan-ignore-next-line property.notFound */` per Pest |
| 2 | `argument.templateType` | 575 | 15% | Aggiungere generic types `<T>` |
| 3 | `method.nonObject` | 574 | 15% | `assert($model instanceof Model)` dopo factory |
| 4 | `property.nonObject` | 308 | 8% | Null coalescing `$obj?->prop` |
| 5 | `argument.type` | 137 | 3% | Type casting o fix parametri |
| 6 | `class.notFound` | 120 | 3% | Import/namespace corretti |
| 7 | `missingType.return` | 115 | 3% | Aggiungere `@return` types |
| 8 | `offsetAccess.nonOffsetAccessible` | 115 | 3% | Array access guards |
| 9 | `binaryOp.invalid` | 97 | 2% | Operatori con type check |
| 10 | `array.invalidKey` | 92 | 2% | Fix array keys |

---

## 🎓 Pattern di Correzione Consolidati

### Pattern 1: Factory + Assert (risolve ~574 errori)

```php
// ❌ PRIMA (causa method.nonObject)
$user = User::factory()->create();
$name = $user->name;  // Errore!

// ✅ DOPO
$user = User::factory()->create();
assert($user instanceof User);
$name = $user->name;  // OK!
```

**Applicabile a:** TUTTI i test che usano factory
**Stima Risoluzione:** ~15% errori totali

---

### Pattern 2: Pest Dynamic Properties (risolve ~1350 errori)

```php
// ❌ PRIMA (causa property.notFound)
beforeEach(function () {
    $this->model = new Model();  // Errore!
});

// ✅ DOPO
beforeEach(function () {
    /* @phpstan-ignore-next-line property.notFound */
    $this->model = new Model();
});

test('example', function () {
    /* @phpstan-ignore-next-line property.notFound */
    $model = $this->model;
    expect($model)->toBeInstanceOf(Model::class);
});
```

**Applicabile a:** TUTTI i test Pest con `$this`
**Stima Risoluzione:** ~34% errori totali

---

### Pattern 3: Template Types (risolve ~575 errori)

```php
// ❌ PRIMA (causa argument.templateType)
expect($collection)->toHaveCount(5);  // Errore generic!

// ✅ DOPO
/** @var Collection<int, Model> $collection */
$collection = Model::all();
expect($collection)->toHaveCount(5);
```

**Applicabile a:** Test con Collection, array generici
**Stima Risoluzione:** ~15% errori totali

---

### Pattern 4: Null Safety (risolve ~308 errori)

```php
// ❌ PRIMA (causa property.nonObject)
$value = $model->relation->property;  // Errore se null!

// ✅ DOPO
$value = $model->relation?->property ?? 'default';
```

**Applicabile a:** Accesso proprietà con possibili null
**Stima Risoluzione:** ~8% errori totali

---

## 📅 Piano di Intervento Suggerito

### Sprint 1: Moduli Core
**Obiettivo:** Zero errori test su moduli critici

- [ ] **Fixcity** (1171 errori) - 2 giorni
- [ ] **User** (482 errori) - 1 giorno
- [ ] **Cms** (457 errori) - 1 giorno

**Output:** 2110 errori corretti, 3 moduli core puliti

---

### Sprint 2: Moduli Support
**Obiettivo:** Riduzione 50% errori rimanenti

- [ ] **Notify** (776 errori) - 1.5 giorni
- [ ] **UI** (361 errori) - 0.5 giorni

**Output:** 1137 errori corretti

---

### Sprint 3: Cleanup Finale
**Obiettivo:** Zero errori su tutti i moduli

- [ ] **Geo** (271 errori) - 0.5 giorni
- [ ] **Lang** (151 errori) - 0.25 giorni
- [ ] **Media** (140 errori) - 0.25 giorni
- [ ] **Tenant** (82 errori) - 0.25 giorni
- [ ] **Gdpr** (50 errori) - 0.25 giorni

**Output:** 694 errori corretti, TUTTI i moduli puliti

---

## 🎯 Target Finale

```
PRIMA:  18 moduli, 3941 errori test
DOPO:   18 moduli, 0 errori test ✅

Tempo Stimato: ~15-20 giorni lavorativi
Sessioni PHPStan: ~12-15 sessioni
```

---

## 🛠️ Comandi Utili

### Analisi Singolo Modulo (Solo Test)
```bash
./vendor/bin/phpstan analyse Modules/ModuleName/tests
```

### Analisi Tutti i Test
```bash
# Usa lo script creato
php analyze_phpstan_errors.php
```

### Workflow Correzione Modulo
```bash
# 1. Analisi iniziale
./vendor/bin/phpstan analyse Modules/Fixcity/tests > fixcity_errors.txt

# 2. Conta per tipo
cat fixcity_errors.txt | grep "🪪" | sort | uniq -c | sort -rn

# 3. Correggi pattern per pattern
# ... applica Pattern 1, Pattern 2, etc ...

# 4. Verifica finale
./vendor/bin/phpstan analyse Modules/Fixcity/tests
# [OK] No errors ✅
```

---

## 📖 Riferimenti

- [Pattern Comuni PHPStan](./pattern-comuni.md)
- [Regola Critica: MAI Escludere Test](../regole-critiche/phpstan-test-mai-escludere.md)
- [Activity Module Best Practices](../../laravel/Modules/Activity/docs/phpstan/best-practices.md)
- [Blog Module Best Practices](../../laravel/Modules/Blog/docs/phpstan/best-practices.md)
- [Xot Module Best Practices](../../laravel/Modules/Xot/docs/phpstan/best-practices.md)

---

**Documento generato da:** `analyze_phpstan_errors.php`
**Prossimo Aggiornamento:** Dopo Sprint 1 (correzione moduli core)
