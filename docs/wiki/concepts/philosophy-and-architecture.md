# Project Philosophy & Architecture

## 🐄 Super Mucca Principles

### Core Philosophy: DRY + KISS

**Don't Repeat Yourself + Keep It Simple, Stupid**

1. **No Duplication**: Every piece of knowledge must have a single, unambiguous representation
2. **Maximum Simplicity**: The simplest solution that works is the best solution
3. **Business Logic Focus**: Always understand WHY before implementing HOW
4. **Type Safety**: Strict typing at PHPStan Level 10
5. **Testability**: Everything must be testable

## 🏗️ Architectural Principles

### The XotBase Rule

**NEVER extend Filament classes directly. ALWAYS use XotBase classes.**

#### Why XotBase?

- **Centralized Logic**: Common functionality in one place
- **Consistency**: All resources behave the same way
- **Maintainability**: Changes propagate automatically
- **DRY**: No repeated code across resources

#### XotBase Class Hierarchy

```
Filament Classes (❌ Don't extend directly)
    ↓
XotBase Classes (✅ Always extend these)
    ↓
Your Module Classes (✅ Extend XotBase)
```

#### Mapping Table

| ❌ WRONG | ✅ CORRECT |
|---------|----------|
| `Filament\Resources\Resource` | `Modules\Xot\Filament\Resources\XotBaseResource` |
| `Filament\Resources\Pages\CreateRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord` |
| `Filament\Resources\Pages\EditRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord` |
| `Filament\Resources\Pages\ListRecords` | `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords` |
| `Filament\Pages\Page` | `Modules\Xot\Filament\Pages\XotBasePage` |
| `Illuminate\Support\ServiceProvider` | `Modules\Xot\Providers\XotBaseServiceProvider` |

### Actions Over Services

**Use Spatie Queueable Actions instead of traditional Services**

#### Why Actions?

- **Single Responsibility**: Each action does ONE thing
- **Queueable**: Easy to make async
- **Testable**: Isolated, focused testing
- **Composable**: Chain actions together
- **DRY**: Reusable across contexts

#### Pattern Example

```php
<?php

declare(strict_types=1);

namespace Modules\User\Actions;

use Spatie\QueueableAction\QueueableAction;
use Modules\User\Data\UserData;
use Modules\User\Models\User;

class CreateUserAction
{
    use QueueableAction;

    public function execute(UserData $data): User
    {
        return User::create($data->toArray());
    }
}

// Usage
$user = app(CreateUserAction::class)->execute($userData);

// Or queued
CreateUserAction::dispatch($userData);
```

### DTOs for Data Transfer

**Use Spatie Laravel Data for type-safe data transfer**

#### Why DTOs?

- **Type Safety**: Validated data structures
- **Auto-casting**: Automatic type conversion
- **Documentation**: Self-documenting code
- **Validation**: Built-in validation rules

#### Pattern Example

```php
<?php

declare(strict_types=1);

namespace Modules\User\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Email;

class UserData extends Data
{
    public function __construct(
        #[Required]
        public readonly string $name,

        #[Required, Email]
        public readonly string $email,

        public readonly ?int $id = null,
    ) {}
}
```

## 🚫 Critical Don'ts

### 1. Never Use property_exists() with Eloquent

**WHY:** Eloquent models use magic properties via `__get()` and `__set()`. Database fields are NOT real PHP properties.

```php
// ❌ WRONG - Always returns false
if (property_exists($user, 'email')) {
    // This NEVER executes for database fields
}

// ✅ CORRECT
if ($user->hasAttribute('email')) {
    // This works
}

// ✅ CORRECT
if ($user->isFillable('email')) {
    // For fillable check
}

// ✅ CORRECT
if (Schema::hasColumn($user->getTable(), 'email')) {
    // For database structure check
}
```

### 2. No Hardcoded Labels

**WHY:** Translations must be managed centrally, not scattered across code.

```php
// ❌ WRONG
TextInput::make('name')
    ->label('Nome')
    ->placeholder('Inserisci nome');

// ✅ CORRECT - Use translation files
TextInput::make('name')
    // Labels auto-resolved from lang/it/resource.php
```

**Translation Structure:**

```php
// Modules/User/lang/it/user.php
return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci nome',
            'tooltip' => 'Il nome completo',
        ],
    ],
];
```

### 3. No Method Duplication

**WHY:** If the parent class has a method, don't override it with identical logic.

```php
// ❌ WRONG - Duplicates parent logic
class MyModel extends BaseModel
{
    public function getName(): string
    {
        return $this->name; // Identical to BaseModel
    }
}

// ✅ CORRECT - Use parent method
class MyModel extends BaseModel
{
    // Inherits getName() from BaseModel
}
```

### 4. Deprecated: protected $casts

**WHY:** Laravel 11+ deprecates property-based casts in favor of method-based.

```php
// ❌ DEPRECATED - Laravel 10 style
class User extends Model
{
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}

// ✅ CORRECT - Laravel 11+ style
class User extends Model
{
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }
}
```

### 5. Deprecated: BadgeColumn

**WHY:** Da Filament v3/v4 in poi il badge è su `TextColumn` (stack attuale: **Filament v5**).

```php
// ❌ DEPRECATED
use Filament\Tables\Columns\BadgeColumn;

BadgeColumn::make('status');

// ✅ CORRECT
use Filament\Tables\Columns\TextColumn;

TextColumn::make('status')->badge();
```

### 6. Avoid "mixed" Type

**WHY:** Loose typing defeats PHPStan Level 10 and creates runtime errors.

```php
// ❌ AVOID - Last resort only
public function process(mixed $data): mixed
{
    // Unclear what $data is
}

// ✅ CORRECT - Specific types
public function process(UserData $data): User
{
    // Clear contract
}
```

## 📋 Method Signature Rules

### Return Types Always Return Arrays with Numeric Keys

All Filament schema methods return arrays with **numeric keys only** (indexed arrays), not associative arrays.

```php
// ✅ CORRECT - Numeric keys
public function getTableColumns(): array
{
    return [
        TextColumn::make('name'),
        TextColumn::make('email'),
    ];
}

// ❌ WRONG - Associative keys
public function getTableColumns(): array
{
    return [
        'name' => TextColumn::make('name'),
        'email' => TextColumn::make('email'),
    ];
}
```

**Methods with this rule:**

- `getFormSchema()`
- `getTableColumns()`
- `getTableActions()`
- `getTableBulkActions()`
- `getTableFilters()`
- `getHeaderActions()`
- `getInfolistSchema()`

## 🎯 Quality Standards

### PHPStan Level 10

**Mandatory for all code.**

```bash
./vendor/bin/phpstan analyse Modules/YourModule --level=10
```

**What Level 10 Checks:**

- Strict types everywhere
- No missing return types
- No undefined variables
- No invalid array access
- Complete PHPDoc
- Type-safe operations

### PSR-12 Code Style

**Automatic formatting with Laravel Pint:**

```bash
./vendor/bin/pint
```

### Testing with Pest

**Every feature needs tests:**

```bash
./vendor/bin/pest Modules/YourModule
```

## 📂 Module Structure

### Standard Structure

```
Modules/
└── YourModule/
    ├── app/
    │   ├── Actions/          # Spatie Queueable Actions
    │   ├── Data/            # Spatie Laravel Data DTOs
    │   ├── Filament/
    │   │   ├── Resources/   # Extend XotBaseResource
    │   │   ├── Pages/       # Extend XotBasePage
    │   │   └── Widgets/     # Stats, charts, etc.
    │   ├── Models/          # Eloquent models
    │   ├── Policies/        # Authorization
    │   └── Repositories/    # Data access layer
    ├── database/
    │   ├── factories/
    │   ├── migrations/
    │   └── seeders/
    ├── docs/                # ✅ kebab-case, no dates
    │   ├── README.md        # ✅ Uppercase allowed
    │   ├── architecture.md
    │   └── business-logic.md
    ├── lang/
    │   ├── en/
    │   └── it/
    ├── routes/
    ├── tests/
    │   ├── Feature/
    │   └── Unit/
    └── composer.json
```

## 🔧 Bash Scripts Organization

### Directory Structure

```
bashscripts/
├── quality/              # PHPStan, PHPMD, PHPInsights
├── docs/                # Documentation management
├── git/
│   └── conflict_resolution/
├── composer/
├── testing/
└── deployment/
```

### Script Rules

1. **Naming**: kebab-case (`analyze-module-quality.sh`)
2. **Dry-run**: Always provide `--dry-run` option
3. **Idempotent**: Safe to run multiple times
4. **Output**: Clear summary of actions
5. **Documentation**: Usage in header comments

## 🌐 Translation System

### Auto-Resolution

The system automatically resolves translations based on:

1. Field name
2. Resource name
3. Module name
4. Fallback to English

### Structure

```
Modules/User/lang/it/user.php

return [
    'resource' => [
        'label' => 'Utente',
        'plural' => 'Utenti',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci nome',
            'tooltip' => 'Nome completo utente',
        ],
    ],
    'actions' => [
        'approve' => [
            'label' => 'Approva',
            'modal' => [
                'heading' => 'Conferma approvazione',
            ],
        ],
    ],
];
```

## 📚 Further Reading

### Internal Documentation

- `laravel/CLAUDE.md` - Complete guidelines (9979 lines)
- `docs/module-structure-analysis.md` - Module statistics
- `Modules/Xot/docs/` - Core framework documentation

### External Resources

- [Filament v4 Docs](https://filamentphp.com/docs/4.x)
- [Spatie Queueable Actions](https://github.com/spatie/laravel-queueable-action)
- [Spatie Laravel Data](https://github.com/spatie/laravel-data)
- [PHPStan Level 10](https://phpstan.org/user-guide/rule-levels)

---

**Remember: Always ask WHY before HOW. Understand the business logic first, then implement with DRY + KISS.**

🐄 **Super Mucca Powers: Maximum Confidence, Maximum Quality!**
