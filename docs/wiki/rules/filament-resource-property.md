---
title: "Filament $resource Property — protected not public static"
type: "rule"
tags: [filament, xotbase, resource, property, pages]
created: 2026-05-12
updated: 2026-05-12
confidence: high
sources:
  - laravel/Modules/Xot/app/Filament/Resources/Pages/XotBaseResourcePage.php
  - laravel/Modules/Xot/app/Filament/Resources/Pages/XotBaseListRecords.php
---

# Filament `$resource` — `protected` non `public static`

## Regola

In tutte le Pages Filament (`ListRecords`, `CreateRecord`, `EditRecord`, `ViewRecord`) la proprietà `$resource` è **`protected static string`**, non `public static string`.

## Fonte dal codice reale

```php
// Modules/Xot/app/Filament/Resources/Pages/XotBaseResourcePage.php
abstract class XotBaseResourcePage extends FilamentResourcePage
{
    protected static string $resource;  // ← protected, NON public
}
```

## Pattern corretto

```php
// ✅ CORRETTO
class ListStoredEvents extends XotBaseListRecords
{
    protected static string $resource = StoredEventResource::class;
}

// ❌ SBAGLIATO
class ListStoredEvents extends XotBaseListRecords
{
    public static string $resource = StoredEventResource::class;
}
```

## Nota su XotBaseListRecords

`XotBaseListRecords` ha un metodo `getResource()` che **auto-risolve** il resource dalla classe corrente via namespace:

```php
public static function getResource(): string
{
    $resource = Str::of(static::class)->before('\\Pages\\')->toString();
    Assert::classExists($resource);
    return $resource;
}
```

Quindi se il namespace è `Modules\Activity\Filament\Resources\StoredEventResource\Pages\ListStoredEvents`, il resource viene risolto **automaticamente** come `Modules\Activity\Filament\Resources\StoredEventResource`. La proprietà `$resource` è necessaria solo quando si vuole fare override esplicito.

## Mapping completo visibilità proprietà Pages

| Proprietà | Visibilità | Note |
|-----------|-----------|------|
| `$resource` | `protected static string` | auto-resolved da XotBaseListRecords |
| `$model` | `protected static ?string` | opzionale, auto-resolved da XotBaseResource |
| `$navigationIcon` | `protected static ?string` | opzionale |
| `$view` | `protected static string` | per XotBaseResourcePage |

## Vedi anche

- [xotbase-critical-rules](./xotbase-critical-rules.md)
- [filament-rules-summary](./filament-rules-summary.md)
- Sorgente: `Modules/Xot/app/Filament/Resources/Pages/XotBaseResourcePage.php:18`
