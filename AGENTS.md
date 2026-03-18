# AGENTS.md

> Index: [.agents/docs/agents-guide/00-index.md](.agents/docs/agents-guide/00-index.md)

**Stack**: Laravel 12 | Filament v5 | Pest v4 | PHPStan L10 | PHP 8.3+

## BMAD Method Integration

Questo progetto usa il **BMAD Method** per workflow strutturati di sviluppo AI-driven.

**Configurazione BMAD**: `_bmad/` directory con workflow e configurazioni
**Catalog BMAD**: `_bmad/_config/bmad-help.csv` per tutti i workflow disponibili

→ Per guidanza: usa `bmad-help` skill o chiedi "cosa devo fare dopo?"
→ Per sviluppo rapido: usa `bmad-quick-dev` o `bmad-quick-dev-new-preview`
→ Per brainstorming: usa `bmad-brainstorming`

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
| BMAD Help | Chiedi "bmad-help" o "cosa devo fare dopo?" |

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
