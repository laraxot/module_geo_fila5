---
name: laraxot-testing-pest
description: Regole testing Laraxot con Pest: creare test, eseguire con scope minimo, usare php artisan test --compact. Usare quando si modifica codice o si richiede testing.
---

# Laraxot Testing (Pest)

## Scopo
Garantire copertura e regressioni minime con Pest.

## Regole critiche
- Tutti i test in Pest
- Scrivere/aggiornare test per ogni modifica
- Eseguire solo lo scope minimo necessario

## Comandi base
```bash
php artisan test --compact tests/Feature/FooTest.php
php artisan test --compact --filter=testName
```

## Pattern base
```php
it('does something', function () {
    expect(true)->toBeTrue();
});
```
