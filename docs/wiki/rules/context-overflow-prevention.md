---
title: "Context Overflow Prevention — 262K Token Limit"
type: "rule"
tags: [context, tokens, windsurf, compaction, session]
created: 2026-05-12
updated: 2026-05-12
confidence: high
---

# Context Overflow Prevention

## Problem

Windsurf (Cascade) uses Anthropic Claude with a **262,144 token** context limit.
Overflow error: `API Error: 400 — maximum context length is 262144 tokens`.

Causes:
- Raw large file reads accumulated over many turns
- Unfiltered command output (PHPStan on full module, git log, composer install)
- Loading too many wiki/rule files "just in case"
- Parallel tool calls each returning large outputs

## Windsurf Rules Installed

Files in `.windsurf/rules/` (loaded automatically by IDE):

| Rule file | Purpose |
|---|---|
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

### Emergency Recovery (overflow imminent)
1. Stop all tool calls
2. Write 5-bullet summary to `docs/wiki/log.md`
3. Start new conversation — paste summary as first message

## Session Size Heuristics

| Indicator | Action |
|---|---|
| >15 tool call turns | Consider splitting session |
| Read >5 large files | Summarize and drop from active reference |
| PHPStan run on full module | Use `tail -25`, not full output |
| `list_dir` on Modules/ | Never — too many items |

## Vedi anche

- `.windsurf/rules/` — regole IDE caricate automaticamente
- [llm-wiki-operational-discipline](../concepts/llm-wiki-operational-discipline.md) — token budget §5
- [00-TRIGGER_MAP](./00-TRIGGER_MAP.md)
