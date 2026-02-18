---
name: laraxot-model-rules
description: Regole modelli Laraxot: estendere BaseModel del modulo, docblock properties, fillable/hidden tipizzati e casts() method. Usare quando si modificano modelli.
---

# Laraxot Model Rules

## Scopo
Mantenere modelli coerenti con PHPStan level 10 e regole di modulo.

## Regole critiche
- Estendere il `BaseModel` del modulo, mai `Model` diretto
- Proprietà `$fillable/$hidden/$dates/$with` con `/** @var list<string> */`
- Vietato `protected $casts`; usare `protected function casts(): array`
- `property_exists()` non valido per attributi Eloquent
- PHPDoc completo per proprietà e relazioni

## Pattern casts()
```php
/**
 * @return array<string, string>
 */
protected function casts(): array
{
    return [
        'created_at' => 'datetime',
        'is_active' => 'boolean',
    ];
}
```
