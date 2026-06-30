---
title: "Ponytail audit — report over-engineering (codebase)"
type: architecture
tags: [ponytail, audit, yagni, over-engineering, planning]
created: 2026-06-30
updated: 2026-06-30
qmd: "ponytail audit report over-engineering riduzione codice vincoli predis compoships"
issues:
  - "https://github.com/provtv/base_ptv_fila5_mono/issues/173"
discussions:
  - "https://github.com/provtv/base_ptv_fila5_mono/discussions/174"
related:
  - "./ponytail-audit-plan.md"
  - "./wiki/how-to/module-docs-audit.md"
  - "./wiki/sources/code-redundancy-audit.md"
---

# Ponytail audit — report

Audit repo-wide (modalità ponytail-audit): solo over-engineering e complessità evitabile. **Fuori scope:** correttezza, sicurezza, performance.

**Pianificazione discussione:** [ponytail-audit-plan.md](./ponytail-audit-plan.md)

## Scope e vincoli (decisioni maintainer)

| Voce | Decisione |
|------|-----------|
| Moduli **Pdnd**, **Incentivi** | Esclusi dall'audit operativo |
| `predis/predis` | **Mantenere** — Redis non funziona senza |
| `awobaz/compoships` | **Mantenere** — adozione da mappare sui modelli con chiavi composite |
| `.env` storici (`laravel/.env*`) | **Mantenere** — storico operativo, non bloat |
| `.gitignore` per modulo | **Mantenere** — ogni modulo è repo git separata |
| Post-edit su ogni `.php` | PHPStan L10, PHPMD (`./tools/phpmd.sh`), PHP Insights (`./tools/phpinsights.sh`), Pest se assente |
| Docs | Aggiornare `docs` modulo/tema + ingest QMD dopo ogni modifica documentale |

## Findings codice (sessione agent — ranked)

### Tier A — quick win, basso rischio

| Tag | Cosa | Replacement | Path |
|-----|------|-------------|------|
| `delete` | `GetAllModuleTranslationAction` duplicato byte-per-byte, zero caller | Tenere `GetAllTranslationAction` | `laravel/Modules/Lang/app/Actions/` |
| `delete` | `ProfileTest` stub in produzione (`echo 'ciao'`) | Niente | `laravel/Modules/Xot/app/Services/ProfileTest.php` |
| `delete` | Gerarchia `Translators/` vuota (Base + 5 sottoclassi) | Lang/API quando servono | `laravel/Modules/Xot/app/Services/Translators/` |
| `delete` | `composer.json` orfano stack Assetic/Less/Scss/Twig | Niente (non mergiato in root) | `laravel/Modules/Xot/app/Services/composer.json` |
| `delete` | `composer.json` tema One sotto `User/resources/views/` | Path canonico `Themes/One/` | `laravel/Modules/User/resources/views/composer.json` |
| `delete` | Test su `CriteriEsclusioneService` — classe assente | Rimuovi test o implementa servizio | `laravel/Modules/Performance/tests/` |
| `delete` | Regola Cursor duplicata `updateTimestamps` | Una sola `.mdc` | `.cursor/rules/migration-update*` |
| `yagni` | `UseCaseContract` senza implementazioni | Action dirette o rimuovi contratto | `laravel/Modules/User/app/Application/UseCases/Owners/` |
| `yagni` | Doppio `StabiDirigenteContract` | Un path canonico | `laravel/Modules/Ptv/app/Contracts/` vs `Models/Contracts/` |

### Tier B — duplicazione dominio (discutere prima)

| Tag | Cosa | Replacement | Path |
|-----|------|-------------|------|
| `yagni` | `CriteriPrecedenzaService` Ptv ↔ Progressioni (Ptv importa model Progressioni) | Un Action nel modulo owner | `Ptv` + `Progressioni` Services |
| `yagni` | `CriteriValutazioneService` Performance ↔ Progressioni | Stesso pattern del precedente | `Performance` + `Progressioni` |
| `shrink` | Tre `Safe*CastAction` quasi identiche (~915 LOC) | Una action + discriminante sorgente | `laravel/Modules/Xot/app/Actions/Cast/` |
| `shrink` | `GetFactoryAction` (~190 LOC) per `Model::factory()` | Convenzione Laravel + dump-autoload | `laravel/Modules/Xot/app/Actions/Factory/` |

### Tier C — strutturale / incrementale (non big-bang)

| Tag | Cosa | Replacement | Path |
|-----|------|-------------|------|
| `yagni` | Layer `Services/` legacy (~146 file, ~14k LOC) vs religione `QueueableAction` | Migrazione graduale al tocco feature | `laravel/Modules/*/app/Services/` |
| `delete` | Backup monolith regole agente (~126k righe `.bak`) | Git history | `laravel/*.embedded-rules.FULL.md.bak`, altri `.bak` |
| `native` | `NullMapService` / `NullGeocodingService` | Binding condizionale se Geo assente | `laravel/Modules/UI/app/Services/Map/` |

### Fuori scope (non proporre tagli)

- **Pdnd** — alberi modello ANPR per servizio (C003/C007/…)
- **Incentivi** — intero modulo
- **predis**, **compoships**, **.env** storici, **.gitignore** modulari — vedi tabella vincoli

## Findings infrastruttura (report precedente — da validare)

Punti del report storico ancora da discutere in [plan](./ponytail-audit-plan.md#punto-6-infrastruttura-e-tooling):

- PHPStan doc duplicati in `Modules/*/docs/phpstan*`
- `_ide_helper*.php` committati
- Config vuoti `laravel/config/*.php`
- Script bash duplicati in `bashscripts/`
- `php-cs-fixer*` vs `pint.json`
- `phpstan_constants.php` / `rector.php` / `grumphp.yml` replicati
- Dipendenze AWS/Sentry senza env (da verificare uso reale)
- `larastan`/`phpstan` in `require` vs `require-dev`

**Correzioni già applicate al report:** predis, compoships, `.env`, `.gitignore` moduli — non sono candidati eliminazione.

## Compoships — gap adozione (azione positiva)

`awobaz/compoships` è in `Modules/Xot/composer.json` ma **nessun model PHP usa ancora** `Compoships` / `HasCompositeKeys` (grep 2026-06-30).

Documentazione esistente: `laravel/Modules/Xot/docs/models.md`, `relationship.md`.

**Prossimo passo:** mappare relazioni multi-colonna (es. Sigma/Ptv/Performance) e proporre adozione — non rimozione dipendenza.

## Stima tagli (solo se approvati in planning)

| Tier | LOC indicative | Dipendenze |
|------|----------------|------------|
| A quick win | ~200–400 | ~0–1 (composer orfani) |
| B duplicazione | ~1.000–1.500 | 0 |
| C strutturale | ~14k+ (Services) + ~126k (.bak) | variabile |

**net realistico fase 1 (Tier A):** ~300 linee, 0 dep critiche.

---

*Audit one-shot — non applica modifiche. Esecuzione solo dopo OK in [plan](./ponytail-audit-plan.md).*
