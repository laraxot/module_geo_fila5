# AGENT_MEMORY.md - Project Patterns Summary

> Full documentation index: [.agents/docs/agents-guide/00-index.md](.agents/docs/agents-guide/00-index.md)

**Project**: PTVX Fila5 Mono
**Scope**: Development patterns, coding standards, architecture

## Pattern References

| Topic | Documentation |
|-------|------|
| Critical Rules | [critical-rules-summary.md](.agents/docs/agents-guide/04-architecture/critical-rules-summary.md) |
| Action Pattern | [project-patterns.md](.agents/docs/agents-guide/13-references/project-patterns.md) |
| Database Patterns | [.agents/docs/database-patterns.md](.agents/docs/database-patterns.md) |
| Model Rules | [.agents/docs/laraxot-model-rules.md](.agents/docs/laraxot-model-rules.md) |
| Migration Patterns | [.agents/docs/migration-patterns.md](.agents/docs/migration-patterns.md) |
| Filament Patterns | [.agents/docs/filament-patterns.md](.agents/docs/filament-patterns.md) |
| First Rule (Read→Reason→Study) | [.agents/docs/agents-first-rule.md](.agents/docs/agents-first-rule.md) |

## Key Rules Reminder

### Action pattern (CRITICAL)
```php
// CORRECT - Spatie QueueableAction + app() resolution
app(CreateClientAction::class)->execute($data);
```

### Short array syntax (CRITICAL)
**ALWAYS** `[]` — **NEVER** `array()` in any PHP file.

### Workspace file naming (CRITICAL)
**Every module MUST have exactly ONE** `.code-workspace` file named `_<module_name_in_snake_case>.code-workspace`.

Examples:
- `Modules/Xot/_xot.code-workspace` ✓
- `Modules/Activity/_activity.code-workspace` ✓
- `Modules/CertFisc/_cert_fisc.code-workspace` ✓

**NEVER** have multiple workspace files in one module directory.
See: `laravel/Modules/Xot/docs/workspace-file-rule.md`

### Module directory structure (CRITICAL)
**All source code MUST be in `app/`, NEVER in module root.**

Correct locations:
- `Modules/Xot/app/Datas/XotData.php` ✓
- `Modules/Xot/app/Filament/Forms/Components/XotBasePlaceholder.php` ✓
- `Modules/Xot/app/Services/ArrayService.php` ✓

Removed from root:
- `Modules/Xot/Datas/` ❌ (entire folder)
- `Modules/Xot/Filament/` ❌ (entire folder)
- `Modules/Xot/Services/` ❌ (entire folder)
- `Modules/Xot/Helpers/` ❌ (entire folder)
- `Modules/Xot/helpers/` ❌ (entire folder, lowercase)

Data Objects, Actions, Models, Services, Filament components, Helpers all go in `app/`.
See: `laravel/Modules/Xot/docs/module-directory-structure-rule.md`

### Backup/Copy files (CRITICAL)
**NEVER commit backup or copy files.**

Patterns in `.gitignore` (root and module):
- `* copy.*` - Copy files (e.g., `.gitconfig copy`)
- `*.copy` - Files with .copy extension
- `*.bak`, `*.backup` - Backup files
- `*.old`, `*_old` - Old files

All existing copy/backup files deleted (2026-03-13).
See: `laravel/Modules/Xot/docs/backup-copy-files-cleanup-rule.md`

### Script Location Rule (CRITICAL)
**All `.sh` scripts MUST be in `bashscripts/`, NEVER in `docs/` or root.**

Correct:
- `bashscripts/ollama-optimize.sh` ✓
- `bashscripts/ai/ollama-cmd.sh` ✓
- `bashscripts/docs/ollama/ollama-optimize.md` (documentation) ✓

Wrong:
- `docs/ollama-optimize.sh` ✗
- `workspace-discussion.md` in root ✗ (should be `docs/`)

Scripts must be categorized (ai/, maintenance/, backup/, etc.) and documented in `bashscripts/docs/{category}/`.
Documentation files (`.md`) go in `docs/`, NOT in root.
See: `bashscripts/docs/script-location-rule.md` and `docs/FILE_LOCATION_RULES.md`

### AI Agent Junction Rule (CRITICAL)
**All AI agent directories (`.qwen`, `.cursor`, `.claude`) MUST be centralized in `bashscripts/ai/` with symlinks.**

Structure:
```
bashscripts/ai/.qwen/     # Source of truth (commands, skills, rules)
.qwen/                    # Symlink -> bashscripts/ai/.qwen
laravel/.qwen/            # Symlink -> ../bashscripts/ai/.qwen
```

This ensures:
- Single source of truth for all AI files
- Easy synchronization across project
- Clean project structure

See: `bashscripts/docs/AI_AGENT_JUNCTION_RULE.md`

### Packages
Packages go in `Modules/{Module}/composer.json`. Run `composer go` from `laravel/`.

## Commit and Push Rule (CRITICAL)

**After completing ANY task, you MUST commit and push immediately.**

Workflow:
1. Verify work works
2. Review changes: `git status`, `git diff`
3. Stage all: `git add -A`
4. Commit with clear message: `git commit -m "type: description"`
5. Push to remote: `git push origin dev`
6. Verify: `git status` (should show "working tree clean")

NEVER leave work uncommitted. Commit after every task.

See: `bashscripts/docs/COMMIT_AND_PUSH_RULE.md`

## Session History & Decisions
See full log: [memories.md](.agents/docs/memories.md)

- Use PHAR only for PHPMD.
- NEVER use `RefreshDatabase` in tests.
- Central discussion: `https://github.com/provtv/base_ptv_fila5_mono/discussions/18`
