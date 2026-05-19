# Laravel — AI Agents (on-demand stub)

> **Do not embed rules here.** Full guidelines were moved to backup — they caused API errors (`131072` token limit, ~796k requested).

## Read first

- [Trigger Map](../docs/wiki/rules/00-TRIGGER_MAP.md)
- [Context overflow](../docs/wiki/concepts/context-overflow-prevention.md)
- [LLM wiki prompt](../bashscripts/tools/prompts/llm-wiki.txt)

## On-demand

```bash
qmd search "<topic>" --limit 5
```

## Full guidelines (chunked read only)

- `laravel/AGENTS.embedded-rules.FULL.md.bak` — legacy monolith; use `Read` with `offset`/`limit`, never attach whole file
- `laravel/.cursor/laravel-boost-guidelines.FULL.mdc.bak` — same discipline
- Split sources: `laravel/.ai/*.md` when present

*Updated: 2026-05-20*
