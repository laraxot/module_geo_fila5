---
name: create-test
description: Create Pest PHP tests for module functionality. All tests must use Pest syntax, cover business logic, and follow the project testing conventions. Use when adding or modifying features.
---

# Create Test - Pest PHP Testing

Create comprehensive tests following PTVX testing conventions.

## When to Use

- After creating or modifying any code
- When adding new Actions, Models, or Filament Resources
- When fixing bugs (test the fix first)
- When the user asks to "add tests" or "test this"

## ABSOLUTE RULES

- **ALL tests must use Pest** (not PHPUnit class syntax)
- **Every change must have corresponding tests**
- **Cannot remove test files without explicit approval**
- Run minimum: `php artisan test --compact [file]`

## Test Location

```
Modules/{Module}/tests/
├── Feature/
│   ├── {Feature}BusinessLogicTest.php
│   └── Filament/
│       └── {Resource}Test.php
├── Unit/
│   ├── Actions/
│   │   └── {Action}Test.php
│   └── Models/
│       └── {Model}Test.php
├── TestCase.php
└── Pest.php
```

## Template: TestCase.php

```php
<?php

declare(strict_types=1);

namespace Modules\{Module}\Tests;

use Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }
}
```

## Template: Unit Test for Action

```php
<?php

declare(strict_types=1);

use Modules\{Module}\Actions\{ActionName}Action;

it('executes action successfully', function (): void {
    $action = app({ActionName}Action::class);
    $result = $action->execute($params);

    expect($result)->toBeInstanceOf(ExpectedClass::class);
});

it('throws exception for invalid input', function (): void {
    $action = app({ActionName}Action::class);

    expect(fn () => $action->execute(null))
        ->toThrow(\InvalidArgumentException::class);
});
```

## Template: Unit Test for Model

```php
<?php

declare(strict_types=1);

use Modules\{Module}\Models\{Model};

it('has correct fillable attributes', function (): void {
    $model = new {Model}();

    expect($model->getFillable())->toContain('name', 'email');
});

it('has correct casts', function (): void {
    $model = new {Model}();
    $casts = $model->getCasts();

    expect($casts)->toHaveKey('data', 'array');
});

it('has required relationships', function (): void {
    $model = new {Model}();

    expect($model->relationship())->toBeInstanceOf(BelongsTo::class);
});
```

## Template: Feature Test for Filament Resource

```php
<?php

declare(strict_types=1);

use Livewire\Livewire;
use Modules\{Module}\Filament\Resources\{Model}Resource\Pages\List{Models};

it('can render list page', function (): void {
    Livewire::test(List{Models}::class)
        ->assertSuccessful();
});

it('can list records', function (): void {
    $records = {Model}::factory()->count(3)->create();

    Livewire::test(List{Models}::class)
        ->assertCanSeeTableRecords($records);
});
```

## Running Tests

```bash
# Single test file
cd laravel && php artisan test Modules/{Module}/tests/Unit/Actions/{Action}Test.php --compact

# All module tests
cd laravel && php artisan test Modules/{Module}/tests/ --compact

# With coverage
cd laravel && php artisan test Modules/{Module}/tests/ --coverage
```

## After Creating Tests

1. Run all tests to verify they pass
2. Run PHPStan on test files
3. Run `vendor/bin/pint --dirty` for formatting
