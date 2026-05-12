---
title: "Rules Index"
type: "index"
tags: [rules, user, translations, filament]
module: "User"
updated: 2026-05-12
---

# Rules — User Module Wiki

> Regole ricorrenti del modulo User. Load on-demand.

## Available Rules
- [context-overflow-prevention](../../../../../docs/wiki/rules/context-overflow-prevention.md) — prevenzione 262K token overflow; file vietati; tool output compression

- [no-filament-labels](./no-filament-labels.md) — vietato usare `->label()`, `->placeholder()` e testi inline nei componenti Filament del modulo
- [filament-langserviceprovider-governance](../concepts/filament-langserviceprovider-governance.md) — il `LangServiceProvider` e i file lingua del modulo restano la fonte di verita'
- [translation-5-level-structure](../concepts/translation-5-level-structure.md) — chiavi strutturate `namespace::context.collection.element.type`, niente frasi intere come key
- [header-auth-flow](./header-auth-flow.md) — vincoli del flusso auth/header nel dominio User
- [navigation-properties](./navigation-properties.md) — proprieta' di navigazione da mantenere coerenti nelle page del modulo
- [filament-rules-summary](../../../../../docs/wiki/rules/filament-rules-summary.md) — riepilogo root su `->label()`, XotBase e convenzioni Filament
- [schema-conventions](../../../../../docs/wiki/rules/schema-conventions.md) — convenzioni globali di schema e traduzioni

## Usage

```bash
qmd search "User module rule filament translation" --limit 5
```

---

**Upstream:** [Root Trigger Map](../../../../../docs/wiki/rules/00-TRIGGER_MAP.md)
