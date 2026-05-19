---
title: "Wikilink and cross-reference discipline"
type: "how-to"
tags: [wiki, links, qmd]
created: 2026-05-19
updated: 2026-05-19
---

# Wikilink and cross-reference discipline

Prefer **relative markdown paths** verified with `test -f`. Bare `[[Title]]` only when a matching page exists in the same QMD collection.

## Preferred

```markdown
[on-demand-pattern](../rules/on-demand-pattern.md)
```

## Legacy

Canonical **second-brain** cluster, `ProjectHome.md`, and key **sources/** pages were migrated (2026-05-20). Remaining `[[...]]` may exist in `_templates/`, how-to examples, or shell snippets — replace on touch; do not add new orphan titles.

## Verify

```bash
test -f docs/wiki/rules/on-demand-pattern.md
qmd search "second brain operating" --limit 3
```

**Upstream:** [memory-system-usage](./memory-system-usage.md) · [Trigger Map](../rules/00-TRIGGER_MAP.md)
