# Spatie Permission teams on Laravel 13

## Decision

For Laravel 13 and `spatie/laravel-permission` 7.x, Laraxot must explicitly configure the team model:

```php
'team' => Modules\User\Models\Team::class,
```

This belongs in `config/permission.php` and every active local permission override.

## Why

Spatie Permission 7 reads `permission.models.team` through `PermissionRegistrar`. When teams are enabled and the class is missing, the package throws `TeamModelNotConfigured`.

In PTVX, the canonical team model is already `Modules\User\Models\Team`, matching `Modules\Xot\Datas\XotData::$team_class`.

## Runtime check

```bash
php artisan optimize:clear
php artisan tinker --execute="dump(config('permission.models.team')); dump(app(Spatie\\Permission\\PermissionRegistrar::class)->getTeamClass());"
```

Both values must be `Modules\User\Models\Team`.

## Documentation links

- User note: ../../../laravel/Modules/User/docs/spatie-permission-teams-laravel-13.md
- Xot note: ../../../laravel/Modules/Xot/docs/spatie-permission-team-model-laravel-13.md
- Theme Zero boundary: ../../../laravel/Themes/Zero/docs/spatie-permission-teams-boundary.md
- Theme One boundary: ../../../laravel/Themes/One/docs/spatie-permission-teams-boundary.md
- Spatie repository: https://github.com/spatie/laravel-permission
- Spatie teams docs: https://spatie.be/docs/laravel-permission/v7/basic-usage/teams-permissions
