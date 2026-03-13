# AGENTS.md - Development Guide Index

> Full documentation index: [.agents/docs/agents-guide/00-index.md](.agents/docs/agents-guide/00-index.md)

**Stack**: Laravel 12 | Filament v5 | Pest v4 | PHPStan Level 10 | PHP 8.3+

## First rule: Read → Reason → Study → Update → Improve

See full guide: [.agents/docs/agents-first-rule.md](.agents/docs/agents-first-rule.md)

Before modifying ANY file: Read → Reason → Study → Update docs → Improve.
After edit: PHPStan + PHPMD + PHPInsights.

## Quick Commands Reference

| Action | Command |
|--------|---------|
| **Tests** | `./vendor/bin/pest --filter="test_name"` |
| **PHPStan** | `php -d memory_limit=2G ./vendor/bin/phpstan analyse` |
| **PHPMD** | `bash laravel/tools/phpmd.sh laravel text phpmd.xml ...` |
| **Pint** | `./vendor/bin/pint --dirty` |
| **Build** | `npm run dev && npm run build` |
| **Merge** | `composer go` |

See more in: [quick-commands.md](.agents/docs/agents-guide/02-tooling/quick-commands.md)

## Critical Rules Summary

- **PHPStan Level 10** — no ignores.
- **`declare(strict_types=1)`** always.
- **Short array syntax `[]`** always.
- **`property_exists()` forbidden** — use `isset()`.
- **No constructor DI in Actions** — use `app(ActionClass::class)->execute()`.
- **No direct Filament extensions** — use `XotBase*` wrappers.
- **Workspace files**: Only `_{module-name}.code-workspace` in each module folder.

See full rules: [critical-rules-summary.md](.agents/docs/agents-guide/04-architecture/critical-rules-summary.md)

## Workspace Convention

- **One module, one workspace**: Each module has ONLY its own `_{module-name}.code-workspace`
- **Naming**: File name must match module name (lowercase)
- **Location**: Root of module folder
- **Examples**:
  - ✅ `laravel/Modules/Xot/_xot.code-workspace`
  - ✅ `laravel/Modules/Activity/_activity.code-workspace`
  - ❌ `laravel/Modules/Xot/_activity.code-workspace` (wrong module)

See full convention: [docs/conventions/workspace-naming.md](docs/conventions/workspace-naming.md)

## Module Folder Structure

- **All PHP classes under `app/`**: Models, Enums, Actions, Controllers, etc.
- **Exceptions**: Only Xot module can have special folders in root (`helpers/`, `Datas/`, `Services/`, `Filament/`, `packages/`, `stubs/`)
- **Never in root**: `Enums/`, `Models/`, `Actions/`, `Controllers/` (use `app/Enums/`, `app/Models/`, etc.)
- **Examples**:
  - ✅ `laravel/Modules/Gdpr/app/Enums/ConsentType.php`
  - ❌ `laravel/Modules/Gdpr/Enums/ConsentType.php` (wrong, duplicate)
  - ✅ `laravel/Modules/Xot/helpers/` (Xot-specific exception)

See full convention: [docs/conventions/module-folder-structure.md](docs/conventions/module-folder-structure.md)

## Copy Files Rule

- **Never commit copy files**: Files named `* copy`, `*.copy`, `*~` are temporary duplicates
- **Auto-ignored**: Added to `.gitignore` in root and all modules
- **Delete immediately**: Remove after use or if not needed
- **Examples**:
  - ❌ `.gitattributes copy` (delete or rename)
  - ❌ `file.php copy` (delete or rename properly)
  - ✅ Use git branching instead of file copies

See full convention: [docs/conventions/copy-files-cleanup.md](docs/conventions/copy-files-cleanup.md)

## Bash Scripts Organization

- **All .sh scripts in `bashscripts/`**: Never in module root or other directories
- **Documentation in `bashscripts/docs/`**: Every script must have corresponding docs
- **Naming**: lowercase with hyphens (e.g., `ollama-optimize.sh`)
- **Executable**: Always `chmod +x` after creation
- **Examples**:
  - ✅ `bashscripts/ollama-optimize.sh` + `bashscripts/docs/ollama-optimize.md`
  - ❌ `ModuleRoot/script.sh` (wrong location)
  - ❌ `bashscripts/script.sh` without docs (incomplete)

See full convention: [bashscripts/docs/](bashscripts/docs/)

## AI Agent Coordination

- **Read before acting**: Always check [docs/ai-agent-coordination.md](docs/ai-agent-coordination.md)
- **Update after action**: Mark tasks as complete, add notes
- **Avoid conflicts**: Check for concurrent agents, use lock files
- **Document everything**: GitHub Issues, commits, coordination doc
- **Coordinate with other agents**: Use GitHub Discussions for decisions

See coordination hub: [docs/ai-agent-coordination.md](docs/ai-agent-coordination.md)

## Navigation Index

- [Project Setup](.agents/docs/project-setup.md)
- [Agent Teams](.agents/docs/agent-teams.md)
- [Documentation Standards](.agents/docs/documentation-standards.md)
- [Laraxot Philosophy](.agents/docs/laraxot-philosophy.md)
