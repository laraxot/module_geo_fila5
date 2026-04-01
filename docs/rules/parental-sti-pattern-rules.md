# Parental STI Pattern Rules for Laraxot

## 🔴 CRITICAL: Parental Package Behavior

### What Parental Does Automatically

The **Tighten Parental** package (`tightenco/parental`) provides Single Table Inheritance (STI) for Laravel Eloquent models.

**Key Discovery**: The `HasParent` trait **automatically adds a global scope** that filters child models by their type!

From `vendor/tightenco/parental/src/HasParent.php`:

```php
public static function bootHasParent(): void
{
    static::creating(function ($model) {
        if ($model->parentHasHasChildrenTrait()) {
            $model->forceFill([
                $model->getInheritanceColumn() => $model->classToAlias(get_class($model))
            ]);
        }
    });

    // ✅ AUTOMATIC GLOBAL SCOPE - Filters by type automatically
    static::addGlobalScope(function ($query) {
        $instance = new static;
        if ($instance->parentHasHasChildrenTrait()) {
            $query->where(
                $query->getModel()->getTable() . '.' . $instance->getInheritanceColumn(),
                $instance->classToAlias(get_class($instance))
            );
        }
    });
}
```

### Our Implementation Pattern

Even though Parental handles filtering automatically, we **explicitly add a global scope** in each child model's `boot()` method:

```php
class IndividualeRegionale extends Individuale
{
    use HasParent;

    protected static function boot(): void
    {
        parent::boot();  // ✅ Calls bootHasParent() from HasParent trait

        // ✅ Redundant but recommended for clarity and defense
        static::addGlobalScope(function ($query) {
            $query->where('type', 'regionale');
        });
    }
}
```

### Why We Add Redundant Global Scope

| Reason | Explanation |
|--------|-------------|
| **Self-Documenting** | Clear intent in the code - developers see the filter immediately |
| **Defensive** | Works even if Parental configuration changes or is removed |
| **Debuggable** | Easier to understand when debugging queries |
| **Consistent** | All child models follow the same explicit pattern |
| **Safe** | Two identical filters don't break anything |

## ✅ DO: Implementation Checklist

When creating a new child model with Parental:

### 1. Parent Model Setup

```php
class Individuale extends BaseIndividualeModel
{
    use HasChildren;

    protected string $childColumn = 'type';  // Or custom column name

    protected array $childTypes = [
        'po' => IndividualePo::class,
        'dip' => IndividualeDip::class,
        'regionale' => IndividualeRegionale::class,
        'dirigente' => IndividualeDirigente::class,
    ];

    protected $fillable = ['type', /* other fields */];  // ← type MUST be fillable
}
```

### 2. Child Model Setup

```php
class IndividualeRegionale extends Individuale
{
    use HasParent;  // ✅ Required trait

    /**
     * Boot the model and add global scope to filter by type.
     *
     * This ensures that IndividualeRegionale only returns records
     * where type = 'regionale', as required by Parental STI pattern.
     */
    protected static function boot(): void  // ✅ Explicit boot method
    {
        parent::boot();  // ✅ MUST call parent::boot() first

        static::addGlobalScope(function ($query) {  // ✅ Use static:: not self::
            $query->where('type', 'regionale');  // Match key in parent's $childTypes
        });
    }

    // ... rest of model
}
```

### 3. Database Migration

```php
Schema::create('performance_individuale', function (Blueprint $table) {
    $table->id();
    $table->string('type')->nullable();  // ✅ REQUIRED for Parental STI
    $table->string('post_type')->nullable();
    // ... other fields
    $table->timestamps();
});
```

## ❌ DON'T: Common Mistakes

### Mistake 1: Not Calling parent::boot()

```php
// ❌ WRONG - Breaks HasParent trait!
protected static function boot(): void
{
    // Missing parent::boot() call
    static::addGlobalScope(function ($query) {
        $query->where('type', 'regionale');
    });
}
```

### Mistake 2: Using self:: Instead of static::

```php
// ❌ WRONG - Won't work with inheritance
protected static function boot(): void
{
    parent::boot();
    
    self::addGlobalScope(function ($query) {  // ❌ self:: breaks late binding
        $query->where('type', 'regionale');
    });
}

// ✅ CORRECT
protected static function boot(): void
{
    parent::boot();
    
    static::addGlobalScope(function ($query) {  // ✅ static:: for late binding
        $query->where('type', 'regionale');
    });
}
```

### Mistake 3: Missing type in $fillable

```php
// ❌ WRONG - Can't create child models
class Individuale extends Model
{
    use HasChildren;
    
    protected $fillable = ['matr', 'cognome', 'nome'];  // ❌ Missing 'type'
}

// ✅ CORRECT
class Individuale extends Model
{
    use HasChildren;
    
    protected $fillable = ['type', 'matr', 'cognome', 'nome'];  // ✅ type included
}
```

### Mistake 4: Mismatched Type Values

```php
// Parent model
class Individuale extends Model
{
    use HasChildren;
    
    protected array $childTypes = [
        'regionale' => IndividualeRegionale::class,  // ← Key is 'regionale'
    ];
}

// Child model
class IndividualeRegionale extends Individuale
{
    use HasParent;
    
    protected static function boot(): void
    {
        parent::boot();
        
        static::addGlobalScope(function ($query) {
            $query->where('type', 'dip');  // ❌ WRONG - Should be 'regionale'
        });
    }
}
```

## 🔍 Troubleshooting

### Problem: Child Model Shows All Types

**Symptoms**: Querying `IndividualeRegionale::all()` returns records of all types

**Debug Steps**:

1. **Verify Model Configuration**
   ```php
   $model = new IndividualeRegionale();
   echo $model->getTable();  // Should be 'performance_individuale'
   echo $model->getInheritanceColumn();  // Should be 'type'
   echo $model->classToAlias(get_class($model));  // Should be 'regionale'
   ```

2. **Check Global Scopes**
   ```php
   $query = IndividualeRegionale::query();
   dd($query->getQuery()->wheres);  // Should show type filter
   ```

3. **Clear Caches**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   php artisan route:clear
   ```

4. **Check OpCache**
   - Restart PHP-FPM: `sudo systemctl restart php-fpm`
   - Or restart Apache: `sudo systemctl restart apache2`

5. **Verify Database Data**
   ```sql
   SELECT DISTINCT type FROM performance_individuale;
   -- Should show: 'regionale', 'dip', 'po', 'dirigente'
   ```

### Problem: Type Column Not Auto-Filled

**Symptoms**: Creating child model doesn't set type column

**Solution**: Verify `bootHasParent()` is running:

```php
class IndividualeRegionale extends Individuale
{
    use HasParent;

    protected static function boot(): void
    {
        parent::boot();  // ✅ This calls bootHasParent() from trait
        
        // Your additional logic...
    }
}
```

## 📚 Reference Files

- `Modules/Performance/app/Models/Individuale.php` - Parent model example
- `Modules/Performance/app/Models/IndividualeRegionale.php` - Child model example
- `Modules/Performance/docs/parental-sti-pattern.md` - Complete pattern guide
- `vendor/tightenco/parental/src/HasParent.php` - Trait source code
- `vendor/tightenco/parental/src/HasChildren.php` - Parent trait source

## Related Patterns

- **Single Table Inheritance (STI)**: One table, multiple model types
- **Polymorphic Relations**: Different models can belong to same parent
- **Eloquent Global Scopes**: Automatically filter queries

## Laravel Version Compatibility

- ✅ Laravel 10+
- ✅ Laravel 11+ (with enhanced eager loading support)
- ✅ Filament v5
- ✅ PHP 8.3+

## Testing

### Unit Test Example

```php
it('only returns regionale records', function () {
    IndividualeRegionale::factory()->count(3)->create();
    IndividualeDip::factory()->count(2)->create();

    $regionales = IndividualeRegionale::query()->get();

    expect($regionales)->toHaveCount(3);
    expect($regionales->first()->type->value)->toBe('regionale');
});

it('automatically sets type on create', function () {
    $regionale = IndividualeRegionale::factory()->create();

    expect($regionale->type->value)->toBe('regionale');
});
```

### Filament Test Example

```php
it('can list only regionale records in Filament', function () {
    IndividualeRegionale::factory()->count(3)->create();
    IndividualeDip::factory()->count(2)->create();

    Livewire::test(ListIndividualeRegionales::class)
        ->assertCanSeeTableRecords(IndividualeRegionale::all())
        ->assertCanNotSeeTableRecords(IndividualeDip::all());
});
```

---

**Last Updated**: 2026-04-01  
**Verified**: ✅ Parental v2.x  
**Status**: Active Pattern in Laraxot
