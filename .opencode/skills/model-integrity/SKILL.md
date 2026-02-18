---
name: model-integrity
description: Protocols for maintaining Eloquent model quality, type safety, and modern standards.
---

# Model Integrity Skill

This skill ensures that Eloquent models adhere to the latest PTVX/Laraxot quality standards, specifically focusing on type safety and modern Laravel features.

## 🚨 Critical Rules

### 1. Modern Casting (Rule #8)
The `protected $casts` property is DEPRECATED. Use the `casts()` method instead.

```php
// ✅ CORRECT
/** @return array<string, string> */
protected function casts(): array {
    return [
        'email_verified_at' => 'datetime',
        'options' => 'array',
    ];
}
```

### 2. Safeguarding Data Access
NEVER use `property_exists()` on Eloquent models to check for attribute existence. This ignores dynamic attributes and relationships.

```php
// ❌ WRONG
if (property_exists($model, 'attribute')) { ... }

// ✅ CORRECT
if (isset($model->attribute)) { ... }
// or
if ($model->getAttribute('attribute')) { ... }
```

### 3. Schemaless Attributes (Spatie)
Always use the provided scopes for querying schemaless attributes instead of direct JSON path queries.

```php
// ✅ CORRECT
$models = Model::withExtraAttributes('key', 'value')->get();

// ❌ WRONG
$models = Model::where('extra_attributes->key', 'value')->get();
```

## 🛠️ Procedural Workflow

### Refactoring a Model to Level 10
1. Convert `$casts` property to `casts()` method.
2. Ensure all relationships have explicit return types (e.g., `BelongsTo`, `HasMany`).
3. Replace `property_exists()` with `isset()` or `getAttribute()`.
4. Add PHPDoc for magic properties if they are frequently used.
5. Verify with `phpstan analyze` at Level 10.
