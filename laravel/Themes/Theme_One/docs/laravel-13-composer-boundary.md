# Laravel 13 Composer boundary for Theme_One

## Rule

Theme_One documentation follows the same Composer boundary as the active themes: themes own presentation, modules own application behavior and backend package dependencies.

## Laravel 13 migration impact

- Keep Laravel framework and module-system constraints in `laravel/composer.json`.
- Keep module-specific packages in `Modules/{Module}/composer.json`.
- Keep debugbar in `Modules/Xot/composer.json` as `fruitcake/laravel-debugbar:^4.2.8`; Theme_One must not declare `barryvdh/laravel-debugbar` or `fruitcake/laravel-debugbar`.
- Add theme composer files to the merge-plugin include list only when a theme has runtime PHP dependencies or PSR-4 autoload that must be resolved by Composer.

## Verification

After Composer resolves Laravel 13:

1. Check that theme views still reference module-provided widgets/classes.
2. Check that theme docs mention any theme-specific PHP package ownership.
3. Run the project theme build/smoke process for active themes.

## References

- Xot Composer strategy: [../../Modules/Xot/docs/laravel-13-modular-composer-upgrade.md](../../Modules/Xot/docs/laravel-13-modular-composer-upgrade.md)
