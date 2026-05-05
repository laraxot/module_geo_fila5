# Spatie Permission Team Model Not Configured

## Context

Su route admin (`/admin`) il menu utente Filament invoca il cambio team (`Modules\User\Http\Livewire\Team\Change`), che passa da `HasRoles` di Spatie Permission.
Con `teams` abilitato in config, Spatie richiede esplicitamente `permission.models.team`.

## Error

`Spatie\Permission\Exceptions\TeamModelNotConfigured` con messaggio:
`No team model configured. Set models.team in your permission config file.`

## Root Cause

La causa primaria e' sempre incoerenza tra teams abilitati e team model non disponibile nel registrar Spatie.

Nel caso storico del 2026-04-28 mancava la chiave:

- `models.team => Modules\User\Models\Team::class`

Questo causava eccezione runtime quando Spatie tentava di risolvere il model team durante check ruoli/permessi con scope team.

Nel caso Laravel 13.7.0 del 2026-05-05 i file sorgente `config/permission.php` e profili `config/local/ptvx*/permission.php` contengono gia' `models.team`.
Quindi il rischio operativo diventa:

- config cache vecchia;
- bootstrap/package discovery dopo upgrade Composer;
- `PermissionRegistrar` risolto prima che il modulo User riaffermi i modelli Laraxot;
- cache Spatie permessi non riallineata dopo upgrade.

## Fix Applied

Aggiunta la voce `models.team` in tutti i profili config attivi, per evitare drift tra ambienti:

- `../../../../../config/permission.php`
- `../../../../../config/localhost/permission.php`
- `../../../../../config/local/ptvx/permission.php`
- `../../../../../config/local/ptvx-mono/permission.php`
- `../../../../../config/local/tv/prov/personale2022/permission.php`
- `../../../../../config/test/ptvx/permission.php`

Valore impostato:

```php
'team' => Modules\User\Models\Team::class,
```

Hardening aggiunto in `Modules\User\Providers\UserServiceProvider`:

- imposta `permission.models.permission` a `Modules\User\Models\Permission::class`;
- imposta `permission.models.role` a `Modules\User\Models\Role::class`;
- imposta `permission.models.team` a `Modules\User\Models\Team::class`;
- imposta `permission.teams` a `true`;
- aggiorna `Spatie\Permission\PermissionRegistrar` anche se e' gia' stato risolto.

## Verification

1. cache config pulita con `php artisan optimize:clear`;
2. cache Spatie pulita con `php artisan permission:cache-reset`;
3. verifica runtime con:
   `php artisan tinker --execute="dump(config('permission.models.team')); dump(app(Spatie\\Permission\\PermissionRegistrar::class)->getTeamClass());"`;
4. output atteso per entrambi:
   `Modules\User\Models\Team`.

## Best Practices

- quando `teams` e' `true`, trattare `models.team` come requisito obbligatorio;
- mantenere allineati tutti i file `config/*/permission.php` per evitare bug solo su specifici ambienti;
- dopo fix config, eseguire sempre clear cache prima del recheck route.
- dopo cambio team, invalidare le relazioni Eloquent `roles` e `permissions` sul model utente prima di rileggere autorizzazioni team-aware.

## Related

- `../index.md`
- `../../spatie-permission-teams-laravel-13.md`
- `../../../../../docs/wiki/concepts/laravel-permission.md`
