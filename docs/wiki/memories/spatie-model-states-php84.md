---
title: "spatie/laravel-model-states su modulo Xot (PHP 8.4)"
type: memory
tags: [xot, spatie, composer, php84, model-states]
created: 2026-05-21
updated: 2026-05-21
related:
  - ../../../laravel/Modules/Xot/docs/wiki/concepts/laravel13-modular-package-compatibility-matrix.md
  - ../../../laravel/Modules/Xot/docs/wiki/concepts/phpstan-fixes-log.md
  - github-issues-proactive.md
---

# spatie/laravel-model-states + PHP 8.4

## Sintomo PHPStan

```
Class Modules\Xot\States\Transitions\XotBaseTransition extends unknown class Spatie\ModelStates\Transition
```

## Diagnosi (modulo owner: **Xot**)

- Codice in `laravel/Modules/Xot/app/States/*` usa `Spatie\ModelStates\State` / `Transition`.
- Package **non** in `composer.json` (solo nel lock storico / docs).
- [spatie/laravel-model-states `main`](https://github.com/spatie/laravel-model-states/blob/main/composer.json): `php ^8.4`, `illuminate` ^12|^13.
- Linea **2.12.1**: PHP 7.4–8.x ma solo Laravel ≤12 → **incompatibile** con Laravel 13 su PHP 8.3.
- Linea **≥2.12.2**: `php ^8.4` + Laravel 13.

## Fix applicato

1. Host: `php8.4` già presente; estensioni CLI **identiche** a `php8.3` (nessun modulo solo su 8.3).
2. `laravel/Modules/Xot/composer.json`: `"php": "^8.4"`, `"spatie/laravel-model-states": "^2.14"`.
3. `laravel/composer.json`: `"php": "^8.4"` (merge-plugin include moduli).
4. `cd laravel/Modules/Xot && rm -f composer.lock && php8.4 composer require -W spatie/laravel-model-states:^2.14`
5. `cd laravel && rm -f composer.lock && php8.4 composer update`
6. Composer/CLI progetto: usare **`php8.4`** finché `php` default resta 8.3.

## Non fare

- Installare `dev-main` o `2.14` con `php` 8.3 (composer fallisce).
- Duplicare il package nel root se l’owner è Xot/UI — merge-plugin lo risolve dal modulo.

## Issue

[#131](https://github.com/provtv/base_ptv_fila5_mono/issues/131) — audit trail.
