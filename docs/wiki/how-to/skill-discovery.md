---
title: "Skill Discovery"
type: "how-to"
tags: [skills, on-demand, qmd, routing]
created: 2026-05-19
updated: 2026-05-19
---

# Skill Discovery

> Find the smallest applicable skill before improvising a workflow.

## Steps

1. Open `docs/wiki/rules/00-TRIGGER_MAP.md` — match task keywords
2. `qmd search "skill:<topic>" --limit 5`
3. Read nearest `docs/wiki/skills/INDEX.md` (root, module, or theme)
4. Prefer tightening an existing skill over duplicating (`on-demand-skill-maintenance.md`)
5. External agent skills (Cursor/`~/.agents/skills`) are optional overlays — wiki repo paths stay canonical

## Verify

```bash
qmd search "skill:filament" --limit 5
test -f docs/wiki/skills/on-demand-skill-maintenance.md
```

**Upstream:** [Skills INDEX](../skills/INDEX.md) · [Trigger Map](../rules/00-TRIGGER_MAP.md)
