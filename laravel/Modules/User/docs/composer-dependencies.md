# Composer Dependencies - Modulo User

## Regola Fondamentale

**Le dipendenze specifiche del modulo User (auth, login, OAuth, Socialite) vanno in `Modules/User/composer.json`, MAI nel root `laravel/composer.json`.**

Aggiornamento 2026-03-19:
- `laravel/passport` deve stare nel modulo `User` con versione esplicita `^13.0`
- il root deve contenere solo dipendenze davvero condivise o necessarie al bootstrap
- il merge dei `composer.json` modulari avviene tramite `wikimedia/composer-merge-plugin`

## Motivazione

- **Encapsulation**: Il modulo User è responsabile della propria logica di autenticazione
- **Modularità**: Il root composer.json gestisce solo dipendenze core (Laravel, Filament, nwidart)
- **wikimedia/composer-merge-plugin**: Merge automatico dei composer.json dei moduli

## Package che Appartengono al Modulo User

| Package | Motivo |
|---------|--------|
| `socialiteproviders/microsoft` | OAuth Microsoft per login |
| `socialiteproviders/auth0` | OAuth Auth0 per login |
| `laravel/passport` | API OAuth |
| `jenssegers/agent` | User agent per auth |
| `spatie/laravel-personal-data-export` | Export dati utente |

## Workflow Corretto

1. Modificare `Modules/User/composer.json` aggiungendo il package in `require`
2. Verificare che il package non sia gia' presente nel root senza motivo architetturale
3. Dalla root Laravel: `cd laravel && composer update -W` oppure il comando operativo concordato dal repository
4. Eseguire quality gate: `phpstan`, `phpmd` se disponibile, `phpinsights`, `pest`

## Anti-pattern

```bash
# ERRATO: installa nel root
cd laravel && composer require socialiteproviders/microsoft
```

```bash
# ERRATO: aggiungere Passport nel root del monorepo
cd laravel && composer require laravel/passport
```

## Distinzione Root vs Modulo

### Root `laravel/composer.json`
- `laravel/framework`
- `nwidart/laravel-modules`
- `wikimedia/composer-merge-plugin`
- librerie realmente cross-module o di bootstrap applicativo

### Modulo `User/composer.json`
- `laravel/passport`
- provider Socialite
- librerie specifiche di autenticazione/utenze

## Collegamenti

- [Composer Module Dependency Management](../../Xot/docs/composer-module-dependency-management.md)
- [Socialite Microsoft Integration](socialite-microsoft-integration.md)
