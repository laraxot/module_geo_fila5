# PHPStan Perfection Guide

This guide documents the patterns and strategies used to achieve 100% PHPStan (Level Max) compliance across all Laraxot modules.

## Core Principles
1. **Never ignore errors**: Fix the underlying type issue instead of using `@phpstan-ignore`.
2. **Explicit is better than implicit**: Use `/** @var ... */` to help PHPStan when it loses track of types (especially with dynamic arrays or factories).
3. **Contracts over Concrete**: Always type-hint against Interfaces/Contracts (`UserContract`, `ProfileContract`) rather than concrete Models.
4. **Assert everything**: Use `Webmozart\Assert\Assert` to validate assumptions at runtime and inform PHPStan's static analysis.

## Common Patterns & Solutions

### 1. Dynamic Class Strings
When resolving classes from config or strings, PHPStan needs to know the specific type.
```php
/** @var class-string<Model&UserContract> $class */
$class = config('auth.providers.users.model');
Assert::classExists($class);
Assert::isAOf($class, Model::class);
```

### 2. String-Keyed Arrays
When passing arrays to `view()` or recursive actions, ensure they are explicitly marked as string-keyed.
```php
/** @var array<string, mixed> $stringKeyed */
$stringKeyed = [];
foreach ($data as $key => $value) {
    Assert::string($key);
    $stringKeyed[$key] = $value;
}
```

### 3. Recursive Array Walking
Use `@template` and `@var` to maintain type integrity during recursion.
```php
/**
 * @template TKey of array-key
 * @param array<TKey, mixed> $value
 * @return array<TKey, mixed>
 */
private function walkArray(array $value): array {
    /** @var array<TKey, mixed> $resolved */
    $resolved = [];
    // ...
    return $resolved;
}
```

### 4. Migration Model Detection
Migrations extending `XotBaseMigration` must ensure `model_class` is a valid `class-string<Model>`.
```php
/** @var class-string<Model> $modelClass */
$modelClass = $this->resolveModelClass();
Assert::isAOf($modelClass, Model::class);
$this->model_class = $modelClass;
```

## System Maintenance
- **Ghost Vendors**: Local `vendor` directories inside Modules must be deleted to avoid PHPStan internal errors.
- **Root Analysis**: Always run analysis from the `laravel` root using `./vendor/bin/phpstan analyse Modules`.

---
*Updated: May 2026*
