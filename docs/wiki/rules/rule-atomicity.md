---
title: "Rule Atomicity"
type: "rule"
tags: [rules, atomic-notes, wiki, dry]
created: 2026-05-19
updated: 2026-05-19
---

# Rule Atomicity

> One rule file = one enforceable idea; route combinations via trigger map.

## Rules

- Target ≤30 lines body (+ YAML frontmatter): decision, scope, verify command
- No skill workflows inside rule files — link `docs/wiki/skills/`
- No duplicate of `00-TRIGGER_MAP.md` — add a row there instead of a second map
- INDEX files ≤20 lines: summary + links only
- Filename: lowercase-kebab-case under `docs/wiki/rules/`
- YAML + corpo: rispettare [markdown-note-minimum-standard](../concepts/markdown-note-minimum-standard.md) (HackerNoon Tip 020)

## Verify

```bash
wc -l docs/wiki/rules/rule-atomicity.md
bashscripts/quality-gates/verify-llm-wiki.sh
```

**Upstream:** [Trigger Map](./00-TRIGGER_MAP.md) · [On-demand pattern](./on-demand-pattern.md)
