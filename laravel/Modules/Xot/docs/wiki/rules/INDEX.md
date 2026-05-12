---
title: "Rules Index"
type: "index"
tags: [rules, filament, xotbase]
module: "Xot"
updated: 2026-05-12
---

# Rules — Xot Module Wiki

> Regole critiche Xot/Laraxot. Load on-demand.

## Available Rules
- [context-overflow-prevention](../../../../../docs/wiki/rules/context-overflow-prevention.md) — prevenzione 262K token overflow; file vietati; tool output compression

- [filament-resource-property](../../../../../docs/wiki/rules/filament-resource-property.md) — `$resource` è `protected static`, auto-resolve via namespace
- [xotbase-critical-rules](../../../../../docs/wiki/rules/xotbase-critical-rules.md) — MAI estendere Filament direttamente
- [filament-rules-summary](../../../../../docs/wiki/rules/filament-rules-summary.md) — no `->label()`, array<string,*>, no `$casts`
- [schema-conventions](../../../../../docs/wiki/rules/schema-conventions.md) — LangServiceProvider gestisce le label

## Usage

```bash
qmd search "Xot rule filament" --limit 5
```

---

**Upstream:** [Root Trigger Map](../../../../../docs/wiki/rules/00-TRIGGER_MAP.md)
