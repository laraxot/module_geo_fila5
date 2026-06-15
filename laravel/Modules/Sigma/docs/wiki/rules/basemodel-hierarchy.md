---
title: "Sigma BaseModel Hierarchy"
type: rule
module: Sigma
tags: [architecture, eloquent, models, basemodel, hierarchy]
created: 2026-06-15
updated: 2026-06-15
qmd: "sigma basemodel hierarchy xotbase eloquent"
related:
  - ../../../../docs/wiki/rules/eloquent-basemodel-hierarchy.md
  - ../concepts/common-scope-date-range-ownership.md
  - ../index.md
---

# Sigma — BaseModel Hierarchy

## Gerarchia Obbligatoria

```
XotBaseModel (Modules\Xot\Models)
    ↑
BaseModel (Modules\Sigma\Models)
    ↑
BaseDateRangeModel (Modules\Sigma\Models — opzionale)
    ↑
ConcreteModel (Modules\Sigma\Models\[ModelName])
```

## Implementazione Sigma

### 1. BaseModel — Layer Intermedio

```php
// laravel/Modules/Sigma/app/Models/BaseModel.php

abstract class BaseModel extends XotBaseModel
{
    // Connessione module-specific
    protected $connection = 'generale';
    
    // Sigma-wide traits
    use SigmaCommonTrait;
}
```

**Responsabilità:**
- Connessione 'generale' per sistemi legacy
- Cast condivisi (date format, legacy timestamps)
- Scopes custom (scopeByEnte, scopeByYear, etc)

### 2. BaseDateRangeModel — Subtype Specializzato

```php
// laravel/Modules/Sigma/app/Models/BaseDateRangeModel.php

abstract class BaseDateRangeModel extends BaseModel
    implements SigmaDateRangeFields
{
    use CommonScope;
    public $timestamps = false;
}
```

**Responsabilità:**
- Centralizza il trait CommonScope
- Implementa contratto SigmaDateRangeFields
- Toglie i timestamps (legacy format)

Modelli che usano intervalli date → estendono BaseDateRangeModel:
- Qua03f, Qua00f, Asz00f, Asz00k1, Rep00f, …

### 3. ConcreteModel — Implementazione

```php
// Sigma ha 100+ modelli di dati legacy
// Tutti estendono BaseModel (o BaseDateRangeModel)

class Qua03f extends BaseDateRangeModel {
    // Implementa i 3 metodi astratti di CommonScope
    public function rangeFromField(): string { return 'q32kd'; }
    public function rangeToField(): string { return 'q32ka'; }
    public function annFieldName(): string { return 'q3ann'; }
}

class Accina extends BaseModel {
    // Modello semplice senza date range
}
```

## Verificare Conformità

```bash
cd laravel/Modules/Sigma

# Check: nessun modello estende direttamente Model
grep -r "extends.*Eloquent\\Model\|extends Model" app/Models/*.php \
    ! -name "BaseModel.php"
# Deve restituire 0 matches
```

## Vantaggi in Sigma

| Aspetto | Beneficio |
|---------|-----------|
| **Legacy DB** | `$connection='generale'` centralizzato in BaseModel |
| **Timestamps** | BaseDateRangeModel disabilita `$timestamps` per tutti i modelli date-range |
| **CommonScope** | Trait riusabile su 5 modelli, no duplication |
| **Testing** | Mock BaseModel behaviors senza toccare Eloquent |
| **Manutenzione** | Cambi a BaseModel si propagano a 100+ modelli |

## Anti-Pattern (NEVER)

```php
// ❌ Violazione CARDINAL RULE
class Qua03f extends Model { }
class Qua03f extends Eloquent\Model { }

// ✅ Corretti
class Qua03f extends BaseDateRangeModel { }
class BaseDateRangeModel extends BaseModel { }
class BaseModel extends XotBaseModel { }
```

---

**Pattern:** CARDINAL RULE — Eloquent BaseModel Hierarchy
**Compliance:** ✅ 100% (audit run 2026-06-15)
**Verification:** `bash bashscripts/tools/audit-eloquent-basemodel-hierarchy.sh`
