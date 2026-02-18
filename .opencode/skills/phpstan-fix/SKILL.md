---
name: phpstan-fix
description: Run PHPStan analysis on a module and fix all errors following Level 10 approach. Use when fixing type errors, adding return types, resolving PHPStan violations, or improving code quality in any module.
---

# PHPStan Fix - Level 10 Compliance

Analyze and fix PHPStan errors module-by-module following the "Fix, Don't Ignore" principle.

## When to Use

- When PHPStan reports errors in a module
- When adding new code that needs type safety verification
- When refactoring models, actions, or Filament components
- When the user asks to "fix phpstan" or "run phpstan" or "fix errors"

## Instructions

### 1. Run Analysis

Always run from the `laravel/` directory:

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/{ModuleName} --memory-limit=-1
```

For a single file:
```bash
cd laravel && ./vendor/bin/phpstan analyse path/to/file.php --memory-limit=-1
```

Save output for documentation:
```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/{ModuleName} --memory-limit=-1 --error-format=json > Modules/{ModuleName}/docs/phpstan/phpstan_errors.json
cd laravel && ./vendor/bin/phpstan analyse Modules/{ModuleName} --memory-limit=-1 --error-format=table > Modules/{ModuleName}/docs/phpstan/phpstan_errors.txt
```

### 2. Critical Rules

- **NEVER modify `laravel/phpstan.neon`**
- **NO baseline files** - fix every error
- **NO ignoreErrors** except for confirmed PHPStan bugs with referenced GitHub issue
- **Complete one module before moving to the next**
- Use `Safe\` functions for file operations, JSON, etc.
- Use `Webmozart\Assert\Assert` for input validation

### 3. Common Fix Patterns

#### Eloquent Models - NEVER use property_exists()
```php
// WRONG
if (property_exists($model, 'attribute')) { ... }

// CORRECT alternatives:
if ($model->hasAttribute('attribute')) { ... }
if ($model->isFillable('attribute')) { ... }
Schema::hasColumn('table_name', 'attribute')
```

#### Type Safety with HtmlString
```php
use Webmozart\Assert\Assert;
use Illuminate\Support\HtmlString;

Assert::string($value, 'Expected string, got: %s');
return new HtmlString($value);
```

#### Model Casts - Use method not property
```php
// WRONG
protected $casts = ['data' => 'array'];

// CORRECT
protected function casts(): array
{
    return ['data' => 'array'];
}
```

#### Explicit Return Types
```php
// WRONG
public function getFullName() { ... }

// CORRECT
public function getFullName(): string { ... }
```

### 4. After Fixing

1. Re-run PHPStan to verify zero errors
2. Run `vendor/bin/pint --dirty` to format
3. Update the module's `docs/roadmap.md` with progress
4. Commit changes with descriptive message

### 5. Memory Issues

For complex modules:
```bash
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/{ModuleName} --memory-limit=-1
```
