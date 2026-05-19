---
title: "LLM Wiki On-Demand Knowledge Pattern"
type: "rule"
tags: [llm-wiki, karpathy, on-demand, qmd, token-budget, rules, skills]
created: 2026-05-12
updated: 2026-05-19
---

# LLM Wiki — On-Demand Knowledge Pattern

> Wiki = single source of truth. Rules, skills, commands, memories, and concepts are routed on-demand, never pre-loaded.

## Directory Structure

```text
docs/
├── raw/                         # source evidence, edit conservatively
├── wiki/                        # root synthesized knowledge
│   ├── index.md                 # master catalog
│   ├── log.md                   # append-only activity log
│   ├── rules/00-TRIGGER_MAP.md  # canonical trigger -> resource map
│   ├── rules/INDEX.md           # rule summary only
│   ├── skills/INDEX.md          # skill routing summary only
│   ├── commands/INDEX.md
│   ├── memories/INDEX.md
│   ├── agents/INDEX.md
│   └── concepts/
laravel/Modules/<Name>/docs/wiki/   # module-local wiki
laravel/Themes/<Name>/docs/wiki/    # theme-local wiki
bashscripts/docs/wiki/              # tooling wiki
```

## On-Demand Workflow

```text
Task triggered
    -> consult docs/wiki/rules/00-TRIGGER_MAP.md
    -> qmd search "<topic>" --limit 5
    -> read only matched wiki files
    -> apply rule / use skill / run command
    -> update nearest docs/wiki/log.md
```

## Reality Discipline

Do not state filesystem guarantees that were not verified. `docs/raw/` is source evidence and should be edited conservatively, but it is not assumed read-only. Verify actual file state and permissions before making claims.

## Trigger Resolution Contract

1. Classify the request as rule, skill, command, memory, concept, or source lookup.
2. Use the root trigger map first; use module/theme indexes only after the scope is known.
3. Prefer `qmd search` for names, paths, classes, and exact policy terms.
4. Use `qmd query` only when the user asks conceptually and exact terms are unknown.
5. Open only the specific matched pages needed to act.
6. Persist reusable conclusions back to the nearest wiki and log the update.

## Rules On-Demand

Rules answer "what must be true?" They constrain behavior.

- Rules live in `docs/wiki/rules/` or the nearest module/theme `docs/wiki/rules/`.
- `INDEX.md` files list and route rules; they do not contain full rule bodies.
- Cross-cutting rules must be visible from `docs/wiki/rules/00-TRIGGER_MAP.md`.
- Local rules may be stricter than root rules, but must link back to root routing.
- When a repeated mistake is fixed, add or tighten a rule instead of relying on memory.

## Skills On-Demand

Skills answer "how do I perform this task?" They describe repeatable workflows.

- Skills live in `docs/wiki/skills/` or the nearest module/theme `docs/wiki/skills/`.
- A skill page should include trigger, inputs, steps, outputs, verification, and related rules.
- Do not load skills speculatively; load the one matching the active task.
- If a task needs both a rule and skill, load the rule first, then the skill.
- If a workflow becomes repeatable, promote it from ad hoc notes into a skill page.

## Bootstrap Discipline

Stubs (`CLAUDE.md`, `QWEN.md`, `GEMINI.md`, `AGENTS.md`) must be <=50 lines and contain no embedded rules, skills, or memories. They point to the trigger map and skill index only.

## Cache Discipline

| Path | Status | Use |
|---|---|---|
| `./.cache` | forbidden | Must not exist |
| `${HOME}/.cache/qmd/` | allowed | QMD cache and models |
| `bashscripts/ai/.agents/node_modules` | forbidden | Use `laravel/node_modules` or symlink policy |

## Token Budget

| Component | Max | Strategy |
|---|---|---|
| Bootstrap stubs | 0.5K | Stub-only |
| User message | 50K | Summarize if oversized |
| Loaded docs | 100K | QMD-limited, matched pages only |
| Tool responses | 30K | Abbreviated schemas |
| Output | 32K | Reserved |
| Total | ~200K | Under 262K limit |

## Compression Levels

| Level | Method | When |
|---|---|---|
| 0 | Full text | Critical decisions, security |
| 1 | Remove examples | Standard docs |
| 2 | Abbreviate fields | API references |
| 3 | Schema only | Large datasets |
| 4 | Hashes/pointers | Archive, avoid if possible |

## Git Policy

- Forward only: study with `git log`, `git show`, `git diff <hash>^!`; never restore old code as a shortcut.
- No cartelle con nomi disciplina vietati: `archive`, `_archive`, `archived`, `backup`, `backups`, `backup_*`, `*_backup`, `*-backup` (usa `legacy`, `superseded`, `snapshot` / `snapshots` per contenuti storici o script).
- Atomic commits: one conceptual change per commit.

## QMD Commands

```bash
qmd search "<query>" --limit 5
qmd query "<topic>" --limit 3
qmd get "<path-or-docid>"
qmd update
```

Always pass `--limit N`. Run `qmd update` after structural wiki changes or after adding more than 10 wiki pages.

## See Also

- [Trigger Map](./00-TRIGGER_MAP.md)
- [Rules INDEX](./INDEX.md)
- [Skills INDEX](../skills/INDEX.md)
- [Commands INDEX](../commands/INDEX.md)
- [Memories INDEX](../memories/INDEX.md)
- [Second Brain Operating Model](../concepts/second-brain-operating-model.md)
- [Second Brain Continuous Improvement](../concepts/second-brain-continuous-improvement.md)
