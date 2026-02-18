---
name: create-action
description: Create a Spatie QueueableAction following Laraxot patterns. Use when creating business logic, background jobs, or any operation that should be reusable and queueable. NEVER create Service classes.
---

# Create Action - Spatie QueueableAction Pattern

Create business logic actions following the mandatory Actions-over-Services pattern.

## When to Use

- Implementing any business logic
- Creating background/queueable operations
- When tempted to create a "Service" class - create an Action instead
- Processing data, sending notifications, file operations

## ABSOLUTE RULE: NO Services

```php
// WRONG - Services are FORBIDDEN
class UserService
{
    public function createUser(array $data): User { ... }
}

// CORRECT - Use QueueableAction
class CreateUserAction
{
    use QueueableAction;

    public function execute(array $data): User { ... }
}
```

## Template: Standard Action

```php
<?php

declare(strict_types=1);

namespace Modules\{Module}\Actions;

use Spatie\QueueableAction\QueueableAction;

class {ActionName}Action
{
    use QueueableAction;

    /**
     * Execute the action.
     */
    public function execute(/* typed parameters */): mixed
    {
        // Business logic here
    }
}
```

## Template: Action with Dependencies

```php
<?php

declare(strict_types=1);

namespace Modules\{Module}\Actions;

use Spatie\QueueableAction\QueueableAction;
use Modules\{Module}\Models\{Model};

class Process{Model}Action
{
    use QueueableAction;

    public function __construct(
        private readonly SomeDependency $dependency,
    ) {}

    public function execute({Model} $model, array $data): {Model}
    {
        // Business logic with dependency injection
        return $model;
    }
}
```

## Naming Conventions

- File: `{Verb}{Noun}Action.php`
- Location: `Modules/{Module}/Actions/`
- Method: Always `execute()`, never custom method names
- Examples:
  - `CreateUserAction`
  - `SendNotificationAction`
  - `ProcessPaymentAction`
  - `ImportValutatoriAction`
  - `GetTenantModulesAction`

## Calling Actions

```php
// Synchronous
$result = app(CreateUserAction::class)->execute($data);

// Queued (background)
app(CreateUserAction::class)->onQueue('default')->execute($data);
```

## After Creating

1. Create corresponding test in `tests/Unit/Actions/`
2. Run PHPStan: `cd laravel && ./vendor/bin/phpstan analyse Modules/{Module}/Actions --memory-limit=-1`
3. Run Pint: `cd laravel && vendor/bin/pint --dirty`
