---
name: laraxot-testing-pest
description: Regole testing Laraxot con Pest: TDD Red-Green-Refactor, creare test, eseguire con scope minimo, modular testing. Usare quando si modifica codice o si richiede testing.
---

# Laraxot Testing (Pest) - TDD & Best Practices

## Scopo
Garantire copertura e regressioni minime con Pest, seguendo TDD Red-Green-Refactor.

## TDD Cycle (Red-Green-Refactor)

### 1. Red - Scrivi il test che fallisce
```php
it('creates user with factory', function () {
    $user = User::factory()->create();
    
    expect($user)->toBeInstanceOf(User::class);
});
// Risultato: FALLISCE (rosso) - il codice non esiste ancora
```

### 2. Green - Scrivi il minimo codice per far passare il test
```php
// Crea il model con factory minima
class User extends Model {
    // ...
}
```

### 3. Refactor - Migliora il codice mantenendo i test verdi
```php
// Aggiungi relazioni, scope, cast, etc.
```

## Regole critiche
- Tutti i test in Pest
- Scrivere/aggiornare test per ogni modifica
- Eseguire solo lo scope minimo necessario
- **NON testare internals di Laravel** - testare il comportamento
- **Mantenere test deterministici** - fake chiamate esterne
- **Preferire feature tests** per flussi business-critical

## Modular Testing Structure
```
Modules/ModuleName/
├── tests/
│   ├── Pest.php              # Test configuration
│   ├── Unit/                 # Unit test (isolati)
│   ├── Feature/              # Feature test (integrazione)
│   └── Browser/              # Browser test (E2E)
```

## Comandi base
```bash
# Esegui tutti i test
php artisan test

# Test compatto
php artisan test --compact

# Test singolo modulo
./vendor/bin/pest Modules/Xot/tests

# Test con coverage
./vendor/bin/pest --coverage

# Test parallelo
./vendor/bin/pest --parallel

# Test specifico
php artisan test --filter=testName
```

## Test Naming (Descrittivo)
```php
// ✅ CORRETTO
it('creates user with valid email')
it('requires authentication for dashboard')

// ❌ SBAGLIATO
it('test1')
it('works')
```

## Fake External Dependencies
```php
// Mail fake
use Illuminate\Support\Facades\Mail;
Mail::fake();

// Event fake
use Illuminate\Support\Facades\Event;
Event::fake();

// Queue fake
use Illuminate\Support\Facades\Queue;
Queue::fake();

// File fake
use Illuminate\Support\Facades\Storage;
Storage::fake('avatars');
```

## Database Testing
```php
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('stores user in database', function () {
    $user = User::factory()->create(['name' => 'Jane']);
    
    expect($user)->toBePersisted();
    $this->assertDatabaseHas('users', ['name' => 'Jane']);
});
```

## Dataset (per multiple scenarios)
```php
it('validates email format', function ($email, $valid) {
    expect(validateEmail($email))->toBe($valid);
})->with([
    ['valid@example.com', true],
    ['invalid', false],
    ['another.valid@domain.co.uk', true],
]);
```
