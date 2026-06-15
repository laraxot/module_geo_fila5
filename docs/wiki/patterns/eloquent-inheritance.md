---
title: Eloquent Model Inheritance Pattern
description: Regole per l'ereditarietà dei modelli Eloquent nel progetto
tags: [architecture, models, eloquent, inheritance]
---

# Eloquent Model Inheritance Pattern

## Regola fondamentale

| Scenario | Estendi | Esempio |
|----------|---------|---------|
| Modello generico | `BaseModel` | `class Scheda extends BaseModel` |
| Modello con intervallo date | `BaseDateRangeModel` | `class Qua00f extends BaseDateRangeModel` |
| **Mai** estendere direttamente | `Illuminate\Database\Eloquent\Model` | ❌ `class X extends Model` |

## Perché?

1. **DRY**: `BaseModel` fornisce costanti, trait comuni, e configurazioni standard
2. **Type Safety**: PHPStan riconosce le relazioni e i metodi del base
3. **Manutenibilità**: Cambiamenti centralizzati nel base

## Verifica

```bash
# Trova modelli che estendono Model direttamente
grep -rn "extends.*Model\b" laravel/Modules/*/app/Models/ --include="*.php" \
  | grep -v "BaseModel\|BaseDateRangeModel"
```

## Cronologia

- **2026-06-15**: Corretto `Qua00f` da `extends Model` a `extends BaseDateRangeModel`