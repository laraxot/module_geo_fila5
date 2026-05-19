---
title: "Git Atomic Operations"
type: "rule"
tags: [git, forward-only, commits, llm-wiki]
created: 2026-05-19
updated: 2026-05-19
---

# Git Atomic Operations

> One conceptual change per commit; study history, never restore operational state.

## Rules

- **Forward-only:** fix with new commits; use `git show <hash>` to study old code — no `git restore` for rollback.
- **Atomic commits:** scope = one decision (wiki route, rule, fix, or doc sync).
- **Messages:** explain *why*; details live in wiki (`docs/wiki/log.md`) or issue (`gh issue comment`).
- **No parking branches:** use stash or wiki notes instead of long-lived WIP branches.
- **Merge debris:** never commit `*~HEAD`, `*.orig`, `.agent~HEAD`; remove tracked copies with `git rm`.

## Verify

```bash
git log -3 --oneline
git status --short
find . -name '*.orig' -o -name '*~HEAD' 2>/dev/null | head
```

**Upstream:** [Trigger Map](./00-TRIGGER_MAP.md) · [LLM Wiki discipline](../concepts/llm-wiki-operational-discipline.md)
