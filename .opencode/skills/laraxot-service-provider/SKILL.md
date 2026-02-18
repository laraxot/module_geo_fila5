---
name: laraxot-service-provider
description: Regole ServiceProvider Laraxot: estendere XotBaseServiceProvider, public string $name, no duplicazioni, asset chart solo nel modulo Chart. Usare quando si toccano provider di modulo.
---

# Laraxot ServiceProvider

## Scopo
Garantire provider coerenti con Xot e senza duplicazioni.

## Regole critiche
- Estendere `Modules\\Xot\\Providers\\XotBaseServiceProvider`
- Dichiarare `public string $name = '<ModuleName>';` subito dopo la classe
- Metodi `boot()` e `register()` devono chiamare `parent::*()`
- Non duplicare load di views/translations/migrations
- Asset Chart.js solo nel modulo Chart

## Pattern minimo
```php
class FooServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Foo';

    protected string $module_name = 'Foo';
}
```
