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

See full rules: [critical-rules-summary.md](.agents/docs/agents-guide/04-architecture/critical-rules-summary.md)

## Navigation Index

- [Project Setup](.agents/docs/project-setup.md)
- [Agent Teams](.agents/docs/agent-teams.md)
- [Documentation Standards](.agents/docs/documentation-standards.md)
- [Laraxot Philosophy](.agents/docs/laraxot-philosophy.md)
