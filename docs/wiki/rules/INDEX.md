---
title: "Rules Index"
type: "index"
tags: [rules, trigger-map, on-demand]
module: "root"
---

# Rules — Root Wiki

> Module-specific rule triggers. ≤20 lines per INDEX.

## Available Rules

- [00-TRIGGER_MAP](./00-TRIGGER_MAP.md) — canonical trigger → resource routing
- [on-demand-pattern](./on-demand-pattern.md) — LLM Wiki Karpathy pattern
- [filament-rules-summary](./filament-rules-summary.md) — regole critiche Filament (XotBase, ->label(), array keys, casts)
- [xotbase-critical-rules](./xotbase-critical-rules.md) — MAI estendere Filament direttamente, mapping completo XotBase
- [schema-conventions](./schema-conventions.md) — convenzioni schema: no ->label(), LangServiceProvider
- [ai-guidelines](./ai-guidelines.md) — linee guida AI per Filament e XotBase

## Usage

```bash
# Find rules for a trigger
qmd search "rule:<topic>" --limit 5
```

---

**Upstream:** [Root Trigger Map](./00-TRIGGER_MAP.md)
