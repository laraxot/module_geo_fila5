---
name: tdd-laravel
description: Test-Driven Development (TDD) per Laravel con Pest PHP. Ciclo Red-Green-Refactor, best practices, modular testing. Usare quando si implementa nuova funzionalità o si fixa un bug.
---

# TDD - Test-Driven Development con Laravel & Pest

## Ciclo Red-Green-Refactor

### 1. RED - Scrivi il test che fallisce
Prima di scrivere codice, scrivi un test che descrive il comportamento desiderato.
Il test DEVE fallire perché il codice non esiste ancora.

### 2. GREEN - Scrivi il codice minimo
Scrivi il minimo codice necessario per far passare il test.
Non ottimizzare ancora - Focus solo su far passare il test.

### 3. REFACTOR - Migliora il codice
Migliora il codice mantenendo tutti i test verdi.
Rimuovi duplicazioni, migliora naming, ottimizza.

---

## TDD in Laravel con Pest

### Struttura Test
```
tests/
├── Feature/        # Integrazione (HTTP, DB, full-stack)
├── Unit/           # Unit test (isolati)
└── Browser/        # E2E testing (Pest 4+)
```

### Esempio TDD: Creare un Action

```php
// 1. RED - Scrivi il test (fallisce)
it('sends welcome email after user registration', function () {
    $action = app(\Modules\User\Actions\RegisterUserAction::class);
    
    $user = $action->execute([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);
    
    expect($user)->toBeInstanceOf(User::class);
    Mail::assertSent(WelcomeEmail::class);
});

// 2. GREEN - Implementa il minimo
class RegisterUserAction
{
    public function execute(array $data): User
    {
        return User::create($data);
    }
}

// 3. REFACTOR - Aggiungi logica, eventi, validazione
class RegisterUserAction
{
    public function execute(array $data): User
    {
        $user = User::create($data);
        event(new UserRegistered($user));
        return $user;
    }
}
```

---

## Best Practices TDD

### Test Naming
```php
// ✅ Descrittivo - cosa fa il test
it('creates user with valid email')
it('requires authentication for dashboard access')
it('returns 404 for non-existent record')

// ❌ Generico
it('test1')
it('works')
```

### Arrange-Act-Assert
```php
it('calculates total correctly', function () {
    // Arrange
    $calculator = new OrderCalculator();
    $items = collect([
        ['price' => 100, 'qty' => 2],
        ['price' => 50, 'qty' => 1],
    ]);
    
    // Act
    $total = $calculator->calculate($items);
    
    // Assert
    expect($total)->toBe(250);
});
```

### Fake External Dependencies
```php
it('sends notification', function () {
    Notification::fake();
    
    $service = app(NotificationService::class);
    $service->notify($user, 'Hello');
    
    Notification::assertSent(UserNotification::class);
});
```

### One Assertion Per Test (quando possibile)
```php
// ✅ Un comportamento per test
it('validates email format', function () {
    expect(validateEmail('invalid'))->toBeFalse();
});

it('accepts valid email', function () {
    expect(validateEmail('test@example.com'))->toBeTrue();
});
```

---

## Comandi Testing

```bash
# Esegui tutti i test
./vendor/bin/pest

# Test con coverage
./vendor/bin/pest --coverage

# Test singolo modulo
./vendor/bin/pest Modules/Xot/tests

# Test parallelo (veloce)
./vendor/bin/pest --parallel

# Debug mode
./vendor/bin/pest --verbose --debug

# Stop al primo fallimento
./vendor/bin/pest --stop-on-failure

# Profile test (trova slowest)
./vendor/bin/pest --profile
```

---

## TDD per Bug Fix

1. **Scrivi test che riproduce il bug** (deve fallire)
2. **Fix il codice** finché il test non passa
3. **Refactor** se necessario

```php
it('handles null email gracefully', function () {
    $user = new User(['email' => null]);
    
    expect($user->email)->toBeNull();
});
```

---

## Risorse

- [Laravel Testing Docs](https://laravel.com/docs/testing)
- [Pest PHP](https://pestphp.com/)
- [Laracasts: Build a Laravel App with TDD](https://laracasts.com/series/build-a-laravel-app-with-tdd)
