---
title: "LLM Wiki Operational Discipline"
type: "concept"
tags: [llm-wiki, karpathy, on-demand, token-budget, git-policy, bootstrap]
created: 2026-05-12
updated: 2026-05-19
---

# LLM Wiki Operational Discipline

> Operational rules derived from the Karpathy LLM Wiki pattern. Wiki = single source of truth. Load on-demand, never pre-load.

## Reality discipline

Verifica sempre path e permessi prima di affermare «è così nel filesystem». Nessun path wiki/read è garantito immutabile: convenzioni di processo ≠ invarianti tecniche. Approfondimento e formulazioni aggiornate: [`bashscripts/tools/prompts/llm-wiki.txt`](../../../bashscripts/tools/prompts/llm-wiki.txt) §3.1.

## Core Principle

Bootstrap stubs (`CLAUDE.md`, `QWEN.md`, `GEMINI.md`, `AGENTS.md`) must be **≤50 lines** — no embedded rules, skills, or memories. All knowledge lives in `docs/wiki/`.

## Workflow

```
Task triggered
    ↓
Consult docs/wiki/rules/00-TRIGGER_MAP.md
    ↓
qmd search "<topic>" --limit 5
    ↓
Read only matched wiki files
    ↓
Apply rule / use skill
    ↓
Update nearest docs/wiki/log.md
```

## Cache Discipline

| Path | Status |
|------|--------|
| `./.cache` | ✗ FORBIDDEN |
| `${HOME}/.cache/qmd-cache/` | ✓ XDG compliant |
| `bashscripts/ai/.agents/node_modules` | ✗ Use `laravel/node_modules` |

## Token Budget

| Component | Max |
|-----------|-----|
| Bootstrap stubs | 0.5K |
| User message | 50K |
| Loaded docs | 100K |
| Tool responses | 30K |
| Output | 32K |
| **Total** | **~200K** |

## Compression Levels

| Level | Method | When |
|-------|--------|------|
| 0 | Full text | Critical decisions, security |
| 1 | Remove examples | Standard docs |
| 2 | Abbreviate fields | API references |
| 3 | Schema only | Large datasets |
| 4 | Hashes/pointers | Archive (avoid) |

## Git Policy

- **Forward only** — study history with `git log`, `git show`, `git diff <hash>^!`, never restore
- No cartelle i cui nomi violano il gate `bashscripts/quality-gates/verify-llm-wiki.sh`: `archive`, `_archive`, `archived`, `backup`, `backups`, `backup_*`, `*_backup`, `*-backup`. Per contenuti storici usare `legacy`, `superseded`, `snapshot` / `snapshots`.
- Atomic commits: one conceptual change per commit

## Bad Practices

| Bad Practice | Fix |
|---|---|
| Embedding rules in stubs | Point to wiki |
| Pre-loading skills/rules | Load on-demand |
| `.cache/` inside project | Use `${HOME}/.cache/` |
| Giant wiki pages (>500 lines) | Split into atomic notes |
| Content duplication wiki↔stubs | Wiki is source of truth |
| `git restore` to old version | Use `git show <hash>` |

## Module/Theme Wiki Structure

Each module and theme must have:

```
<module>/docs/wiki/
├── rules/INDEX.md
├── skills/INDEX.md
├── commands/INDEX.md
├── memories/INDEX.md
├── concepts/INDEX.md
├── log.md
└── index.md
```

Each `INDEX.md`: ≤20 lines, frontmatter, links to root trigger map.

## See Also

- [Trigger Map](../rules/00-TRIGGER_MAP.md)
- [On-Demand Pattern](../rules/on-demand-pattern.md)
