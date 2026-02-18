---
name: larastan-workflow-reference
description: Riferimenti rapidi Larastan/PHPStan: requisiti e config minima.
---

# Riferimenti

## Requisiti minimi (Larastan 3.x)
- PHP 8.2+
- Laravel 11.16+ (per Larastan 3.x)

## Config minima (phpstan.neon/dist)
```
includes:
    - vendor/larastan/larastan/extension.neon
    - vendor/nesbot/carbon/extension.neon

parameters:
    paths:
        - app/
    level: 10
```

## Note operative
- Usa sempre scope minimo (file/modulo).
- Aggiungi `--memory-limit` se necessario.
- Evita di “nascondere” errori tramite ignore globali.
