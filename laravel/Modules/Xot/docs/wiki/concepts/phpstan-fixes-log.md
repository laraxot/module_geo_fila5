# PHPStan Fixes Log - Story 8-121

> **Story**: 8-121 - PHPStan Full Compliance (Zero Errors, No Ignoring)
> **Started**: 2026-05-05
> **Philosophy**: Zero tolerance per shortcut - correggere sempre la root cause

## Fix #1: spatie/laravel-model-states Missing Package

### Problem
```
Class Modules\Xot\States\XotBaseState extends unknown class Spatie\ModelStates\State
Class Modules\Xot\States\Transitions\XotBaseTransition extends unknown class Spatie\ModelStates\Transition
```

### Root Cause
Il package `spatie/laravel-model-states` era documentato come parte dell'architettura ma non era incluso in `composer.json`.

### Solution (2026-05-21)

1. `spatie/laravel-model-states:^2.14` in `Modules/Xot/composer.json` (owner).
2. `php: ^8.4` in Xot + root `laravel/composer.json`.
3. `php8.4 composer require` (modulo) + `php8.4 composer update` (root).
4. Memory: [`docs/wiki/memories/spatie-model-states-php84.md`](../../../../../docs/wiki/memories/spatie-model-states-php84.md).

### Solution (storico)
1. Aggiunto `
