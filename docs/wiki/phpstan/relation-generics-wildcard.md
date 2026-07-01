---
title: "Relation generics: wildcard `*, *` per Builder|Relation union"
type: pattern
status: approved
tags: [phpstan, generics, relation, eloquent, sigma, pattern]
created: 2026-07-01
updated: 2026-07-01
related:
  - ./journey-summary.md
  - ../../laravel/Modules/Sigma/app/Models/Traits/Extras/FunctionExtra.php
---

# Relation generics: wildcard `*, *`

## Problema

PHPStan lvl max segnala `generics.lessTypes` su `Relation<Qua00f, static>` (manca 3° parametro `TResult`) e `argument.type` quando si passa una `HasMany<Qua00f, Qua03f>` a un parametro che accetta `Builder<Qua00f>|Relation<Qua00f, covariant Model, *>`.

## Causa

`Relation` di Eloquent ha 3 template params: `TRelatedModel, TDeclaringModel, TResult`. Usare solo 2 params (`Relation<Qua00f, static>`) scatena `generics.lessTypes`. Usare `covariant Model` per TDeclaringModel è troppo stretto perché static(Qua03f) non matcha.

## Fix

```php
// ❌ Errore: generics.lessTypes + argument.type
/** @param Builder<Qua00f>|Relation<Qua00f, covariant Model, *> $query */

// ✅ OK: wildcard accetta qualsiasi Relation a Qua00f
/** @param Builder<Qua00f>|Relation<Qua00f, *, *> $query */
```

## Lezioni

1. `Relation<*, *, *>` accetta qualsiasi variazione di template params
2. `HasMany<X, Y>` riassegnato a `Relation<X, Y>` perde TResult → meglio non riassegnare
3. Rimuovere `@var Relation<X, static>` se sovrascrive una `HasMany<X, static>` già tipizzata
