# FixCity Platform - AGENTS.md

This file contains comprehensive guidelines and commands for AI agents working on the FixCity Laravel application.

## 🏗️ PROJECT OVERVIEW

**Architecture**: Modular Laravel application using `nwidart/laravel-modules`  
**Framework**: Laravel 12.x with Filament 4.x (migrating to 5.x)  
**PHP Version**: 8.2+ (strict typing required)  
**Module Structure**: 20+ modules in `/laravel/Modules/` directory  

## 🚀 BUILD/LINT/TEST COMMANDS

### Frontend Quality Commands
```bash
# Run all quality checks
npm run quality

# Individual quality tools
npm run quality:biome      # Biome linter/formatter
npm run quality:eslint     # ESLint for JS/TS
npm run quality:htmlhint   # HTML validation
npm run quality:markdownlint  # Markdown validation

# Auto-fix issues
npm run fix
npm run fix:biome          # Biome auto-format
npm run fix:eslint         # ESLint auto-fix
```

### Backend Quality Commands
```bash
# PHPStan static analysis (LEVEL 10 - MAXIMUM)
./vendor/bin/phpstan analyse --level=10 --memory-limit=2G

# Run PHPStan on specific module
./vendor/bin/phpstan analyse laravel/Modules/User/ --level=10

# Code formatting (Laravel Pint)
composer pint

# Run tests (Pest)
php artisan test

# Run single test
php artisan test --filter=TestMethodName
php artisan test tests/Feature/UserTest.php

# Module-specific tests
php artisan test --filter=Modules\\User\\Tests\\
```

### Laravel Custom Commands
```bash
# Go script (update + migrate + optimize)
npm run go

# Individual steps
composer update -W
php artisan migrate
php artisan filament:upgrade
php artisan optimize
```

### Filament 5 Migration Commands
```bash
# Install upgrade script
composer require filament/upgrade:"^5.0" -W --dev

# Run automated upgrade
vendor/bin/filament-v5

# Follow script output for specific commands
composer require filament/filament:"^5.0" -W --no-update
composer update

# Remove upgrade script after completion
composer remove filament/upgrade --dev
```

## 📋 CODE STYLE GUIDELINES

### PHP Standards

#### File Headers
```php
<?php

declare(strict_types=1);

namespace Modules\Example\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ExampleModel.
 *
 * @package Modules\Example\Models
 */
class ExampleModel extends BaseModel
{
    // Implementation
}
```

#### Strict Requirements
- **MUST** have `declare(strict_types=1);` in every PHP file
- **MUST** define return types for all methods
- **MUST** use type hints for parameters
- **MUST** follow PSR-12 coding standards
- **MUST** use short array syntax `[]` instead of `array()`

#### Class Structure
```php
class ExampleClass extends XotBaseClass
{
    /**
     * @return array<string, mixed>
     */
    public function getExampleData(): array
    {
        return [
            'key' => 'value',
        ];
    }

    public function processData(string $input): ?string
    {
        return null;
    }
}
```

### Import/Export Patterns

#### Import Order
1. Laravel framework imports
2. Third-party packages
3. Module imports (sorted alphabetically)
4. Aliases for conflict resolution

```php
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Modules\User\Models\User;
use Modules\Xot\Filament\Resources\XotBaseResource;
use function Safe\glob;
use Webmozart\Assert\Assert;
```

#### Namespace Conventions
- **Models**: `Modules\*\Models` (NOT `Modules\*\app\Models`)
- **Filament**: `Modules\*\Filament\Resources`
- **Controllers**: `Modules\*\Http\Controllers`
- **Services**: `Modules\*\Services`

### Naming Conventions

#### Classes
- **PascalCase**: `TicketResource`, `XotBaseMigration`
- **Suffixes**: Resource, Migration, Action, Trait, Contract
- **Base Classes**: Prefix with `XotBase`

#### Methods
- **camelCase**: `getFormSchema()`, `updateTimestamps()`
- **Verb-first**: `createTicket()`, `updateUser()`
- **Boolean**: `hasPermission()`, `isAdmin()`

#### Variables
- **camelCase**: `$ticketData`, `$userId`
- **Descriptive**: `$userPermissions`, `$ticketStatus`
- **Type-indicating**: `$userArray`, `$isActiveBool`

#### Database Fields
- **snake_case**: `created_at`, `updated_by`
- **Foreign Keys**: `user_id`, `team_id`
- **Timestamps**: Standard Laravel conventions

## 🏛️ ARCHITECTURAL PATTERNS

### Module Structure
```
Modules/ModuleName/
├── app/
│   ├── Http/Controllers/
│   ├── Models/
│   └── Providers/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── assets/
│   └── views/
├── routes/
├── tests/
├── composer.json
└── module.json
```

### Base Class Extensions

#### Filament Resources
- **ALWAYS** extend `XotBaseResource` from `Modules\Xot\Filament\Resources`
- **NEVER** extend Filament base classes directly
- **USE** `getFormSchema()` instead of `form()`
- **DO NOT** define `table()` method in Resource classes

#### List Pages
- **ALWAYS** extend `XotBaseListRecords`
- **USE** specific methods:
  - `getTableColumns(): array`
  - `getTableFilters(): array`
  - `getTableActions(): array`
  - `getTableBulkActions(): array`

#### Migrations
- **ALWAYS** extend `XotBaseMigration`
- **NEVER** override `down()` method (it's final)
- **USE** `tableCreate()` and `tableUpdate()` methods
- **USE** `updateTimestamps()` for standard fields

### Error Handling

#### Validation Patterns
```php
use Exception;
use Webmozart\Assert\Assert;

public function execute(array $data): array
{
    try {
        Assert::isArray($data);
        Assert::notEmpty($data, 'Data cannot be empty');
        
        return $this->processData($data);
    } catch (Exception $e) {
        logger()->error('Processing failed', [
            'error' => $e->getMessage(),
            'data' => $data
        ]);
        
        return [];
    }
}
```

#### Null-Safe Operations
```php
$user = auth()->user();
$profile = $user?->profile;
$name = $profile?->name ?? 'Guest';
```

## 🧪 TESTING GUIDELINES

### Testing Framework: Pest PHP

#### Test Structure
```php
<?php

use Tests\TestCase;
use Modules\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class)->in('Feature');

/** @test */
public function it_can_create_user(): void
{
    $user = User::factory()->create();
    
    $this->assertInstanceOf(User::class, $user);
    $this->assertDatabaseHas('users', [
        'id' => $user->id
    ]);
}
```

#### Test Requirements
- **MUST** use Pest PHP testing framework
- **MUST** have `RefreshDatabase` trait for feature tests
- **MUST** target 90%+ code coverage
- **SHOULD** use factories for data creation
- **MUST** pass PHPStan level 10 analysis

### Running Tests
```bash
# All tests
php artisan test

# Specific test file
php artisan test tests/Feature/UserTest.php

# Filter by test method
php artisan test --filter=it_can_create_user

# Coverage report
php artisan test --coverage
```

## 🔧 FILAMENT 5 MIGRATION

### Migration Steps
1. **Study Documentation**: Review all docs/ folders
2. **Backup Current State**: Create branch `filament-4-backup`
3. **Run Upgrade Script**: Use `filament/upgrade` package
4. **Update Dependencies**: Follow script-generated commands
5. **Test Thoroughly**: Run all tests and quality checks
6. **Update Documentation**: Record breaking changes

### Key Changes in Filament 5
- **PHP 8.2+ Required**
- **Livewire v4.0+ Required**
- **Tailwind CSS v4.0+ Required**
- **New Panel Configuration System**
- **Enhanced Type Safety**
- **Improved Performance**

### Critical Areas to Check
- Resource classes and their methods
- Form schema definitions
- Table configurations
- Action definitions
- Panel provider configurations
- Asset compilation

## 📦 COMPOSER MODULE MANAGEMENT

### Merge Plugin Configuration
This project uses `wikimedia/composer-merge-plugin` for modular dependency management.

#### Module composer.json Pattern
```json
{
    "name": "fixcity/module-name",
    "type": "laravel-module",
    "require": {
        "php": "^8.2",
        "laravel/framework": "^12.0"
    },
    "autoload": {
        "psr-4": {
            "Modules\\ModuleName\\": "laravel/Modules/ModuleName/app/"
        }
    },
    "extra": {
        "laravel": {
            "providers": [
                "Modules\\ModuleName\\Providers\\ModuleNameServiceProvider"
            ]
        }
    }
}
```

### Module Creation Commands
```bash
# Create new module
php artisan module:make ModuleName

# Create module with specific components
php artisan module:make Blog --api --web --seed

# Publish module assets
php artisan module:publish ModuleName
```

## 🎯 QUALITY STANDARDS

### PHPStan Configuration
- **Level**: 10 (Maximum)
- **Memory Limit**: 2GB
- **Strict Rules**: Enabled
- **Safe Operations**: Required

### Code Coverage Targets
- **Overall**: 90%+
- **Critical Modules**: 95%+
- **Models**: 100%
- **Controllers**: 90%+

### Performance Metrics
- **Response Time**: <200ms (p95)
- **Memory Usage**: <128MB per request
- **Database Queries**: Minimal N+1 problems
- **Lighthouse Score**: >95

## 📚 IMPORTANT NOTES

### Before Making Changes
1. **Check docs/** folder for existing documentation
2. **Run PHPStan level 10** to understand current state
3. **Read .windsurfrules** for Laraxot framework rules
4. **Review existing patterns** in similar modules

### After Making Changes
1. **Run quality checks**: `npm run quality`
2. **Run PHPStan**: `./vendor/bin/phpstan analyse --level=10`
3. **Run tests**: `php artisan test`
4. **Update documentation** if needed
5. **Commit with descriptive messages**

### Critical Rules from .windsurfrules
- **NEVER** extend Laravel/Filament base classes directly
- **ALWAYS** use XotBase classes
- **USE** `getFormSchema()` instead of `form()`
- **DO NOT** use `->label()` method (handled by translations)
- **FOLLOW** namespace conventions strictly

## 🚨 BREAKING CHANGES FOR FILAMENT 5

### Deprecated Methods
- `form()` → `getFormSchema()`
- `table()` → Remove from Resource classes
- `label()` → Remove (handled by translations)

### New Requirements
- PHP 8.2+ strict typing mandatory
- Livewire v4.0+ migration required
- Tailwind CSS v4.0+ asset compilation
- Enhanced type safety throughout

### Migration Checklist
- [ ] Backup current codebase
- [ ] Review all Filament resources
- [ ] Update form schema methods
- [ ] Remove table() methods from resources
- [ ] Test all admin panels
- [ ] Verify asset compilation
- [ ] Update documentation

---

**Last Updated**: 2026-01-20  
**Filament Version**: 4.x → 5.x Migration Target  
**PHPStan Level**: 10 (Maximum)  
**Test Coverage**: 90%+ Target