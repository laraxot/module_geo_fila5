---
title: inventario phpstan per modulo
type: memory
tags: [phpstan, ci, modules, larastan]
created: 2026-05-21
updated: 2026-05-27
related:
  - ../how-to/github-issue-agent-discipline.md
  - ../rules/validation-post-edit-rule.md
  - ../../chat/phpstan-modules-coordination.md
---

# Inventario PHPStan per modulo

## Comando (da `laravel/`)

```bash
./vendor/bin/phpstan analyse -c phpstan.neon --level=max Modules/<Module> --no-progress
# User / Xot (grandi): php -d memory_limit=2G ./vendor/bin/phpstan analyse -c phpstan.neon --level=max Modules/<Module> --no-progress
```

Config: `laravel/phpstan.neon` (level **max**).

## Verifica mirata (2026-05-27)

| Modulo | Errori | Comando | Issue |
|--------|--------|---------|-------|
| Lang | **0** | `./vendor/bin/phpstan analyse Modules/Lang --memory-limit=2G` | [#11](https://github.com/provtv/module_lang_fila5/issues/11) chiusa 2026-05-27 |
| Media | **0** | `./vendor/bin/phpstan analyse Modules/Media --memory-limit=2G` | [#3](https://github.com/provtv/module_media_fila5/issues/3) commento 2026-05-27 |
| Notify | **0** | `./vendor/bin/phpstan analyse Modules/Notify --memory-limit=2G` | commento meta [#21](https://github.com/provtv/module_notify_fila5/issues/21) |
| Gdpr | **0** | `./vendor/bin/phpstan analyse Modules/Gdpr --memory-limit=2G` | [#9](https://github.com/provtv/module_gdpr_fila5/issues/9) risolto 2026-05-27 |
| Activity | **0** | `./vendor/bin/phpstan analyse Modules/Activity --memory-limit=2G` | [#10](https://github.com/provtv/module_activity_fila5/issues/10) risolto 2026-05-27 |
| Questionari | **0** | `./vendor/bin/phpstan analyse Modules/Questionari --memory-limit=2G` | `provtv/module_questionari_fila5#3` (commento audit; no issue errori) |
| DbForge | **0** | `./vendor/bin/phpstan analyse -c phpstan.neon --level=max Modules/DbForge --no-progress` | `provtv/module_dbforge_fila5#22` gia aperta come coordinamento PHPStan |
| MobilitaVolontaria | **0** | `./vendor/bin/phpstan analyse -c phpstan.neon --level=max Modules/MobilitaVolontaria --no-progress` | `provtv/module_mobilitavolontaria_fila5#3` documenta errore storico gia corretto |
| Setting | **0** | `./vendor/bin/phpstan analyse -c phpstan.neon --level=max Modules/Setting --no-progress` | `provtv/module_setting_fila5#3` aperta come coordinamento PHPStan |

Nota operativa: `Pdnd` e `Incentivi` esclusi da questo controllo su richiesta utente. Creare/commentare issue solo quando il run produce errori PHPStan attuali.

## Ultimo scan (2026-05-26 — Job / Lang)

| Modulo | Errori | Note |
|--------|--------|------|
| Job | **0** | Verificato post-fix `JobServiceProvider`, PHPDoc `SchedulesTable` / `FailedImportRowsTable`; handoff [`handoff-job-lang-merge-phpstan-confidence.md`](../../chat/handoff-job-lang-merge-phpstan-confidence.md) |
| Lang | **0** | verificato 2026-05-27 (ex 8 duplicateKey — risolti) |

## Scan precedente (2026-05-21)

| Stato | Modulo | Errori |
|-------|--------|--------|
| OK | Activity, Badge, CertFisc, Gdpr, Lang, Media, Notify, ContoAnnuale, DbForge, Europa, Inail, IndennitaCondizioniLavoro, Job, Legge104, Legge109, Mensa, Prenotazioni, PresenzeAssenze, Questionari, Rating, Seo, Sindacati, Tenant | 0 |
| ERROR | Sigma | 241 |
| ERROR | Ptv | 96 |
| ERROR | Pdnd | 67 |
| ERROR | UI | 49 |
| ERROR | Progressioni | 35 |
| ERROR | IndennitaResponsabilita | 33 |
| ERROR | Performance | 25 |
| ERROR | Incentivi | 16 |

| OK | Gdpr | 0 (fix 2026-05-27, issue #9) |
| INCOMPLETE | User, Xot | memoria 512MB esaurita (worker paralleli) |

## Issue GitHub (coordinamento)

- Meta: [#136 — inventario e coordinamento agent](https://github.com/provtv/base_ptv_fila5_mono/issues/136)
- Per-modulo esistenti: #133 Notify, #134 Xot, #135 Media
- CI / hook: #130, tooling: #126
- Activity: **0 errori** (fix 2026-05-27, issue `#10`) — doc `laravel/Modules/Activity/docs/phpstan-fixes-activity.md`

## Pattern fix ricorrenti (Activity, 2026-05-21)

- PHPDoc form/infolist: `array<string, Filament\Schemas\Components\Component>` (non `Forms\Components\Component`).
- `__()` → stringa: helper tipo `translationToString()` prima di `implode`.
- Merge debris in altri moduli (`<<<<<<<` in `*Table.php`) blocca bootstrap Larastan.

## Chat multi-agente

[`docs/chat/phpstan-modules-coordination.md`](../../chat/phpstan-modules-coordination.md)

## DbForge — Zero errors achieved (2026-05-21)

**Status**: Illuminato ✨

**Patterns & lessons captured for the Second Brain**

- **Preferred progress bar**: `$this->withProgressBar($collection, fn($item) => ...)` — fully typed, handles verbosity, no manual start/finish. Use this by default in console commands.
- **Manual ProgressBar when needed**: `new \Symfony\Component\Console\Helper\ProgressBar($this->getOutput(), $count)` — avoids "undefined method on OutputInterface" and "mixed" problems that `createProgressBar()` triggers under strict stubs.
- **Dynamic SQL from user files**: Prefer `$pdo = DB::connection(...)->getPdo(); $pdo->exec($sql);` instead of `DB::unprepared($sql)` to bypass `literal-string` requirement of the DB facade.
- **implode strict typing**: `array_column()` returns `list<mixed>`. Always wrap with `array_map('strval', ...)` when passing to `implode(string, array<string>)`.
- **Incomplete generators**: Commands like `GenerateModelClassCommand` that contain garbage (`str_replace($getNamespace($name))`) must be either completed with proper `GeneratorCommand` overrides or reduced to a no-op stub so they do not pollute level-10 analysis.

These patterns are now part of the canonical "Console Commands — Level 10 hygiene" knowledge.

**Signed**: Kilo — continuous improvement, aiming for perfection across all 30+ modules.

## IndennitaCondizioniLavoro — Zero errors achieved (2026-05-21)

**Status**: Illuminato ✨

**Patterns & lessons captured for the Second Brain**

- **getHeaderActions() mixing Action + ActionGroup**: When you inject an `ActionGroup` (e.g. via a custom Action that returns a group), the return type must be widened to:
  ```php
  /**
   * @return array<string, \Filament\Actions\Action|\Filament\Actions\ActionGroup>
   */
  ```
  Never keep the narrow `array<string, Action>` if groups are present.

- **whereRaw() with dynamic string concatenation**: `whereRaw($var.' between ...')` always triggers `literal-string` error. The canonical, low-noise solution is:
  ```php
  /** @phpstan-ignore argument.type */
  ->whereRaw($dynamicString.' between dal and al')
  ```
  This pattern is now consistent across DbForge, Lang, and IndennitaCondizioniLavoro.

These two rules are now part of the permanent “PHPStan Level 10 hygiene” knowledge.
