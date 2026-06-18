---
title: "PHPStan Filament tableFilters nullable"
type: pattern
tags: [phpstan, filament, tablefilters, nullable, actions]
created: 2026-06-18
updated: 2026-06-18
qmd: "phpstan filament tableFilters nullable array null action argument.type"
issues:
  - "https://github.com/provtv/base_ptv_fila5_mono/issues/136"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:
  - "../../../laravel/Modules/IndennitaCondizioniLavoro/docs/wiki/concepts/filament-tablefilters-nullable.md"
  - "../patterns/phpstan-optional-contracts.md"
---

# PHPStan Filament tableFilters nullable

> Filament table filters can be exposed as `array|null`; actions fed directly by table header callbacks must either normalize before the call or explicitly accept `?array` and validate internally.

## Rule

For a table header action that passes `$this->tableFilters` to an action class:

- do not suppress `argument.type`;
- do not edit `phpstan.neon`;
- prefer a contract that matches runtime input: `array<string, mixed>|null`;
- throw a domain exception when filters are missing or malformed;
- add a null-input test when the action accepts `?array`.

## Canonical Pattern

```php
/**
 * @param array<string, mixed>|null $data
 */
public function execute(?array $data): void
{
    $input = $data['anno/valutatore'] ?? $data;

    if (! is_array($input)) {
        throw new InvalidArgumentException('Parametro filtri non valido.');
    }
}
```

## Why

`argument.type` is a real contract mismatch: the caller can pass `array|null`, while the callee only promised `array`. PHPStan documents this identifier as an argument whose type does not match the called function or method parameter.

## Verification

Run the owning module after the change:

```bash
cd laravel
./vendor/bin/phpstan analyse Modules/<Module>
./vendor/bin/pest Modules/<Module>/tests
```

## Related

- [IndennitaCondizioniLavoro local note](../../../laravel/Modules/IndennitaCondizioniLavoro/docs/wiki/concepts/filament-tablefilters-nullable.md)
- [PHPStan optional contracts](../patterns/phpstan-optional-contracts.md)
- [PHPStan `argument.type`](https://phpstan.org/error-identifiers/argument.type)
