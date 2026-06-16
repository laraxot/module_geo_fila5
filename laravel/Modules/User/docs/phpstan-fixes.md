# PHPStan Compliance — User Module

**Last Updated**: 2026-06-13  
**Status**: ✅ Zero Errors  
**PHPStan Level**: max

## Issues Resolved

### 1. Pest Closure Scope Type Hints

**File**: `tests/Feature/DemoUserSeederTest.pest.php`

**Issue**: 
```
Cannot call method markTestSkipped() on mixed
Undefined variable: $this
```

**Root Cause**: Pest closure doesn't automatically provide `$this` type to PHPStan

**Fix**: Added docblock type hint inside closure:

```php
it('creates deterministic demo users idempotently', function (): void {
    /** @var TestCase $this */  // ← Type hint for Pest scope
    if (! Schema::connection('user')->hasTable('permissions')
        || ! Schema::connection('user')->hasTable('roles')) {
        $this->markTestSkipped('User RBAC migrations required on connection user');
    }
    // ...
});
```

**Impact**: PHPStan now recognizes TestCase methods available in closure

### 2. Missing Facade Import

**File**: `tests/Feature/DemoUserSeederTest.pest.php`

**Issue**: Undefined class `Artisan` in test

**Fix**: Added import at top of file:

```php
use Illuminate\Support\Facades\Artisan;

// Later in test
Artisan::call('db:seed', ['--class' => UserSeeder::class, '--no-interaction' => true]);
```

## Test Files (Pest Format)

- `tests/Feature/DemoUserSeederTest.pest.php` — Feature test with Pest DSL

## Pattern: Pest with TestCase Context

When Pest test closures need TestCase methods:

```php
it('test name', function (): void {
    /** @var TestCase $this */
    // Now $this is properly typed for PHPStan
    $this->markTestSkipped('reason');
});
```

## Validation

```bash
./vendor/bin/phpstan analyse Modules/User
# Result: [OK] No errors
```

## Related Documentation

- [Pest Scope Type Hints](../../docs/wiki/skills/pest-scope-type-hints.md)
- [PHPStan Sacred Configuration](../../docs/wiki/rules/phpstan-neon-sacred.md)
