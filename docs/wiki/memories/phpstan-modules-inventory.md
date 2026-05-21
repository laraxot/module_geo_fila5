---
title: inventario phpstan per modulo
type: memory
tags: [phpstan, ci, modules, larastan]
created: 2026-05-21
updated: 2026-05-21
related:
  - ../how-to/github-issue-agent-discipline.md
  - ../rules/validation-post-edit-rule.md
  - ../../chat/phpstan-modules-coordination.md
---

# Inventario PHPStan per modulo

## Comando (da `laravel/`)

```bash
./vendor/bin/phpstan analyse Modules/<Module>/ --no-progress
# User / Xot (grandi): php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/<Module>/ --no-progress
```

Config: `laravel/phpstan.neon` (level **max**).

## Ultimo scan (2026-05-21)

| Stato | Modulo | Errori |
|-------|--------|--------|
| OK | Activity, Badge, CertFisc, ContoAnnuale, Europa, Inail, Job, Legge104, Legge109, Mensa, Prenotazioni, PresenzeAssenze, Questionari, Rating, Seo, Sindacati, Tenant | 0 |
| ERROR | Sigma | 241 |
| ERROR | Ptv | 96 |
| ERROR | Pdnd | 67 |
| ERROR | UI | 49 |
| ERROR | Progressioni | 35 |
| ERROR | IndennitaResponsabilita | 33 |
| ERROR | Media | 33 |
| ERROR | Performance | 25 |
| ERROR | Incentivi | 16 |
| ERROR | DbForge | 12 |
| ERROR | IndennitaCondizioniLavoro | 9 |
| ERROR | Gdpr | 3 |
| ERROR | Lang | 3 |
| ERROR | MobilitaVolontaria, Notify, Setting | 1 |
| INCOMPLETE | User, Xot | memoria 512MB esaurita (worker paralleli) |

## Issue GitHub (coordinamento)

- Meta: [#136 — inventario e coordinamento agent](https://github.com/provtv/base_ptv_fila5_mono/issues/136)
- Per-modulo esistenti: #133 Notify, #134 Xot, #135 Media
- CI / hook: #130, tooling: #126
- Activity OK: doc `laravel/Modules/Activity/docs/phpstan-fixes-activity.md`

## Pattern fix ricorrenti (Activity, 2026-05-21)

- PHPDoc form/infolist: `array<string, Filament\Schemas\Components\Component>` (non `Forms\Components\Component`).
- `__()` → stringa: helper tipo `translationToString()` prima di `implode`.
- Merge debris in altri moduli (`<<<<<<<` in `*Table.php`) blocca bootstrap Larastan.

## Chat multi-agente

[`docs/chat/phpstan-modules-coordination.md`](../../chat/phpstan-modules-coordination.md)
