---
title: "Memory System Usage"
type: "how-to"
tags: [memories, second-brain, on-demand, qmd]
created: 2026-05-19
updated: 2026-05-19
---

# Memory System Usage

> Memories capture durable decisions and verified audits — not transient chat.

## When to write a memory

- Environment or tooling audit with reproducible checks
- Naming or structure migration completed
- Cross-cutting decision that rules alone do not repeat

## Workflow

1. Search: `qmd search "memory:<topic>" --limit 5`
2. If missing, add `docs/wiki/memories/<topic>.md` (≤30 lines + frontmatter)
3. Link from `docs/wiki/memories/INDEX.md` (one table row)
4. Cross-link rules: `[on-demand-pattern](../rules/on-demand-pattern.md)` — avoid bare `[[name]]` without path
5. Append `docs/wiki/log.md` for multi-session work

## Verify

```bash
test -f docs/wiki/memories/INDEX.md && qmd search "memory:environment" --limit 3
```

**Upstream:** [Memories INDEX](../memories/INDEX.md) · [Trigger Map](../rules/00-TRIGGER_MAP.md)
