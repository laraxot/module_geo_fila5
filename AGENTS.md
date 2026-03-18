# AGENTS.md

> Index: [.agents/docs/agents-guide/00-index.md](.agents/docs/agents-guide/00-index.md)

**Stack**: Laravel 12 | Filament v5 | Pest v4 | PHPStan L10 | PHP 8.3+

## GSD (Get Shit Done) Integration

Questo progetto usa **GSD** per sviluppo spec-driven con context engineering.
GSD risolve il **context rot** — il degrado qualitativo quando il contesto dell'AI si riempie.

**Config GSD**: `.planning/config.json`
**State GSD**: `.planning/STATE.md`
**Templates**: `.gsd/templates/`
**Docs**: `docs/project/gsd-methodology.md`

→ Per workflow completo: usa `/gsd` (Windsurf) o "GSD {comando}" (Cursor)
→ Ciclo: `discuss → plan → execute → verify → complete`
→ Per task rapidi: `gsd quick "descrizione"`
→ Per stato: leggi `.planning/STATE.md`

### GSD Quick Commands

| Action | Command |
|--------|---------|
| New project | `/gsd` → `new-project` |
| Discuss phase | `/gsd` → `discuss N` |
| Plan phase | `/gsd` → `plan N` |
| Execute phase | `/gsd` → `execute N` |
| Verify work | `/gsd` → `verify N` |
| Quick task | `/gsd` → `quick "desc"` |
| Map codebase | `/gsd` → `map` |
| Progress | `/gsd` → `progress` |

## BMAD Method Integration

Questo progetto usa anche il **BMAD Method** per workflow strutturati enterprise.

**Configurazione BMAD**: `_bmad/` directory con workflow e configurazioni
**Catalog BMAD**: `_bmad/_config/bmad-help.csv` per tutti i workflow disponibili

→ Per guidanza: usa `bmad-help` skill o chiedi "cosa devo fare dopo?"
→ Per sviluppo rapido: usa `bmad-quick-dev` o `bmad-quick-dev-new-preview`
→ Per brainstorming: usa `bmad-brainstorming`

### Quando usare GSD vs BMAD

| Scenario | Framework |
|----------|-----------|
| Feature singola, refactoring | **GSD** |
| Bug fix complesso multi-file | **GSD** |
| Nuovo modulo completo | **BMAD** |
| Architettura, stakeholder alignment | **BMAD** |
| Sprint planning, epics, stories | **BMAD** |
| Quick task ad-hoc | **GSD quick** |

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
