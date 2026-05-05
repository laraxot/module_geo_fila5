# Story 5.1: Laravel 13 Modular Composer Upgrade

Status: ready-for-dev

## User Story

As a Laraxot maintainer,
I want the project upgraded to Laravel 13 using module-owned Composer dependencies,
so that `laravel/composer.json` remains minimal and each module/theme keeps clear dependency ownership.

## Acceptance Criteria

1. `laravel/composer.json` is reduced to framework/platform concerns only: PHP `^8.3`, `laravel/framework:^13.0`, `nwidart/laravel-modules:^13.0`, Composer scripts/config, and merge-plugin settings.
2. `nwidart/laravel-modules` is explicitly constrained to `^13.0`, and `wikimedia/composer-merge-plugin` is enabled in `config.allow-plugins`.
3. Root Composer no longer contains module-specific or dev-tool packages such as legacy `barryvdh/laravel-debugbar`, Passport, permissions, or module-owned Filament extensions.
4. The debugbar blocker from the failed Composer run is resolved by removing root `barryvdh/laravel-debugbar:^3.14` and either installing the current package `fruitcake/laravel-debugbar:^4.2` in `Modules/Xot/composer.json` `require-dev` or documenting its removal.
5. Module composer files are audited for Laravel 13/PHP 8.3 constraints, with wildcard constraints replaced by explicit compatible ranges where migration risk exists.
6. `Modules/User/composer.json` owns auth dependencies, including `laravel/passport:^13.4` if Passport remains part of the runtime.
7. Theme composer files are documented and audited; they are merged only if they contain runtime PHP dependencies or PSR-4 autoload required by the app.
8. Composer resolves from `laravel/` with `composer update -W`, `composer validate` passes for root and changed module/theme composer files, and `php artisan module:list` works.
9. Documentation is updated in module docs, theme docs, and the second brain wiki; `qmd update` is run after the new docs are written.

## Tasks

- [ ] Confirm `laravel/composer.lock` status; regenerate only after constraints are aligned.
- [ ] Edit `laravel/composer.json` to minimal Laravel 13 root policy.
- [ ] Ensure `extra.merge-plugin.include` includes `Modules/*/composer.json`; add `Themes/*/composer.json` only after auditing theme composer files.
- [ ] Move/remove root packages that belong to modules.
- [ ] Update `Modules/Xot/composer.json` for framework/shared tooling ownership.
- [ ] Update `Modules/User/composer.json` for Passport/auth package ownership.
- [ ] Audit the remaining `Modules/*/composer.json` files for `php`, `laravel/framework`, `illuminate/*`, Filament, Livewire, and wildcard constraints.
- [ ] Audit `Themes/*/composer.json` and document whether each theme participates in Composer merge.
- [ ] Run Composer validation and dependency resolution from `laravel/`.
- [ ] Run Laravel Modules and Laraxot smoke checks.
- [ ] Run `qmd update` and verify the new docs are searchable.

## Dev Notes

Current blocker from the user run:

```text
Root composer.json requires barryvdh/laravel-debugbar ^3.14
barryvdh/laravel-debugbar 3.x requires illuminate/support up to ^12
laravel/framework ^13 replaces illuminate/support
```

Debugbar is now maintained as `fruitcake/laravel-debugbar`; do not add the old `barryvdh` package back during the Laravel 13 migration.

Do not try to solve this by forcing Laravel 13 alone. The correct fix is dependency ownership plus compatible constraints.

Laravel Modules v13 facts:

- official v13 docs require PHP 8.3+ and Laravel 13;
- Packagist lists `nwidart/laravel-modules:v13.0.0` requiring PHP `^8.3` and `wikimedia/composer-merge-plugin:^2.1`;
- from v11 onward, root `"Modules\\": "Modules/"` autoload is not required and should not be reintroduced.

Project-specific namespace guardrail:

- current module files live under `Modules/{Module}/app/`;
- namespaces are normally `Modules\{Module}\...`, not `Modules\{Module}\App\...`;
- keep PSR-4 mappings aligned with actual namespaces unless a deliberate namespace migration is included.

## Testing Requirements

- `composer validate` in `laravel/`.
- `composer validate` for every changed `Modules/*/composer.json` and `Themes/*/composer.json`.
- `composer update -W` from `laravel/`.
- `composer dump-autoload` from `laravel/`.
- `php artisan module:list`.
- `php artisan optimize:clear`.
- PHPStan level 10 on changed modules, starting with Xot and User.
- Relevant Pest suites for changed modules.

## Documentation Requirements

Update or keep current:

- [laravel-13-modular-composer-upgrade.md](../../laravel/Modules/Xot/docs/laravel-13-modular-composer-upgrade.md)
- [laravel-13-auth-composer-notes.md](../../laravel/Modules/User/docs/laravel-13-auth-composer-notes.md)
- [laravel-13-composer-boundary.md](../../laravel/Themes/Zero/docs/laravel-13-composer-boundary.md)
- [laravel-13-composer-boundary.md](../../laravel/Themes/One/docs/laravel-13-composer-boundary.md)
- [laravel-13-composer-boundary.md](../../laravel/Themes/Theme_One/docs/laravel-13-composer-boundary.md)
- [laravel13-modular-composer-upgrade.md](../../docs/wiki/concepts/laravel13-modular-composer-upgrade.md)

## References

- Planning context: [_bmad-output/project-context.md](../project-context.md)
- Architecture: [_bmad-output/planning-artifacts/architecture.md](../planning-artifacts/architecture.md)
- Xot Composer policy: [composer-module-dependency-management.md](../../laravel/Modules/Xot/docs/composer-module-dependency-management.md)
- User Composer policy: [composer-dependencies.md](../../laravel/Modules/User/docs/composer-dependencies.md)
- Laravel Modules v13 requirements: https://laravelmodules.com/docs/13/getting-started/requirements
- Laravel Modules v13 installation/autoloading: https://laravelmodules.com/docs/13/getting-started/installation-and-setup
- nWidart Laravel Modules GitHub: https://github.com/nWidart/laravel-modules
- Packagist `nwidart/laravel-modules`: https://packagist.org/packages/nwidart/laravel-modules
- Current Debugbar package: https://github.com/fruitcake/laravel-debugbar/

## Completion Note

Ultimate context engine analysis completed: the implementation now has the upgrade blocker, module ownership rules, Laravel Modules v13 constraints, theme composer boundary, documentation targets, and verification commands needed for a Laravel 13 migration.
