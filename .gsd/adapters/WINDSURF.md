# GSD Adapter — Windsurf/Cascade

## Overview

This adapter maps GSD commands to Windsurf/Cascade workflows and capabilities.

## Command Mapping

| GSD Command | Windsurf Equivalent |
|------------|-------------------|
| `/gsd:new-project` | `/gsd` workflow → `new-project` |
| `/gsd:discuss-phase N` | `/gsd` workflow → `discuss N` |
| `/gsd:plan-phase N` | `/gsd` workflow → `plan N` |
| `/gsd:execute-phase N` | `/gsd` workflow → `execute N` |
| `/gsd:verify-work N` | `/gsd` workflow → `verify N` |
| `/gsd:quick "desc"` | `/gsd` workflow → `quick "desc"` |
| `/gsd:map-codebase` | `/gsd` workflow → `map` |
| `/gsd:progress` | `/gsd` workflow → `progress` |
| `/gsd:pause-work` | `/gsd` workflow → `pause` |
| `/gsd:resume-work` | `/gsd` workflow → `resume` |

## Cascade-Specific Features

### Tool Usage
- Use `code_search` for codebase analysis during map-codebase
- Use `grep_search` for finding patterns during research
- Use `find_by_name` for discovering module structure
- Use `todo_list` for tracking GSD phase progress
- Use `create_memory` for persisting GSD state across sessions
- Use `mcp7_sequentialthinking` for complex planning decisions

### Context Management
- Read `.planning/STATE.md` at session start
- Update `STATE.md` after each phase transition
- Keep `.planning/config.json` in sync with workflow decisions

### Quality Gates (Laraxot)
After every execute phase, run:
1. `cd laravel && ./vendor/bin/phpstan analyse Modules/{affected} --memory-limit=-1 --no-progress`
2. `cd laravel && ./vendor/bin/pint --dirty`
3. Verify no `->label()` in Filament components
4. Verify `declare(strict_types=1)` in all new PHP files

## Session Management

### Starting a Session
1. Read `.planning/STATE.md`
2. Read `.planning/config.json`
3. Check `todo_list` for pending items
4. Resume from last phase

### Ending a Session
1. Update `.planning/STATE.md` with current progress
2. Commit planning docs if `commit_docs: true`
3. Create memory with session summary
