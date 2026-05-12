---
title: "LLM Wiki On-Demand Knowledge Pattern"
type: "rule"
tags: [llm-wiki, karpathy, on-demand, qmd, token-budget]
created: 2026-05-12
updated: 2026-05-12
---

# LLM Wiki — On-Demand Knowledge Pattern

> Wiki = single source of truth. Rules/skills/memories loaded on-demand, never pre-loaded.

## Directory Structure

```
docs/
├── raw/                         # immutable sources (read-only)
├── wiki/                        # root synthesized knowledge
│   ├── index.md                # master catalog
│   ├── log.md                  # append-only activity log
│   ├── rules/
│   │   ├── 00-TRIGGER_MAP.md  # unified trigger → rule map
│   │   └── on-demand-pattern.md
│   ├── skills/INDEX.md
│   ├── commands/INDEX.md
│   ├── memories/INDEX.md
│   ├── agents/INDEX.md
│   └── concepts/
laravel/Modules/<Name>/docs/wiki/   # module-local wiki
laravel/Themes/<Name>/docs/wiki/    # theme-local wiki
bashscripts/docs/wiki/              # tooling wiki
```

## On-Demand Workflow

```
Task triggered
    ↓
Consult 00-TRIGGER_MAP.md           ← canonical trigger map
    ↓
qmd search "<topic>" --limit 5       ← on-demand retrieval
    ↓
Read only matched wiki files
    ↓
Apply rule / use skill
    ↓
Update nearest docs/wiki/log.md
```

## Bootstrap Discipline

Stubs (`CLAUDE.md`, `QWEN.md`, `GEMINI.md`, `AGENTS.md`) must be **≤50 lines** — no embedded rules, skills, or memories.

## Cache Discipline

| Path | Status |
|------|--------|
| `./.cache` | ✗ FORBIDDEN |
| `${HOME}/.cache/qmd-cache/` | ✓ XDG compliant |

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

| Level | Method |
|-------|--------|
| 0 | Full text (critical decisions) |
| 1 | Remove examples (standard docs) |
| 2 | Abbreviate fields (API references) |
| 3 | Schema only (large datasets) |
| 4 | Hashes/pointers (archive, avoid) |

## Git Policy

- Forward only: study with `git log`, `git show`, `git diff <hash>^!` — never restore
- No `_archive/`, `archive/`, `backup/` folders
- Atomic commits

## Every Module & Theme Has

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

Each INDEX.md: ≤20 lines, frontmatter, links to root trigger map, `qmd search` instructions.

## QMD Commands

```bash
qmd search "<query>" --limit 5    # keyword (fast)
qmd query "<topic>" --limit 3      # semantic (slower)
qmd update                         # rebuild index
```

## See Also

- [Trigger Map](./00-TRIGGER_MAP.md)
- [Skills INDEX](../skills/INDEX.md)
- [Commands INDEX](../commands/INDEX.md)
- [Memories INDEX](../memories/INDEX.md)
- [Agents INDEX](../agents/INDEX.md)
