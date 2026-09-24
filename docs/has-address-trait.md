---
title: HasAddress trait — PHPStan template e uso
type: concept
tags: [geo, trait, phpstan, has-address, address]
updated_at: '2026-09-24'
qmd: hasaddress trait template tmodel phpstan use builder-static
---

# Trait HasAddress

## Perché

Un solo punto per relazioni polimorfiche verso `Address` (Geo), riusabile sui modelli owner senza duplicare morphMany/scopes. Business: filtrare owner per città/provincia/regione/CAP tramite address collegato.

## Contratto PHPStan (obbligatorio)

1. **Un solo PHPDoc sul trait** — `@template` **prima**, poi `@property`, poi `@phpstan-require-extends` (FQCN). Ordine sbagliato → `generics.notGeneric` su `@use`.
2. **Consumer obbligatorio** — niente `@phpstan-ignore trait.unused` né probe: fixture `HasAddressTestModel` (o modello dominio) deve `use` il trait.
3. **`@template TModel of \Illuminate\Database\Eloquent\Model`** sul trait; scope tipizzati `Builder<TModel>` (stesso pattern di [`GeoTrait`](./traits/geo-trait.md)). Closure `whereHas`: `@param Builder<\Modules\Geo\Models\Address> $q`.
4. **Sul modello concreto**: `/** @use HasAddress<SelfClass> */`.
5. **`setAsPrimaryAddress`**: ritorno `void` + `InvalidArgumentException` se l'indirizzo non appartiene al modello (niente `bool`).
6. **Vietato** `@phpstan-ignore` di evasione, baseline, neon temp — solo `laravel/phpstan.neon` (immutabile per agenti).

```php
use Modules\Geo\Models\Traits\HasAddress;
use Modules\Geo\Models\BaseModel; // o BaseModel del modulo owner

/**
 * @property-read ...
 */
class Studio extends BaseModel
{
    /** @use HasAddress<Studio> */
    use HasAddress;
}
```

Anti-pattern: `extends Model` diretto; inventare modelli di altri moduli nei test Geo — i test riflettono API reali (`trait_exists` + fixture in `tests/Fixtures/`).  
Anti-pattern: secondo trait `HasAddresses` in `app/Traits` — **rimosso** (dead); vedi [traits/has-addresses.md](./traits/has-addresses.md).

## Dove si usa

- Modelli dominio che espongono indirizzi (Geo + consumer cross-module).
- Fixture: `Modules/Geo/tests/Fixtures/Traits/HasAddressTestModel.php`.
- Test Pest: `Modules/Geo/tests/Unit/Traits/HasAddressTest.php` (eseguire con `--no-coverage` se manca driver).

## Verifica

```bash
cd laravel
php -d memory_limit=2048M ./vendor/bin/phpstan analyse Modules/Geo/app/Models/Traits/HasAddress.php
./vendor/bin/pest Modules/Geo/tests/Unit/Traits/HasAddressTest.php --no-coverage
```

Report: `laravel/build/phpstan/`, `laravel/build/pest/` — mai `.claude-audit`.

## Collegamenti

- [traits/has-address-implementation.md](./traits/has-address-implementation.md)
- [traits/has-addresses.md](./traits/has-addresses.md)
- [traits/geo-trait.md](./traits/geo-trait.md)
- Memory: `docs/wiki/memories/trait-eloquent-scope-builder-static.md`
- Chat: `docs/chat/phpstan-modules-swarm-session.md`
- Lock: `bashscripts/docs/lock-system.md`
