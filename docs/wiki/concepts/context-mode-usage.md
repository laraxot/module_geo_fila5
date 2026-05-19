---
title: "Context-Mode Usage"
type: "concept"
tags: [context-mode, compression, token-budget, overflow]
created: 2026-05-19
updated: 2026-05-19
---

# Context-Mode Usage

> Compress large tool output via context-mode; keep wiki loads bounded with QMD `--limit`.

## When

- Tool/MCP output may exceed context (logs, test dumps, `git diff`)
- Before/after large reads: compare `ctx stats`

## Actions

1. `ctx doctor` — verify install/hooks (see `docs/wiki/how-to/context-mode-setup.md`)
2. Prefer `qmd search "<topic>" --limit 5` for wiki corpus
3. Overflow playbook: `docs/wiki/how-to/context-mode-overflow-prevention.md`

## Verify

```bash
command -v ctx >/dev/null && ctx stats || echo "ctx not installed"
test -f docs/wiki/how-to/context-mode-setup.md
```

**Upstream:** [Context overflow prevention](./context-overflow-prevention.md) · [Trigger Map](../rules/00-TRIGGER_MAP.md)
