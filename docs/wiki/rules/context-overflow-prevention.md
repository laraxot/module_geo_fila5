---
title: "Context Overflow Prevention — 262K Token Limit"
type: "rule"
tags: [context, tokens, windsurf, compaction, session]
created: 2026-05-12
updated: 2026-05-19
confidence: high
---

# Context Overflow Prevention

> **Nota:** narrativa aggiornata (AGENTS stub, MCP context-mode, recovery **Cursor «Compaction exhausted»**) in [context-overflow-prevention (concepts)](../concepts/context-overflow-prevention.md). Questa pagina resta focalizzata su OpenCode/Windsurf e sui pattern CLI.

## Problem

Observed overflow:

```text
Error during compaction: API Error: 400
This endpoint's maximum context length is 262144 tokens.
However, you requested about 419418 tokens
```

Causes:

- Raw large file reads accumulated over many turns
- Unfiltered command output (PHPStan on full module, git log, composer install)
- Loading too many wiki/rule files "just in case"
- Parallel tool calls each returning large outputs
- OpenCode project config missing at git root, so compaction policy was not enforced at repository scope
- OpenCode plugin list empty (`plugin: []`) before remediation, so no extra pruning/compression layer was active

## Permanent Fix Applied

### OpenCode

- installed global plugin: `@tarquinen/opencode-dcp@latest`
- updated global config: `~/.config/opencode/opencode.json`
- added project config: `opencode.json` at git root

Project config now pins:

```json
{
  "$schema": "https://opencode.ai/config.json",
  "plugin": ["@tarquinen/opencode-dcp@latest"],
  "compaction": {
    "auto": true,
    "prune": true,
    "reserved": 56000
  }
}
```

### Why this is the durable fix

- `plugin` adds an extra pruning/compression layer before the provider sees the full prompt
- `compaction.prune=true` is explicit, not left to runtime defaults
- `reserved=40000` triggers compaction with real headroom on 262K-class endpoints
- config lives at the **git root**, where OpenCode actually resolves project config

## Windsurf Rules Installed

Files in `.windsurf/rules/` (loaded automatically by IDE):

| Rule file | Purpose |
| --- | --- |
| `context-budget.md` | Max lines per tool response, never-read list |
| `no-bulk-reads.md` | Forbidden patterns: composer.lock, package-lock.json, etc. |
| `tool-output-compression.md` | Compress PHPStan/git/composer output before context entry |
| `session-discipline.md` | Bootstrap sequence, overflow recovery protocol |

## Quick Reference

### Files NEVER to read into context

- `composer.lock`, `package-lock.json`
- `laravel/phpstan_errors.json`
- Any file >500 lines without offset+limit chunking
- `git log` without `-n 10 --oneline`

### Bounded command patterns

```bash
# PHPStan — 2 files max, tail output
./vendor/bin/phpstan analyse File1.php File2.php --level=3 --no-progress 2>&1 | tail -25

# git — bounded
git log -n 10 --oneline
git diff --stat HEAD~1

# find — depth limited
find_by_name(MaxDepth=3, max 20 results)

# grep — always filtered
grep_search(Includes=["*.php"], SearchPath="Modules/User/app/Policies/")
```

### Emergency Recovery

If the agent shows `Compaction exhausted: context still exceeds model limits after 3 attempts`:

1. Stop all broad tool calls immediately.
2. Write a short checkpoint to `docs/chat/<slug-argomento>.md` (goal, changed files, blockers, next command).
3. Start a fresh session and load only: trigger map, relevant issue, checkpoint, and exact files needed.
4. Use `qmd search --limit 5`; avoid semantic `qmd query` until the working set is small.
5. Use `rg` only after `.rgignore` is present and with narrow patterns. Do not pass ignored directories (`.cursor`, `.claude`, `.opencode`, `docs/pdf`, `docs/raw/history`) as explicit search paths because that bypasses the safety intent.
6. Disable unused MCP/tool providers in that session if the client supports it.

Do not keep asking the runtime to compact a polluted context; once compaction fails, recovery is a fresh-session/checkpoint workflow.

## Session Size Heuristics

| Indicator | Action |
| --- | --- |
| >15 tool call turns | Consider splitting session |
| Read >5 large files | Summarize and drop from active reference |
| PHPStan run on full module | Use `tail -25`, not full output |
| `list_dir` on Modules/ | Never — too many items |

## Vedi anche

- `.windsurf/rules/` — regole IDE caricate automaticamente
- [llm-wiki-operational-discipline](../concepts/llm-wiki-operational-discipline.md) — token budget §5
- [00-TRIGGER_MAP](./00-TRIGGER_MAP.md)
- [autocompact-thrashing-discipline](./autocompact-thrashing-discipline.md) — disciplina obbligatoria automatica su segnale runtime thrashing / telemetria
