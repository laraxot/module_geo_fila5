---
title: geo tests phpstan zero
type: chat
tags: [phpstan, geo, tests]
updated: 2026-09-24
related:
  - ../troubleshooting/phpstan.md
  - handoff-phpstan-modules-zero.md
---

# Geo tests — PHPStan a zero

## Esito

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Geo/tests --memory-limit=2G
# 123 file, 0 errori
```

## Causa / fix (DRY + KISS)

- **ComuneTest / comunetest**: niente scope fantasma `by*`, niente `@phpstan-ignore`; solo API pubbliche (`where`, `findByNome`, `findByCap`, `getComuniByProvincia`) + helper stringa per attributi cast array|string.
- **MapPicker tests**: rimossi `assertInstanceOf(MapPicker)` ridondanti (già tipizzati da `make()`).
- **Services / GeoMath / Here**: smoke ridondanti sostituiti con assert su valori reali (URL costanti, `base_url`, distanza zero).
- **Bootstrap**: conflitti marker su Resource/migrazioni Geo + `getInfolistSchema` sulle View Address/Location (richiesto da `XotBaseViewRecord`).

## File test toccati (principali)

- `tests/Unit/Models/ComuneTest.php`, `tests/Unit/Models/comunetest.php`
- `tests/Unit/Filament/*MapPicker*`, `FilamentComponentsTest.php`
- `tests/Unit/Services/{GoogleMaps,Here,Services}Test.php`
- `tests/Unit/Actions/GeoMathActionsTest.php`
- `tests/Unit/Actions/Here/GetHereRouteDurationAndLengthActionTest.php`
- `tests/Unit/Actions/GoogleMaps/*pest.php` (solo marker)
