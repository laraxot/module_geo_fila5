# Laravel 13 modular Composer upgrade

## Decision

The Laravel 13 upgrade must be performed as a modular Composer migration, not as a root-only `composer require laravel/framework:^13`.

`laravel/composer.json` stays minimal:

- PHP `^8.3`
- `laravel/framework:^13.0`
- `nwidart/laravel-modules:^13.0`
- merge-plugin configuration for module composer files

Module-owned packages stay in `Modules/{Module}/composer.json`.

## Immediate blocker

The first Composer failure is caused by the legacy `barryvdh/laravel-debugbar:^3.14` constraint in the root composer. That package line does not support Laravel 13. Debugbar is now maintained as `fruitcake/laravel-debugbar`.

Resolution:

- remove debugbar from root;
- if still needed, add the current package `fruitcake/laravel-debugbar:^4.2` to `Modules/Xot/composer.json` under `require-dev`;
- rerun Composer from `laravel/` with `-W`.

## Module loading rule

Laravel Modules v13 uses module-owned composer files through `wikimedia/composer-merge-plugin`. Do not add global `"Modules\\": "Modules/"` autoload to root.

In this project, most module namespaces are `Modules\Name\...` while PHP files live under `Modules/Name/app/`. Keep module PSR-4 mappings aligned with that actual namespace layout.

## Documentation links

- Xot implementation rule: ../../../laravel/Modules/Xot/docs/laravel-13-modular-composer-upgrade.md
- User auth composer notes: ../../../laravel/Modules/User/docs/laravel-13-auth-composer-notes.md
- Theme Zero composer boundary: ../../../laravel/Themes/Zero/docs/laravel-13-composer-boundary.md
- Theme One composer boundary: ../../../laravel/Themes/One/docs/laravel-13-composer-boundary.md
- Theme Three composer boundary: ../../../laravel/Themes/Three/docs/laravel-13-composer-boundary.md
- Official Laravel Modules v13 requirements: https://laravelmodules.com/docs/13/getting-started/requirements
- Official Laravel Modules v13 installation: https://laravelmodules.com/docs/13/getting-started/installation-and-setup
