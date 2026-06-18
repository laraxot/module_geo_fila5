---
title: "Memoria: bugfix business logic prima del tipo"
type: memory
tags: [agent, bugfix, business-logic, second-brain]
created: 2026-06-18
updated: 2026-06-18
qmd: "bugfix business logic before type memory agent discipline"
related:
  - ../patterns/bugfix-business-logic-before-type.md
  - ../../laravel/Modules/Xot/docs/wiki/concepts/agent-confidence-discipline.md
---

# Memoria: bugfix business logic prima del tipo

**Regola:** correggere un errore ≠ capire l'errore. Prima del patch: scopo, catena chiamanti, vincoli relazione, percorsi alternativi e quale rompe il dominio.

**Eloquent:** preferire `$model->relation()` a `Model::query()`; non usare `getQuery()` se si perdono FK.

**PHPStan:** se un helper accetta query da relazioni, firma `Builder|Relation` come i gemelli nel file — non è refactor, è coerenza.

**Canon:** [bugfix-business-logic-before-type.md](../patterns/bugfix-business-logic-before-type.md)

**Caso Sigma 2026-06-18:** `FunctionExtra::applyQua00fProproFilters` — [function-extra-relation-query-pattern](../../laravel/Modules/Sigma/docs/wiki/concepts/function-extra-relation-query-pattern.md)
