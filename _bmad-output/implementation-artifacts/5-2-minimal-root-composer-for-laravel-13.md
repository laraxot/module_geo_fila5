# Story 5.2: Minimal Root Composer for Laravel 13

Status: ready-for-dev

## User Story

As a Laraxot maintainer,
I want `laravel/composer.json` to be small and Laravel 13-ready,
so that nWidart modules own their dependencies and the root app can resolve, boot, and report Laravel 13 deterministically.

## Acceptance Criteria

1. `laravel/composer.json` `require` contains only root-level concerns:
   - `php:^8.3`
   - `laravel/framework:^13.0`
   - `nwidart/laravel-modules:^13.0`
   - `filament/filament:^5.0`
   - `predis/predis` only if confirmed as root infrastructure
   - `sentry/sentry-laravel` only if confirmed as root infrastructure
2. `laravel/composer.json` `require-dev` is empty: `{}`. Every package currently in root `require-dev` is moved to module `require-dev`.
3. General development tooling is owned by `laravel/Modules/Xot/composer.json` unless a stricter module owner is documented:
   - `barryvdh/laravel-ide-helper`
   - `fakerphp/faker`
   - `larastan/larastan`
   - `laravel/boost`
   - `laravel/pint`
   - `laravel/sail`
   - `mockery/mockery`
   - `nunomaduro/collision`
   - `nunomaduro/phpinsights`
   - `orchestra/testbench`
   - `pestphp/pest`
   - `pestphp/pest-plugin-type-coverage`
   - `thecodingmachine/phpstan-safe-rule`
4. Runtime packages are owned by their modules, not root:
   - auth/OAuth/user packages: `Modules/User/composer.json`
   - notification/mail/HTTP channel packages: `Modules/Notify/composer.json`
   - Laraxot shared framework packages: `Modules/Xot/composer.json`
   - UI/icon/view packages: `Modules/UI/composer.json`
5. `extra.merge-plugin.include` keeps `Modules/*/composer.json`, `merge-dev: true`, and `wikimedia/composer-merge-plugin` enabled in `config.allow-plugins`.
6. Composer resolves Laravel 13. On 2026-05-05, local Composer metadata shows `laravel/framework v13.7.0` available, while the current lock and `php artisan --version` still show `Laravel Framework 12.58.0`.
7. Composer resolves the latest stable nWidart and Filament compatible with the target:
   - `nwidart/laravel-modules v13.0.0` is the latest stable visible on 2026-05-05 and requires PHP `^8.3`
   - `filament/filament v5.6.2` is installed locally and is the latest v5 stable visible to Composer on 2026-05-05
8. The reported Artisan namespace failure is diagnosed and no longer reproducible:
   - first user run failed with `RuntimeException: Unable to detect application namespace`
   - stack included `Spatie\EventSourcing\Support\DiscoverEventHandlers`
   - later runs returned `Laravel Framework 12.58.0`
   - completion requires `php artisan --version` to be deterministic after Composer update
9. After the migration, `php artisan --version` reports Laravel 13 and `php artisan package:discover --ansi` does not fail.
10. Second brain docs are updated and re-indexed with `qmd update`.

## Tasks

- [ ] Snapshot the current state from `laravel/`:
  - `composer validate`
  - `composer show laravel/framework --locked`
  - `composer show filament/filament --locked`
  - `composer show nwidart/laravel-modules --locked`
  - `php artisan --version`
- [ ] Edit `laravel/composer.json` so root `require` is minimal and root `require-dev` is `{}`.
- [ ] Move all current root `require-dev` entries to `Modules/Xot/composer.json` `require-dev`, unless a more specific module owner is documented.
- [ ] Audit `Modules/Xot/composer.json` for duplicate packages, wildcard constraints, and Laravel 13 conflicts.
- [ ] Confirm `Modules/User/composer.json` owns Passport, Socialite providers, agent, personal data export, permissions/auth dependencies.
- [ ] Confirm `Modules/Notify/composer.json` owns Symfony mailer/http-client, notification channels, Telegram, Firebase, mail template dependencies.
- [ ] Confirm `Modules/UI/composer.json` owns icon and Blade UI packages.
- [ ] Decide whether `predis/predis` and `sentry/sentry-laravel` stay root or move to module ownership; document the decision.
- [ ] Diagnose the namespace detection failure before final update:
  - confirm root `autoload.psr-4` contains `"App\\": "app/"`
  - run `composer dump-autoload`
  - run `php artisan package:discover --ansi`
  - inspect `spatie/laravel-event-sourcing` discovery and `Modules/Activity` if the namespace error appears again
- [ ] Run `composer update -W` from `laravel/`.
- [ ] Run validation/smoke commands:
  - `composer validate`
  - `composer validate Modules/Xot/composer.json`
  - `composer validate Modules/User/composer.json`
  - `composer validate Modules/Notify/composer.json`
  - `composer validate Modules/UI/composer.json`
  - `php artisan --version`
  - `php artisan package:discover --ansi`
  - `php artisan module:list`
  - `php artisan optimize:clear`
- [ ] Run PHPStan level 10 on changed modules, starting with Xot, User, Notify, UI, and Activity if event sourcing discovery was touched.
- [ ] Update module docs and wiki docs, then run `qmd update`.

## Dev Notes

The architectural rule is strict: root Composer is the application shell, not a dependency bucket. PTVX uses `nwidart/laravel-modules` with `wikimedia/composer-merge-plugin`; module-specific packages belong in `Modules/{Module}/composer.json`.

Current observed state:

- `laravel/composer.json` already asks for `laravel/framework:^13.0`, `nwidart/laravel-modules:^13.0`, and `filament/filament:^5.0`.
- Root `require-dev` is not empty and still contains general dev tools.
- `laravel/composer.lock` still resolves `laravel/framework v12.58.0`.
- `php artisan --version` currently returns `Laravel Framework 12.58.0` when it succeeds.
- The user's earlier failing run shows a boot-time namespace detection problem involving Spatie Event Sourcing discovery.

Do not solve this by adding global root autoload for modules. Laravel Modules v11+ does not require `"Modules\\": "Modules/"`, and this project maps module namespaces individually to `Modules/{Module}/app/`.

Root package policy:

- Keep root: Laravel, Laravel Modules, Filament, root autoload, Composer scripts/config, merge plugin.
- Move to Xot `require-dev`: generic developer tooling and test/static-analysis packages.
- Move to User `require`: auth, OAuth, Passport, permissions, user/session/device packages.
- Move to Notify `require`: notification, mail, SMS/Telegram/Firebase, Symfony mail/http integrations.
- Move to UI `require`: icon and Blade UI packages.

The intermittent Artisan transcript is a required guardrail:

```text
RuntimeException: Unable to detect application namespace.
... Spatie\EventSourcing\Support\DiscoverEventHandlers ...

php artisan --version
Laravel Framework 12.58.0
```

Laravel 13 migration is complete only when Artisan is stable and returns Laravel 13.

## Testing Requirements

- `cd laravel && composer validate`
- `cd laravel && composer update -W`
- `cd laravel && composer dump-autoload`
- `cd laravel && php artisan --version`
- `cd laravel && php artisan package:discover --ansi`
- `cd laravel && php artisan module:list`
- `cd laravel && php artisan optimize:clear`
- `cd laravel && ./vendor/bin/phpstan analyse Modules/Xot --level=10`
- `cd laravel && ./vendor/bin/phpstan analyse Modules/User --level=10`

## Documentation Requirements

Update or create:

- `laravel/Modules/Xot/docs/laravel-13-modular-composer-upgrade.md`
- `laravel/Modules/Xot/docs/composer-module-dependency-management.md`
- `laravel/Modules/User/docs/laravel-13-auth-composer-notes.md`
- `docs/wiki/concepts/laravel13-modular-composer-upgrade.md`

Then run:

```bash
qmd update
```

## References

- Planning context: `/_bmad-output/project-context.md`
- Architecture: `/_bmad-output/planning-artifacts/architecture.md`
- Existing upgrade story: `/_bmad-output/implementation-artifacts/5-1-laravel-13-modular-composer-upgrade.md`
- Xot Composer policy: `/laravel/Modules/Xot/docs/composer-module-dependency-management.md`
- User Composer policy: `/laravel/Modules/User/docs/composer-dependencies.md`
- Second brain note: `/docs/wiki/concepts/laravel13-modular-composer-upgrade.md`
- nWidart Laravel Modules: https://github.com/nWidart/laravel-modules
- Packagist `nwidart/laravel-modules`: https://packagist.org/packages/nwidart/laravel-modules
- Packagist `laravel/framework`: https://packagist.org/packages/laravel/framework
- Packagist `filament/filament`: https://packagist.org/packages/filament/filament
