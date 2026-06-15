---
title: "ownership campi date CommonScope"
type: concept
module: Sigma
tags: [commonscope, phpstan, architecture, dry]
created: 2026-06-15
updated: 2026-06-15
qmd: "Sigma CommonScope rangeFromField rangeToField annFieldName model ownership"
related:
  - ../../../../../../docs/wiki/rules/model-owned-date-range-fields.md
  - ./asz-scheda-relationship.md
  - ../index.md
---

# Ownership campi date — CommonScope

## Scopo

`CommonScope` centralizza la **logica** degli scope (`ofRangeDate`, `ofYear`, `ofEnteYear`, …).  
I **nomi colonna** (`asz2kd`, `qua2ka`, `dal`, …) restano responsabilità del singolo modello.

## Implementazione

Trait: `app/Models/Traits/Scopes/CommonScope.php` — tre metodi `abstract protected`.

Modelli Sigma diretti: `Asz00k1`, `Asz00f`, `Qua00f`, `Qua03f`, `Rep00f`.

Schede Ptv/Progressioni/Performance: `BaseScheda` (`dal` / `al` / `anno`).

## Verifica

```bash
cd laravel
./vendor/bin/phpstan analyse Modules/Sigma
```

## Anti-pattern rimosso

Hub `match (static::class)` o fallback `constant(FROM_FIELD)` nel trait — sostituito da polimorfismo esplicito sul modello.

## Collegamenti

- [Regola root](../../../../../../docs/wiki/rules/model-owned-date-range-fields.md)
- [Relazione ASZ scheda](./asz-scheda-relationship.md)
