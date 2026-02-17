# AGENTS.md - Development Guide for AI Agents

## Project Overview

**PTVX** is a modular HR & Performance evaluation system built on:
- **Laravel 12.47.0** (latest)
- **Filament v5.0.0** (already migrated)
- **Laraxot** modular architecture
- **PHP 8.2+**

## Current Status

### Filament Migration Status
- ✅ **Filament v5.0.0 already installed** - migration complete
- No immediate migration required
- Composer shows `"filament/filament": "^5.0"` in main composer.json
- Xot module also updated to `"filament/filament": "^5.0"`

### Laravel Version
- **Laravel 12.47.0** (latest stable)
- PHP 8.2+ required
- Modern PHP features available

## Module Structure (Laraxot Pattern)

### Core Modules (32 total)
```bash
Activity  Badge  CertFisc  ContoAnnuale  DbForge  Europa  Gdpr
Inail  Incentivi  IndennitaCondizioniLavoro  IndennitaResponsabilita
Job  Lang  Legge104  Legge109  Media  Mensa  MobilitaVolontaria  Notify
Pdnd  Performance  Prenotazioni  PresenzeAssenze  Progressioni  Ptv
Questionari  Rating  Setting  Sigma  Sindacati  Tenant  UI  User  Xot
```

### Module Architecture
- **Xot**: Core module with base classes and utilities
- **Tenant**: Multi-tenancy support
- **User**: User management and authentication
- **UI**: UI components and themes
- **Domain-specific**: Business logic modules (Ptv, Performance, etc.)

### Key Module Files
- `composer.json`: Module dependencies
- `phpstan.neon.dist`: PHPStan configuration
- `rector.php`: Rector refactoring rules
- `tests/Pest.php`: Test configuration
- `app/`: Module code
- `database/`: Migrations and seeders
- `resources/`: Views and assets

## Development Commands

### Composer Scripts
```bash
# Full project setup/update
composer go                    # Complete setup with permissions, update, optimize

# Individual operations
composer update -W             # Update with wildcard
composer optimize              # Optimize autoloader
chmod 777 -R .                # Fix permissions (development only)
```

### PHPStan (Level 10 - Strict)
```bash
# Analyze all modules
./check_all_modules.sh

# Analyze specific module
./vendor/bin/phpstan analyse Modules/Xot --level=10

# Analyze with memory limit
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/ModuleName

# Base configuration
./vendor/bin/phpstan analyse    # Uses phpstan.neon (Level 10)
```

### Testing (Pest PHP)
```bash
# Run all tests
./vendor/bin/pest

# Run tests for specific module
./vendor/bin/pest Modules/User/tests

# Run with coverage
./vendor/bin/pest --coverage

# Run specific test file
./vendor/bin/pest Modules/User/tests/Feature/UserTest.php

# Run single test
./vendor/bin/pest --filter="test_user_can_login"
```

### Code Quality Tools
```bash
# Laravel Pint (Code formatting)
./vendor/bin/pint

# Rector (Automated refactoring)
./vendor/bin/rector process Modules/Xot

# Rector with dry run
./vendor/bin/rector process Modules/Xot --dry-run
```

### Build & Asset Commands
```bash
# Frontend assets
npm run dev
npm run build

# Laravel optimize
php artisan optimize
php artisan filament:optimize
php artisan filament:upgrade
```

## Code Style Guidelines

### PHPStan Level 10 Requirements
- **"Fix, Don't Ignore"** philosophy - all errors must be resolved
- Type declarations required
- No mixed types allowed without explicit handling
- Strict type checking enabled
- Memory limit often needed: `php -d memory_limit=2G`

### Key PHPStan Configuration
```neon
parameters:
    level: 10
    paths:
        - Modules
    excludePaths:
        - ./*/vendor/*
        - ./*/Tests/*
        - ./*/tests/*
        - ./*/docs/*
    ignoreErrors:
        - '#Static call to instance method Nwidart\\Modules\\Facades\\Module#'
        - '#Unsafe usage of new static#'
        - '#PHPDoc tag @mixin contains unknown class #'
```

### PHP Code Style
- **ALWAYS use short array syntax `[]`** - NEVER use `array()` in .php files
- `array()` is only acceptable in documentation examples showing incorrect usage
- This is enforced by PSR-12, Pint, and PHP-CS-Fixer

### Module Development Rules
1. **Never extend Filament classes directly** - use XotBase* wrappers
2. **No hardcoded translations** - use translation files
3. **Prefer Actions over Services** (Spatie Queueable Action)
4. **Follow module-per-module workflow**
5. **Maintain PSR-4 autoloading**
6. **ALWAYS use short array syntax `[]`** - never `array()`

### Filament v5 Best Practices
- Use `XotBaseResource` instead of `Filament\Resources\Resource`
- Implement `getFormSchema()` method in resources
- Avoid static properties like `$navigationIcon` in resource classes
- Use translation keys, not hardcoded strings
- Follow wrapper pattern for all Filament components

## Testing Patterns (Pest PHP)

### Test Structure
```php
// Modules/ModuleName/tests/Pest.php
uses(Modules\ModuleName\Tests\TestCase::class)->in('Feature', 'Unit');

// Custom expectations
expect()->extend('toBeCustomModel', function () {
    return $this->toBeInstanceOf(CustomModel::class);
});

// Helper functions
function createCustomModel(array $attributes = []): CustomModel
{
    $model = CustomModel::factory()->create($attributes);
    assert($model instanceof CustomModel);
    return $model;
}
```

### Test Files Location
- `Modules/ModuleName/tests/Feature/` - Feature tests
- `Modules/ModuleName/tests/Unit/` - Unit tests
- `tests/Pest.php` - Root test configuration

## Composer Merge Plugin Configuration

### Module Dependency Merging
```json
"extra": {
    "merge-plugin": {
        "include": [
            "Modules/*/composer.json"
        ],
        "recurse": true,
        "replace": false,
        "ignore-duplicates": true,
        "merge-dev": true,
        "merge-extra": false,
        "merge-replace": true,
        "merge-scripts": false
    }
}
```

### Key Features
- **Recursive merging** of module dependencies
- **Dev dependencies merged** automatically
- **Scripts not merged** to avoid conflicts
- **Duplicates ignored** to prevent version conflicts

## Development Workflow

### Module Development Sequence
1. **Complete one module before moving to the next**
2. **Run PHPStan Level 10** - must pass completely
3. **Write Pest tests** - ensure functionality works
4. **Run Rector** for code quality
5. **Test manually** in browser
6. **Commit** with clear messages

### Quality Assurance Pipeline
```bash
# 1. Static analysis
php -d memory_limit=2G ./vendor/bin/phpstan analyse

# 2. Code formatting
./vendor/bin/pint

# 3. Automated refactoring
./vendor/bin/rector process --dry-run

# 4. Testing
./vendor/bin/pest --coverage

# 5. Optimization
php artisan optimize
```

## AI/Agent Configuration

### MCP Setup
Configuration file: `laravel/.mcp.json`
- **Laravel Boost MCP Server** - Artisan commands
- **Filesystem MCP** - File access
- **Memory MCP** - Context management
- **Fetch MCP** - Web requests
- **MySQL MCP** - Database access
- **Git MCP** - Version control

### Agent Guidelines
1. **Never modify `.env` files** - use config instead
2. **Respect module boundaries** - don't create cross-dependencies
3. **Use XotBase wrappers** for all Filament extensions
4. **All PHPStan errors must be fixed** - no ignored errors
5. **Write tests for new functionality**
6. **Follow existing naming conventions**
7. **ALWAYS use short array syntax `[]`** - never `array()` in PHP files
8. **Actions use `execute()` method** - call via `app(ActionClass::class)->execute()`
9. **NEVER use constructor DI** - use `app()` container resolution instead
10. **New packages in module `composer.json`** - never in `laravel/composer.json`
11. **Run `composer go`** from `laravel/` after adding module dependencies
12. **NEVER run `git remote set-url`** - only project owner does this
13. **Git forward only** - never restore old versions, study logs but don't revert
14. **Every error fix** must have: git commit + GitHub issue + GitHub discussion

## Essential Commands for Agents

### Single Module Operations
```bash
# PHPStan analysis
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Xot --error-format=table

# Run tests
./vendor/bin/pest Modules/Xot/tests

# Format code
./vendor/bin/pint Modules/Xot

# Refactor
./vendor/bin/rector process Modules/Xot --dry-run
```

### Batch Operations
```bash
# All modules PHPStan
./check_all_modules.sh

# All tests
./vendor/bin/pest

# Format all
./vendor/bin/pint

# Optimize everything
php artisan optimize:clear
composer optimize
php artisan filament:optimize
```

### Migration & Setup Commands
```bash
# Complete setup (development)
composer go

# Post-update maintenance
php artisan vendor:publish --tag=laravel-assets --ansi --force
php artisan filament:upgrade
php artisan filament:optimize

# Clear caches
php artisan route:clear
php artisan config:clear
php artisan view:clear
php artisan cache:clear
```

## Troubleshooting

### Common Issues
1. **Memory errors**: Use `php -d memory_limit=2G` prefix
2. **Permission issues**: Run `chmod 777 -R .` (development only)
3. **Autoloader issues**: Run `composer dump-autoload`
4. **Cache issues**: Clear all caches before testing

### Module-Specific Issues
- Check module `composer.json` for conflicts
- Verify `phpstan.neon.dist` configuration
- Ensure tests inherit from proper TestCase
- Check module providers are registered

## File Structure Reference

```
laravel/
├── Modules/
│   ├── Xot/                    # Core module
│   │   ├── app/
│   │   ├── composer.json
│   │   ├── phpstan.neon
│   │   ├── rector.php
│   │   └── tests/
│   └── [ModuleName]/
│       ├── app/
│       ├── database/
│       ├── resources/
│       ├── tests/
│       ├── composer.json
│       ├── phpstan.neon.dist
│       └── rector.php
├── vendor/bin/
│   ├── phpstan
│   ├── pest
│   ├── pint
│   └── rector
├── phpstan.neon               # Root PHPStan config (Level 10)
├── rector.php                 # Root Rector config
├── tests/Pest.php            # Root test config
└── artisan                   # Laravel CLI
```

This comprehensive guide provides AI agents with all necessary information to work effectively with the PTVX codebase, maintaining high code quality standards and following established patterns.
