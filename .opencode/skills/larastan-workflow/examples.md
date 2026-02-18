---
name: larastan-workflow-examples
description: Esempi d’uso della skill Larastan per analisi mirate e correzione errori.
---

# Esempi

## Analisi mirata su un file
```
./vendor/bin/phpstan analyse Modules/Foo/app/Models/Bar.php --level=10 --no-progress
```

## Analisi modulo con memoria aumentata
```
./vendor/bin/phpstan analyse Modules/Foo --level=10 --memory-limit=2G --no-progress
```

## Fix tipizzazione array
```php
/**
 * @return array<string, string>
 */
protected function casts(): array
{
    return [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
    ];
}
```
