# AGENTS.md

> Index: [.agents/docs/agents-guide/00-index.md](.agents/docs/agents-guide/00-index.md)

**Stack**: Laravel 12 | Filament v5 | Pest v4 | PHPStan L10 | PHP 8.3+

## Regola Fondamentale

**Read → Reason → Study → Update → Improve**

Prima di modificare: leggi → ragiona → studia → aggiorna docs → migliora.

After edit: PHPStan + PHPMD + PHPInsights.

## Quick Commands

| Action | Command |
|--------|---------|
| Tests | `./vendor/bin/pest` |
| PHPStan | `php -d memory_limit=2G ./vendor/bin/phpstan analyse` |
| Pint | `./vendor/bin/pint --dirty` |

→ [Dettagli](.agents/docs/agents-guide/02-tooling/quick-commands.md)

## Regole Critiche

- PHPStan Level 10 — no ignores
- `declare(strict_types=1)` always
- Short array `[]` — mai `array()`
- No `property_exists()` — usa `isset()`
- No constructor DI in Actions — usa `app(ActionClass::class)->execute()`
- No direct Filament — usa `XotBase*`

→ [Tutte le regole](.agents/docs/agents-guide/04-architecture/critical-rules-summary.md)

## MCP

Config: `.cursor/mcp.json`

| Server | Purpose |
|--------|---------|
| filesystem | File operations |
| mysql | Database |
| playwright | Browser testing |
| git | Git operations |

→ [MCP details](docs/mcp/mcp-overview.md)
