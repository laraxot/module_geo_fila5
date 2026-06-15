---
title: "Sigma — Model Contracts Placement"
type: rule
module: Sigma
tags: [contract, placement, models, architecture]
created: 2026-06-15
updated: 2026-06-15
qmd: "sigma model contracts placement sigmadate​range​fields"
related:
  - ../../../../docs/wiki/rules/contract-placement-nested-scoping.md
  - ../../../../docs/wiki/memories/contract-placement-nested-scoping.md
  - ../index.md
---

# Sigma — Model Contracts Placement

## Standard Sigma

```
Modules\Sigma\
├── app/
│   ├── Models/Contracts/         ← Model-level contracts
│   │   └── SigmaDateRangeFields   ✅ Impl by BaseDateRangeModel, Qua03f, etc
│   ├── Models/
│   │   ├── BaseDateRangeModel (implements SigmaDateRangeFields)
│   │   ├── Qua03f (implements SigmaDateRangeFields)
│   │   ├── Qua00f (implements SigmaDateRangeFields)
│   │   └── ...
│   └── Contracts/                ← Module-level contracts (if any)
│       └── (exposed to other modules)
```

## SigmaDateRangeFields

**Location:** `Modules\Sigma\Models\Contracts\SigmaDateRangeFields`

**Implementers:**
- `Modules\Sigma\Models\BaseDateRangeModel`
- `Modules\Sigma\Models\Qua03f`
- `Modules\Sigma\Models\Qua00f`
- `Modules\Sigma\Models\Asz00f`
- `Modules\Sigma\Models\Asz00k1`
- `Modules\Sigma\Models\Rep00f`

**Why `Models/Contracts/`?**
- Governs **models specifically**, not module-level
- Implementers are all in `Models/` folder
- Cognitive proximity: when reading `Qua03f`, you find contract in `Models/Contracts/`

**Import in Implementations:**
```php
namespace Modules\Sigma\Models;

use Modules\Sigma\Models\Contracts\SigmaDateRangeFields;

class BaseDateRangeModel extends BaseModel 
    implements SigmaDateRangeFields { }
```

## Regola Placement

**Template per futuri contracts Sigma:**
- Model-level contract? → `Models/Contracts/[Name].php`
- Action-level contract? → `Actions/Contracts/[Name].php` (if layer exists)
- Filament-level contract? → `Filament/Contracts/[Name].php` (if layer exists)
- Module-level contract? → `Contracts/[Name].php` (exposed to other modules)

---

**Pattern:** Nested Scoping (DDD)
**Compliance:** ✅ SigmaDateRangeFields correctly placed
**Reference:** `docs/wiki/rules/contract-placement-nested-scoping.md`
