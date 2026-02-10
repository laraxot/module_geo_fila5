# AGENTS.md - Development Guide for AI Agents

## Project Overview

**PTVX** is a modular HR & Performance evaluation system built on:
- **Laravel 12.47.0** (latest)
- **Filament v5.0.0** (already migrated)
- **Laraxot** modular architecture
<<<<<<< HEAD
- **PHP 8.2+**
=======
- **PHP 8.3+**
>>>>>>> ac0ea089 (.)

## Current Status

### Filament Migration Status
<<<<<<< HEAD
- ✅ **Filament v5.0.0 already installed** - migration complete
- No immediate migration required
=======
- Filament v5.0.0 already installed - migration complete
>>>>>>> ac0ea089 (.)
- Composer shows `"filament/filament": "^5.0"` in main composer.json
- Xot module also updated to `"filament/filament": "^5.0"`

### Laravel Version
- **Laravel 12.47.0** (latest stable)
<<<<<<< HEAD
- PHP 8.2+ required
=======
- PHP 8.3+ required
>>>>>>> ac0ea089 (.)
- Modern PHP features available

## Module Structure (Laraxot Pattern)

<<<<<<< HEAD
### Core Modules (32 total)
=======
### Core Modules (34 total)
>>>>>>> ac0ea089 (.)
```bash
Activity  Badge  CertFisc  ContoAnnuale  DbForge  Europa  Gdpr
Inail  Incentivi  IndennitaCondizioniLavoro  IndennitaResponsabilita
Job  Lang  Legge104  Legge109  Media  Mensa  MobilitaVolontaria  Notify
Pdnd  Performance  Prenotazioni  PresenzeAssenze  Progressioni  Ptv
Questionari  Rating  Setting  Sigma  Sindacati  Tenant  UI  User  Xot
```

<<<<<<< HEAD
=======
### Themes (2)
```bash
Zero  One
```

>>>>>>> ac0ea089 (.)
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

<<<<<<< HEAD
=======
---

## Agent Teams Configuration

### Claude Code (Opus 4.6 - Agent Teams)

**Enable**: Set `CLAUDE_CODE_EXPERIMENTAL_AGENT_TEAMS=1` in `.claude/settings.local.json` env section.

**Team Templates**:

#### Quality Team (3 teammates)
```
Lead: Coordinates quality checks across module
Teammate 1 (PHPStan): ./vendor/bin/phpstan analyse Modules/{Module} --level=10
Teammate 2 (Tests): ./vendor/bin/pest Modules/{Module}/tests
Teammate 3 (Pint): ./vendor/bin/pint Modules/{Module}
```

#### Module Development Team (3 teammates)
```
Lead: Implements features following XotBase patterns
Teammate 1 (Tests): Writes Pest tests for new functionality
Teammate 2 (Docs): Updates module docs/ after changes
```

#### Review Team (3 teammates)
```
Lead: Security review (OWASP, SQL injection, XSS)
Teammate 1 (Performance): Query optimization, N+1, caching
Teammate 2 (Tests): Coverage analysis, edge cases
```

#### Docs Team (3 teammates)
```
Lead: Module documentation updates
Teammate 1 (Theme): Theme docs and component docs
Teammate 2 (Translations): Translation file verification
```

### Cursor (Background Agents + Worktrees)

Cursor supports parallel agents via git worktrees. Configuration in `.cursor/worktrees.json`.

**Setup**:
- Enable "Background Agents" in Cursor settings
- Configure worktrees for parallel operations
- Each agent works in its own worktree branch

### Windsurf (Parallel Cascade Sessions)

Windsurf Cascade supports multiple parallel sessions. Configuration in `.windsurf/settings.json`.

**Setup**:
- Open multiple Cascade sessions
- Each session can work on a different module
- MCP servers shared across sessions

### iFlow (SubAgent System)

iFlow supports SubAgents for task delegation. Configuration in `.iflow/settings.json`.

**Setup**:
- Define SubAgent profiles for specialized tasks
- Use `_iflow_skills` for task-specific activation
- SubAgents share MCP server connections

### OpenCode (Agent System)

OpenCode supports custom agents via `.opencode/agents/` directory. Configuration in `.opencode/config.json`.

**Setup**:
- Define agent files in `.opencode/agents/`
- Each agent has a specialized system prompt
- Agents can be invoked by name

### Gemini CLI (Multi-Agent)

Gemini CLI supports per-directory AGENTS.md files for context. Configuration in `.gemini/settings.json`.

**Setup**:
- Create `AGENTS.md` in module directories for context
- Use `settings.json` for MCP server configuration
- Gemini reads nearest AGENTS.md for context

---

>>>>>>> ac0ea089 (.)
## Development Commands

### Composer Scripts
```bash
<<<<<<< HEAD
# Full project setup/update
composer go                    # Complete setup with permissions, update, optimize

# Individual operations
composer update -W             # Update with wildcard
composer optimize              # Optimize autoloader
chmod 777 -R .                # Fix permissions (development only)
=======
composer go                    # Complete setup with permissions, update, optimize
composer update -W             # Update with wildcard
composer optimize              # Optimize autoloader
>>>>>>> ac0ea089 (.)
```

### PHPStan (Level 10 - Strict)
```bash
<<<<<<< HEAD
# Analyze all modules
./check_all_modules.sh

# Analyze specific module
./vendor/bin/phpstan analyse Modules/Xot --level=10

# Analyze with memory limit
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/ModuleName

# Base configuration
./vendor/bin/phpstan analyse    # Uses phpstan.neon (Level 10)
=======
./check_all_modules.sh                                          # Analyze all modules
./vendor/bin/phpstan analyse Modules/Xot --level=10             # Specific module
php -d memory_limit=2G ./vendor/bin/phpstan analyse             # With memory limit
>>>>>>> ac0ea089 (.)
```

### Testing (Pest PHP)
```bash
<<<<<<< HEAD
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
=======
./vendor/bin/pest                                               # Run all tests
./vendor/bin/pest Modules/User/tests                            # Module tests
./vendor/bin/pest --coverage                                    # With coverage
./vendor/bin/pest --filter="test_user_can_login"                # Single test
>>>>>>> ac0ea089 (.)
```

### Code Quality Tools
```bash
<<<<<<< HEAD
# Laravel Pint (Code formatting)
./vendor/bin/pint

# Rector (Automated refactoring)
./vendor/bin/rector process Modules/Xot

# Rector with dry run
./vendor/bin/rector process Modules/Xot --dry-run
=======
./vendor/bin/pint                                               # Code formatting
./vendor/bin/rector process Modules/Xot                         # Refactoring
./vendor/bin/rector process Modules/Xot --dry-run               # Dry run
>>>>>>> ac0ea089 (.)
```

### Build & Asset Commands
```bash
<<<<<<< HEAD
# Frontend assets
npm run dev
npm run build

# Laravel optimize
php artisan optimize
php artisan filament:optimize
php artisan filament:upgrade
=======
npm run dev                                                     # Frontend dev
npm run build                                                   # Frontend build
php artisan optimize                                            # Laravel optimize
php artisan filament:optimize                                   # Filament optimize
php artisan filament:upgrade                                    # Filament upgrade
>>>>>>> ac0ea089 (.)
```

## Code Style Guidelines

### PHPStan Level 10 Requirements
- **"Fix, Don't Ignore"** philosophy - all errors must be resolved
- Type declarations required
- No mixed types allowed without explicit handling
- Strict type checking enabled
- Memory limit often needed: `php -d memory_limit=2G`

<<<<<<< HEAD
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

=======
>>>>>>> ac0ea089 (.)
### Module Development Rules
1. **Never extend Filament classes directly** - use XotBase* wrappers
2. **No hardcoded translations** - use translation files
3. **Prefer Actions over Services** (Spatie Queueable Action)
4. **Follow module-per-module workflow**
5. **Maintain PSR-4 autoloading**

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
<<<<<<< HEAD

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
=======
>>>>>>> ac0ea089 (.)
```

### Test Files Location
- `Modules/ModuleName/tests/Feature/` - Feature tests
- `Modules/ModuleName/tests/Unit/` - Unit tests
- `tests/Pest.php` - Root test configuration

<<<<<<< HEAD
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
=======
## AI/Agent Configuration

### MCP Setup
Configuration file: `laravel/.mcp.json`
- **Laravel Boost MCP Server** - Artisan commands
- **Filesystem MCP** - File access
- **Memory MCP** - Context management
- **Fetch MCP** - Web requests
- **MySQL MCP** - Database access
- **Git MCP** - Version control

### Specialized AI Agents

### 1. Laravel Architect
**Model**: Claude Sonnet 4.5
**Specializzazione**: Architettura Laravel e moduli Laraxot
**Responsabilità**:
- Sviluppo modelli Eloquent con BaseModel
- Creazione Actions (Spatie Queueable Action)
- API routes e controller
- Migrazioni database
- PHPStan Level 10 compliance

**Pattern obbligatori**:
```php
// Estendi sempre BaseModel
class UserModel extends BaseModel
{
    // Usa casts() method, non $casts property
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_active' => 'boolean',
        ];
>>>>>>> ac0ea089 (.)
    }
}
```

<<<<<<< HEAD
### Key Features
- **Recursive merging** of module dependencies
- **Dev dependencies merged** automatically
- **Scripts not merged** to avoid conflicts
- **Duplicates ignored** to prevent version conflicts
=======
### 2. Filament Specialist
**Model**: Claude Sonnet 4.5
**Specializzazione**: Filament v5 con pattern XotBase
**Responsabilità**:
- Resources estendendo XotBaseResource
- Form e table components
- Relation managers
- Widgets e pages

**Regole critiche**:
```php
// MAI estendere Filament direttamente
class UserResource extends XotBaseResource  // ✅
// class UserResource extends Resource     // ❌

// MAI hardcoded strings
TextInput::make('name')->label(__('user::resource.fields.name'))  // ✅
TextInput::make('name')->label('Name')                           // ❌

// MAI override table()
protected static function getTableColumns(): array  // ✅
public static function table(Table $table): Table   // ❌
```

### 3. PHPStan Expert
**Model**: Claude Sonnet 4.5
**Specializzazione**: Analisi statica e risoluzione errori
**Responsabilità**:
- Analisi PHPStan Level 10
- Fix errori di tipizzazione
- Strict typing implementation
- Memory optimization

**Comandi Utili**:
```bash
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/ModuleName --level=10
```

### 4. Test Engineer
**Model**: Claude Sonnet 4.5
**Specializzazione**: Testing con Pest PHP
**Responsabilità**:
- Test unitari e feature
- Test coverage analysis
- Dati di test realistici
- TDD practices

### 5. Documentation Writer
**Model**: Claude Haiku
**Specializzazione**: Documentazione tecnica
**Responsabilità**:
- README.md dei moduli
- Documentazione docs/
- Standard Laraxot compliance
- Traduzioni italiano/inglese

### 6. Performance Optimizer
**Model**: Claude Sonnet 4.5
**Specializzazione**: Ottimizzazione performance
**Responsabilità**:
- Query optimization
- N+1 problems resolution
- Caching Redis
- Asset optimization

## Development Workflows

### Module Development Workflow
1. **Laravel Architect**: Crea struttura base modulo
2. **Filament Specialist**: Implementa admin resources
3. **Test Engineer**: Scrivi test completi
4. **PHPStan Expert**: Verifica compliance Level 10
5. **Documentation Writer**: Documenta il modulo

### Bug Fix Workflow
1. **Laravel Architect**: Analizza e fix bug
2. **Test Engineer**: Verifica fix con test
3. **PHPStan Expert**: Verifica non regressioni

### Quality Audit Workflow
1. **PHPStan Expert**: Analisi statica completa
2. **Performance Optimizer**: Audit performance
3. **Test Engineer**: Verifica coverage
4. **Documentation Writer**: Aggiorna documentazione

## Agent Guidelines
1. **Never modify `.env` files** - use config instead
2. **Respect module boundaries** - don't create cross-dependencies
3. **Use XotBase wrappers** for all Filament extensions
4. **All PHPStan errors must be fixed** - no ignored errors
5. **Write tests for new functionality**
6. **Follow existing naming conventions**
7. **MAI hardcoded strings in Filament** - usa translation keys
8. **SEMPRE estendere BaseModel** per modelli Eloquent
9. **SEMPRE usare casts() method** non $casts property
10. **SEMPRE risolvere PHPStan Level 10** prima di commit
>>>>>>> ac0ea089 (.)

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

<<<<<<< HEAD
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

=======
>>>>>>> ac0ea089 (.)
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
<<<<<<< HEAD
│       ├── composer.json
│       ├── phpstan.neon.dist
│       └── rector.php
=======
│       ├── docs/
│       ├── composer.json
│       ├── phpstan.neon.dist
│       └── rector.php
├── Themes/
│   ├── Zero/
│   └── One/
>>>>>>> ac0ea089 (.)
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

<<<<<<< HEAD
This comprehensive guide provides AI agents with all necessary information to work effectively with the PTVX codebase, maintaining high code quality standards and following established patterns.
=======
## Troubleshooting

### Common Issues
1. **Memory errors**: Use `php -d memory_limit=2G` prefix
2. **Permission issues**: Run `chmod 777 -R .` (development only)
3. **Autoloader issues**: Run `composer dump-autoload`
4. **Cache issues**: Clear all caches before testing

This guide provides AI agents with all necessary information to work effectively with the PTVX codebase, maintaining high code quality standards and following established patterns.
>>>>>>> ac0ea089 (.)
