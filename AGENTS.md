# AGENTS.md - Development Guide for AI Agents

**Stack**: Laravel 12 | Filament v5 | Pest v4 | PHPStan Level 10 | PHP 8.3+

## Regola Fondamentale

**Leggi → Ragiona → Studia → Aggiorna Docs → Migliora**

Prima di modificare qualsiasi file:
1. **Leggi** il file attentamente
2. **Ragiona** sul contesto e le implicazioni
3. **Studia** il codice esistente e le convenzioni
4. **Aggiorna** i docs nelle cartelle dei moduli e dei temi
5. **Migliora** il codice seguendo le convenzioni del progetto

## Quick Commands

### Testing (run single test)
```bash
# Single test by name
./vendor/bin/pest --filter="test_name"

# Single test file
./vendor/bin/pest tests/Feature/UserTest.php

# Module tests
./vendor/bin/pest Modules/Xot/tests

# All tests with coverage
./vendor/bin/pest --coverage
```

### Code Quality
```bash
# PHPStan (Level 10 - all errors must be fixed)
php -d memory_limit=2G ./vendor/bin/phpstan analyse

# PHPStan specific module
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Xot --error-format=table

# Laravel Pint (PSR-12 formatting)
./vendor/bin/pint --dirty

# Rector refactoring
./vendor/bin/rector process Modules/Xot --dry-run
```

### Build & Assets
```bash
npm run dev          # Development
npm run build        # Production
composer go          # Full setup
php artisan optimize
```

## Code Style Guidelines

### PHP Requirements
- `declare(strict_types=1);` in every file
- Explicit return types on all methods
- Explicit parameter types
- Curly braces for all control structures (even single line)

### Array Syntax
- **ALWAYS use short array syntax `[]`** - NEVER `array()`
```php
// WRONG
array('key' => 'value');

// CORRECT
['key' => 'value'];
```

### Naming Conventions
- Classes: `PascalCase` (e.g., `UserService`)
- Methods: `camelCase` (e.g., `getUserById`)
- Variables: `camelCase` (e.g., `$userName`)
- Enum keys: `TitleCase` (e.g., `FavoritePerson`)
- **Test Files: `PascalCase` matching class name** (e.g., `GenerateDbDocumentationCommandTest.pest.php`)
- **NON devono esistere file duplicati** con nomi che differiscono solo per case (case-sensitive su filesystem Linux)
  - Duplicati lowercase: rinominare aggiungendo `.old` — `git mv foo.php foo.php.old`
- **Docs `.md`: NIENTE DATE nel nome** — nomi descrittivi basati sull'argomento
  - WRONG: `redundancy-fixes-january-2026.md`, `phpstan-fixes-2025-10.md`
  - CORRECT: `redundancy-fixes.md`, `phpstan-fixes.md`
  - Eccezione: migration files DEVONO avere timestamp (`2024_01_01_000000_create_table.php`)

### Type Safety
```php
// Property types
public string $name;
public ?User $user = null;

// Return types
public function getUser(): ?User
{
    return $this->user;
}

// PHPDoc for collections
/**
 * @return Collection<int, User>
 */
public function getUsers(): Collection
```

### Laravel Best Practices
- Use `php artisan make:` commands
- Use Eloquent relationships (avoid raw queries)
- Use Form Request classes for validation
- Use `config()` not `env()` outside config files
- Use `app()` container resolution (not constructor DI in actions)

### Filament Rules
- Extend `XotBaseResource` (not Filament Resource directly)
- Use `getFormSchema()` method
- Use translation keys, never hardcoded strings
- **Translation files must have at least Italian and English** (create both `lang/it/` and `lang/en/` files)
- String keys required in `getTableColumns()`:
```php
return [
    'name' => TextColumn::make('name'),
];
```

### NEVER Simplify Domain Logic
1. **Never remove options** from Selects or Filters
2. **Never delete** `getHeaderActions()` or custom actions
3. **Never replace** `@include` with inline code
4. **Never remove** traits from models
5. **Preserve** array string keys in all schemas

## Module Architecture

```
Modules/{ModuleName}/
├── app/{Actions,Models,Filament}/
├── tests/{Feature,Unit}/
└── lang/{de,en,it}/
```

- Models extend `XotBaseModel`
- Actions use Spatie `QueueableAction`
- Providers extend `XotBaseServiceProvider`

## Critical Rules

1. All PHPStan errors must be fixed (no ignored errors)
2. Write tests for all new functionality (follow TDD Red-Green-Refactor)
3. Never commit secrets/keys
4. Use `search-docs` tool before coding (Laravel ecosystem)
5. Never use `property_exists()` on Eloquent models

## Quality Checks (obbligatori dopo ogni modifica)

Dopo ogni modifica al codice, eseguire SEMPRE:

```bash
# PHPStan (Level 10 - obbligatorio, tutti gli errori devono essere risolti)
php -d memory_limit=2G ./vendor/bin/phpstan analyse

# PHPMD (PHP Mess Detector)
./vendor/bin/phpmd . text phpmd.xml --exclude vendor,node_modules,bootstrap,caches

# PHPInsights
./vendor/bin/phpinsights -v --no-interaction
```

Tutti gli errori di PHPStan, PHPMD e PHPInsights devono essere risolti prima di considerare completata la modifica.

## Testing Patterns

Vedi [docs/tdd-guide.md](docs/tdd-guide.md) per guida completa TDD.

### Pattern AAA (Arrange-Act-Assert)

```php
// Pest test
it('creates user successfully', function () {
    // ARRANGE: Setup
    $data = UserData::factory()->make();
    
    // ACT: Execute
    $user = CreateUserAction::execute($data);
    
    // ASSERT: Verify
    expect($user)->toBeInstanceOf(User::class);
    expect($user->name)->toBe($data->name);
});

// Filament test
Livewire::test(CreateUser::class)
    ->fillForm(['name' => 'John'])
    ->call('create')
    ->assertNotified();
```

### Test Naming Convention

- **File**: `PascalCase` matching class name (e.g., `GenerateDbDocumentationCommandTest.pest.php`)
- **Metodi**: `it('description')` o `test('description')`
- **Struttura**: AAA (Arrange-Act-Assert)

## MCP Tools (Laravel Boost)
- `search-docs` - Laravel ecosystem docs
- `tinker` - Execute PHP in app context
- `database-query` - Read-only SQL
- `list-artisan-commands` - Available commands
