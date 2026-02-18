---
name: create-model
description: Create Eloquent models following Laraxot patterns with proper typing, casts method, relationships, and PHPStan Level 10 compliance. Use when adding new database models to any module.
---

# Create Model - Laraxot Eloquent Pattern

Create Eloquent models with full type safety and Laraxot conventions.

## When to Use

- Creating a new database model
- Adding relationships to existing models
- Fixing model type issues for PHPStan
- When the user asks to "create model" or "add model"

## Template: Standard Model

```php
<?php

declare(strict_types=1);

namespace Modules\{Module}\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class {ModelName} extends Model
{
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'data' => 'array',
            'is_active' => 'boolean',
            'amount' => 'decimal:2',
        ];
    }

    /**
     * @return BelongsTo<ParentModel, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(ParentModel::class);
    }

    /**
     * @return HasMany<ChildModel, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(ChildModel::class);
    }
}
```

## Critical Rules

### 1. Casts as Method (NOT Property)
```php
// WRONG
protected $casts = ['data' => 'array'];

// CORRECT
protected function casts(): array
{
    return ['data' => 'array'];
}
```

### 2. NEVER Use property_exists()
```php
// WRONG
if (property_exists($model, 'name')) { ... }

// CORRECT
if ($model->hasAttribute('name')) { ... }
if (isset($model->name)) { ... }
```

### 3. PHPDoc for Properties
Add `@property` annotations for all database columns to help PHPStan.

### 4. Typed Relationships with Generics
```php
/** @return BelongsTo<User, $this> */
public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}
```

### 5. Fillable as Typed Array
```php
/** @var list<string> */
protected $fillable = ['name', 'email'];
```

### 6. Short Array Syntax Only
```php
// WRONG
protected $fillable = array('name');

// CORRECT
protected $fillable = ['name'];
```

## Namespace Convention

- Filesystem: `Modules/{Module}/app/Models/{Model}.php`
- Namespace: `Modules\{Module}\Models` (NO "App" in namespace)

## After Creating

1. Create migration: `php artisan make:migration create_{table}_table`
2. Create factory: `Modules/{Module}/database/factories/{Model}Factory.php`
3. Create tests: `Modules/{Module}/tests/Unit/Models/{Model}Test.php`
4. Run PHPStan to verify compliance
5. Run Pint for formatting
