# Documentazione PHPStan - base_fixcity_fila5_mono

**Progetto:** FixCity  
**PHPStan Level:** 10 (Massimo)  
**Aggiornato:** 10 Ottobre 2025

## 📚 Guide Principali

### 🎯 Essenziali (Leggi Prima!)
1. [**Riepilogo Generale**](./riepilogo-generale.md) - Overview completa progetto ⭐
2. [**Lezioni Apprese**](./lezioni-apprese-2025-10-10.md) - Tutte le lezioni dalla correzione ⭐
3. [**Pattern Comuni**](./pattern-comuni.md) - Pattern riutilizzabili per tutti i moduli ⭐

### 🚨 Regole Critiche
1. [**MAI Escludere Test**](../regole-critiche/phpstan-test-mai-escludere.md) 🔴 IMPORTANTISSIMO!

## 📦 Documentazione per Modulo

### Activity Module ✅
- [PHPStan Compliance Status](../../laravel/Modules/Activity/docs/phpstan-compliance.md)
- [Best Practices PHPStan](../../laravel/Modules/Activity/docs/phpstan/best-practices.md)
- [Correzioni 2025-10-10](../../laravel/Modules/Activity/docs/phpstan/correzioni-2025-10-10.md)
- [Risultato Finale](../../laravel/Modules/Activity/docs/phpstan/risultato-finale-2025-10-10.md)
- [Regola Critica Test](../../laravel/Modules/Activity/docs/phpstan/regola-critica-test-phpstan.md)

**Status:** ✅ 0 errori (230 corretti)

### Blog Module ✅
- [PHPStan Compliance Status](../../laravel/Modules/Blog/docs/phpstan-compliance.md)
- [Best Practices PHPStan](../../laravel/Modules/Blog/docs/phpstan/best-practices.md)
- [Correzioni 2025-10-10](../../laravel/Modules/Blog/docs/phpstan/correzioni-2025-10-10.md)
- [Risultato Finale](../../laravel/Modules/Blog/docs/phpstan/risultato-finale-2025-10-10.md)

**Status:** ✅ 0 errori (13 corretti)

### Xot Module ✅
- [PHPStan Compliance Status](../../laravel/Modules/Xot/docs/phpstan-compliance.md)
- [Best Practices PHPStan](../../laravel/Modules/Xot/docs/phpstan/best-practices.md)
- [Correzioni 2025-10-10](../../laravel/Modules/Xot/docs/phpstan/correzioni-2025-10-10.md)
- [Risultato Finale](../../laravel/Modules/Xot/docs/phpstan/risultato-finale-2025-10-10.md)
- [Test Naming Convention](../../laravel/Modules/Xot/docs/testing/test-naming-convention.md)

**Status:** ✅ 0 errori (304 corretti)

### Altri Moduli ⏳
- Dental Module - In pianificazione
- Patient Module - In pianificazione
- Reporting Module - In pianificazione
- User Module - In pianificazione

## 🎨 Documentazione Temi

### Theme One
- [PHPStan Guide](../../laravel/Themes/One/docs/phpstan-guide.md)

**Focus:** View Composers, Return Types, DTO

## 🎓 Guide Tematiche

### 1. HasXotFactory
**Problema:** `@use HasFactory<Factory>` con `HasXotFactory`  
**Soluzione:** Rimuovere parametri generic

```php
// ❌ SBAGLIATO
/** @use HasFactory<Factory> */
use HasXotFactory;

// ✅ CORRETTO
use HasXotFactory;
```

**Moduli Corretti:** Activity, Blog

### 2. Factory nei Test
**Problema:** Factory ritornano `mixed`  
**Soluzione:** Assert per type narrowing

```php
// ✅ SEMPRE
$model = Model::factory()->create();
assert($model instanceof Model);
```

**File Corretti:** ~150 test

### 3. Return Types Specifici
**Problema:** `array<string, mixed>` troppo generico  
**Soluzione:** `list<DTO>` quando appropriato

```php
// ✅ PREFERIRE
/** @return list<ArticleData> */
public function getArticles(): array { ... }
```

**File Corretti:** ThemeComposer (9 metodi)

### 4. Safe Functions
**Problema:** `json_encode`, `json_decode` unsafe  
**Soluzione:** Importare `Safe\` variants

```php
use function Safe\json_encode;
use function Safe\json_decode;
use function Safe\class_uses;
```

**File Corretti:** 13 test files

### 5. Filament Arrays
**Problema:** `array<int, Filter>` invece di `array<string, mixed>`  
**Soluzione:** Array associativi con chiavi stringa

```php
// ✅ CORRETTO
return [
    'featured' => Filter::make('featured'),
    'category' => SelectFilter::make('category'),
];
```

**File Corretti:** 2 Resources

### 6. Pest Dynamic Properties
**Problema:** Property su `$this` in closure test  
**Soluzione:** `phpstan-ignore` strategici

```php
/* @phpstan-ignore-next-line property.notFound */
$this->model = new Model();
```

**File Corretti:** ~30 test Pest

## 📊 Statistiche Globali

### Errori Corretti
| Categoria | Activity | Blog | Xot | Totale |
|-----------|----------|------|--------|--------|
| generics.wrongParent | 4 | 1 | 0 | 5 |
| theCodingMachineSafe.function | 13 | 0 | 18 | 31 |
| method.nonObject | 120 | 0 | 0 | 120 |
| property.notFound | 45 | 1 | 100 | 146 |
| new.abstract | 0 | 0 | 35 | 35 |
| new.noConstructor | 0 | 0 | 22 | 22 |
| argument.type | 0 | 2 | 40 | 42 |
| foreach.nonIterable | 0 | 0 | 15 | 15 |
| method.notFound | 0 | 0 | 25 | 25 |
| return.type | 18 | 9 | 8 | 35 |
| Altri | 30 | 0 | 41 | 71 |
| **Totale** | **230** | **13** | **304** | **547** |

### Tempo Investito
- **Activity:** ~3 ore (alta complessità test)
- **Blog:** ~30 minuti (bassa complessità)
- **Xot:** ~4 ore (MOLTO alta complessità)
- **Documentazione:** ~3 ore
- **Totale:** ~10.5 ore

### ROI
- **547 errori corretti**
- **15+ pattern consolidati**
- Documentazione completa
- Foundation solida per altri moduli
- **3 regole critiche documentate**

## 🛠️ Comandi Utili

### Analisi
```bash
# Singolo modulo
./vendor/bin/phpstan analyse Modules/ModuleName

# Tutti i moduli
./vendor/bin/phpstan analyse Modules/

# Conta errori
./vendor/bin/phpstan analyse Modules/ModuleName 2>&1 | grep "Found"
```

### Workflow
```bash
# 1. Analisi iniziale
./vendor/bin/phpstan analyse Modules/ModuleName > errors.txt

# 2. Conta errori per categoria
cat errors.txt | grep "identifier:" | sort | uniq -c

# 3. Verifica finale
./vendor/bin/phpstan analyse Modules/ModuleName
# [OK] No errors ✅
```

## 🎯 Workflow Standard

### Step 1: Analisi
```bash
cd /var/www/_bases/base_fixcity_fila5_mono/laravel
./vendor/bin/phpstan analyse Modules/ModuleName
```

### Step 2: Categorizzazione
- Raggruppa errori per tipo
- Identifica pattern ricorrenti
- Prioritizza: Models → Filament → Tests

### Step 3: Correzione
- Applica pattern consolidati
- Correggi un tipo alla volta
- Verifica incrementalmente

### Step 4: Documentazione
1. Aggiorna `Modules/ModuleName/docs/phpstan-compliance.md`
2. Crea `Modules/ModuleName/docs/phpstan/correzioni-YYYY-MM-DD.md`
3. Documenta nuovi pattern in best-practices.md

### Step 5: Verifica
```bash
./vendor/bin/phpstan analyse Modules/ModuleName
# [OK] No errors ✅
```

## 📖 Pattern Library

### Pattern 1: Factory Assert
**Applicabilità:** 100% test con factory  
**Riutilizzabile:** ✅ Sì  
**Documentazione:** [Pattern Comuni](./pattern-comuni.md#pattern-1-factory-nei-test)

### Pattern 2: Collection Factory
**Applicabilità:** Factory con count()  
**Riutilizzabile:** ✅ Sì  
**Documentazione:** [Pattern Comuni](./pattern-comuni.md#pattern-2-collection-factory)

### Pattern 3: Pest Properties
**Applicabilità:** Test Pest con $this  
**Riutilizzabile:** ✅ Sì  
**Documentazione:** [Activity Best Practices](../../laravel/Modules/Activity/docs/phpstan/best-practices.md#3-pest-dynamic-properties)

### Pattern 4: Filament Resources
**Applicabilità:** getTableFilters/Columns  
**Riutilizzabile:** ✅ Sì  
**Documentazione:** [Pattern Comuni](./pattern-comuni.md#pattern-4-filament-resources)

### Pattern 5: Return Types
**Applicabilità:** Metodi che ritornano array  
**Riutilizzabile:** ✅ Sì  
**Documentazione:** [Blog Best Practices](../../laravel/Modules/Blog/docs/phpstan/best-practices.md#1-return-types-specifici)

## 🚀 Prossimi Passi

### Moduli da Completare
1. ⏳ Dental Module
2. ⏳ Patient Module
3. ⏳ Reporting Module
4. ⏳ User Module
5. ⏳ Xot Module

### Miglioramenti
- [ ] Script automazione pattern comuni
- [ ] CI/CD integration
- [ ] Pre-commit hooks
- [ ] Training team

## 🏆 Achievement

**243 errori corretti in 2 moduli**  
**PHPStan Level 10 raggiunto**  
**Documentazione completa creata**  
**Pattern consolidati per progetto**

---

**Indice Documentazione PHPStan**  
**base_fixcity_fila5_mono** 🏆  
**Aggiornato:** 10 Ottobre 2025

