<<<<<<< HEAD
---
title: HasAddress trait — PHPStan template e uso
type: concept
tags: [geo, trait, phpstan, has-address, address]
updated_at: '2026-07-27'
qmd: hasaddress trait template tmodel phpstan use builder-static
---

# Trait HasAddress

## Perché

Un solo punto per relazioni polimorfiche verso `Address` (Geo), riusabile sui modelli owner senza duplicare morphMany/scopes. Business: filtrare owner per città/provincia/regione/CAP tramite address collegato.

## Contratto PHPStan (obbligatorio)

1. **Un solo PHPDoc sul trait** — `@property`, `@phpstan-require-extends`, `@template` e `@phpstan-ignore trait.unused` nello **stesso** blocco. Un docblock separato solo con `trait.unused` **cancella** le annotazioni e genera cascate `property.notFound` / `argument.type`.
2. **`@template TModel of Model`** resta sul trait; gli **scope locali** tipizzano `Builder<static>` / `Builder<static>` di ritorno — **non** `Builder<TModel>`. Nel contesto di analisi del modello concreto, `TModel` non si lega sempre e PHPStan segnala `missingType.generics`. `static` sì. Closure `whereHas`: `@param Builder<\Modules\Geo\Models\Address> $q`.
3. **Sul modello concreto**: `/** @use HasAddress<SelfClass> */`.
4. **Vietato** `@phpstan-ignore missingType.generics` sugli scope, baseline, neon temp — solo `laravel/phpstan.neon` (immutabile per agenti).

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
- Memory: `docs/wiki/memories/trait-eloquent-scope-builder-static.md`
- Rule: `docs/wiki/rules/phpstan-trait-phpdoc-merged-ignore.md`
- Chat: `docs/chat/phpstan-modules-swarm-session.md`
- Lock: `bashscripts/docs/lock-system.md`
=======
# Trait HasAddress

## Panoramica

Il trait `HasAddress` fornisce una soluzione standardizzata per la gestione degli indirizzi in tutti i modelli dell'applicazione <main module>. Questo trait implementa il pattern di relazione polimorfica con il modello `Address` del modulo Geo, permettendo a qualsiasi entità di avere uno o più indirizzi associati.


## Motivazione Filosofica

### Principio DRY (Don't Repeat Yourself)

Il codice per la gestione degli indirizzi era ripetuto in vari modelli, violando il principio DRY. Questa ripetizione creava:

- Duplicazione di logica
- Difficoltà di manutenzione
- Incoerenza nell'implementazione
- Maggiore rischio di errori


### Cohesion vs Coupling
Il trait rappresenta un equilibrio tra:

- **Alta coesione**: Raggruppando funzionalità correlate (gestione indirizzi)
- **Basso accoppiamento**: Minimizzando le dipendenze tra moduli


### Principio di Responsabilità Singola
Ogni modello dovrebbe avere una sola responsabilità. La gestione degli indirizzi è una responsabilità distinta che merita la propria astrazione.


## Implementazione Tecnica

Il trait `HasAddress` implementa:

1. **Relazioni polimorfiche**:
   - `addresses()`: Relazione morphMany per gestire più indirizzi
   - `primaryAddress()`: Metodo per ottenere l'indirizzo principale

2. **Metodi di utilità**:
   - `getFullAddress()`: Ottiene l'indirizzo completo formattato
   - `getCity()`: Estrae la città dall'indirizzo principale
   - `getPostalCode()`: Estrae il CAP dall'indirizzo principale
   - `getFormattedAddressAttribute()`: Formatta l'indirizzo in modo leggibile

3. **Gestione degli attributi**:
   - `getContactInfo()`: Raccoglie informazioni di contatto incluso l'indirizzo

## Utilizzo nel Modello Studio

Il modello Studio (e qualsiasi altro modello che necessita di indirizzi) può implementare il trait semplicemente con:

```php
use Modules\Geo\Models\Traits\HasAddress;

class Studio extends Model
{
    use HasAddress;
    
    // Resto del modello...
}
```

## Vantaggi Architetturali

1. **Standardizzazione**: Tutti i modelli utilizzano la stessa implementazione
2. **Manutenibilità**: Modifiche alla gestione degli indirizzi in un solo punto
3. **Estensibilità**: Facile aggiungere funzionalità relative agli indirizzi
4. **Coerenza**: Comportamento uniforme in tutta l'applicazione

## Riuso di AddressResource nei form di altri moduli

Quando un modello (es. Studio) necessita di gestire indirizzi tramite Filament, è best practice riutilizzare lo schema del form di AddressResource:

```php
'addresses' => Forms\Components\Repeater::make('addresses')
    ->relationship('addresses')
    ->schema(Modules\Geo\Filament\Resources\AddressResource::getFormSchema())
```

### Motivazione filosofica
- **DRY**: Un solo punto di verità per la UI degli indirizzi.
- **Coerenza**: Tutti i moduli presentano la stessa UX per la gestione degli indirizzi.
- **Manutenibilità**: Ogni modifica a AddressResource si propaga ovunque.
- **Zen**: Serenità e semplicità nella manutenzione.

### Best practice
- Non duplicare mai la logica dei form Address nei moduli consumer.
- Aggiornare sempre la documentazione e i collegamenti relativi.

## Riferimenti

- [Address](../app/Models/Address.php)
- [Address Model Italian](address-model-italian.md)
- [Morphs Relationship Patterns](morphs-relationship-patterns.md)
- [HasPlaceTrait](../app/Models/Traits/HasPlaceTrait.php)
- [models/address.md](./models/address.md)
- [address-implementation.md](./address-implementation.md)
- [filament.md](./filament.md)
>>>>>>> laraxot/dev
