# Rating Model - Schemaless Attributes Usage

**Module**: IndennitaResponsabilita  
**Model**: Rating  
**Package**: spatie/laravel-schemaless-attributes  
**Last Updated**: 2025-01-02

---

## 📋 Overview

Il modello `Rating` utilizza il pacchetto Spatie Schemaless Attributes per gestire attributi dinamici legati all'anno di riferimento. Questo permette di avere configurazioni diverse per anno senza modificare la struttura del database.

---

## 🔍 Current Implementation

### Model Setup

```php
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

class Rating extends BaseModel
{
    protected function casts(): array
    {
        return [
            'extra_attributes' => SchemalessAttributes::class,
        ];
    }
    
    public function scopeWithExtraAttributes(Builder $query): Builder
    {
        return $this->extra_attributes->modelScope();
    }
}
```

### Usage in CompilaIndennitaResponsabilita

#### ✅ CORRECT Usage

```php
// In getViewData() method (line 289) - CORRECTED in Rating model
$rows = Rating::withExtraAttributes('anno', $anno)->get();

// Alternative (also correct)
$rows = Rating::where('extra_attributes->anno', $anno)->get();
```

**Note**: The scope `withExtraAttributes()` now correctly implements parameter handling. Both patterns work correctly.

---

## ⚠️ CRITICAL: Query Best Practices

### DO's

```php
// ✅ Query by anno attribute using scope
$ratings = Rating::withExtraAttributes(['anno' => 2024])->get();

// ✅ Multiple conditions
$ratings = Rating::withExtraAttributes([
    'anno' => 2024,
    'is_active' => true,
])->get();

// ✅ Combine with regular queries
$ratings = Rating::where('category', 'performance')
    ->withExtraAttributes(['anno' => 2024])
    ->orderBy('title')
    ->get();
```

### DON'Ts

```php
// ❌ NEVER use LIKE on JSON column (performance issue)
$ratings = Rating::where('extra_attributes', 'LIKE', '%2024%')->get();

// ❌ AVOID raw queries (use scope or JSON path instead)
$ratings = Rating::whereRaw("extra_attributes->>'anno' = '2024'")->get();

// Note: where('extra_attributes->key', $value) is CORRECT and acceptable
```

---

## 📊 Schema Documentation

### Extra Attributes Structure

```php
/**
 * Rating extra_attributes schema:
 *
 * - anno: int - Anno di riferimento
 * - is_readonly: bool - Se il rating è readonly
 * - is_disabled: bool - Se il rating è disabilitato
 * - config: array - Configurazioni specifiche per anno
 *   - min_value: int
 *   - max_value: int
 *   - multiplier: float
 */
```

### Example Data

```json
{
    "anno": 2024,
    "is_readonly": false,
    "is_disabled": false,
    "config": {
        "min_value": 0,
        "max_value": 5,
        "multiplier": 10.0
    }
}
```

---

## 🔧 Common Operations

### Setting Attributes

```php
// Create new rating for specific year
$rating = new Rating([
    'title' => 'Complessità',
    'description' => 'Valutazione complessità mansione',
]);

$rating->extra_attributes->anno = 2024;
$rating->extra_attributes->is_readonly = false;
$rating->extra_attributes->is_disabled = false;
$rating->extra_attributes->config = [
    'min_value' => 0,
    'max_value' => 5,
    'multiplier' => 10.0,
];

$rating->save(); // IMPORTANT: Always save!
```

### Getting Attributes

```php
// Get with default
$anno = $rating->extra_attributes->get('anno', date('Y'));
$isReadonly = $rating->extra_attributes->get('is_readonly', false);

// Direct access (if exists)
if (isset($rating->extra_attributes->anno)) {
    $anno = $rating->extra_attributes->anno;
}

// Nested access
$multiplier = $rating->extra_attributes->get('config.multiplier', 1.0);
```

### Updating Attributes

```php
// Update specific attribute
$rating->extra_attributes->set('anno', 2025);
$rating->save();

// Update multiple
$rating->extra_attributes = [
    'anno' => 2025,
    'is_readonly' => true,
    'config' => [
        'min_value' => 0,
        'max_value' => 10,
        'multiplier' => 15.0,
    ],
];
$rating->save();
```

---

## 🎯 Use Cases in IndennitaResponsabilita

### 1. Year-Specific Ratings

```php
// Get all ratings for current year
$currentYearRatings = Rating::withExtraAttributes([
    'anno' => now()->year,
])->get();

// Get editable ratings for specific year
$editableRatings = Rating::withExtraAttributes([
    'anno' => 2024,
    'is_readonly' => false,
    'is_disabled' => false,
])->get();
```

### 2. Rating Configuration

```php
// Get rating with specific configuration
public function getRatingMultiplier(Rating $rating): float
{
    return (float) $rating->extra_attributes->get('config.multiplier', 1.0);
}

// Check if rating is editable
public function isRatingEditable(Rating $rating): bool
{
    $isReadonly = $rating->extra_attributes->get('is_readonly', false);
    $isDisabled = $rating->extra_attributes->get('is_disabled', false);
    
    return !$isReadonly && !$isDisabled;
}
```

### 3. Dynamic Rating Display

```php
// In Blade view preparation
protected function prepareRatingsForView(Collection $ratings): array
{
    return $ratings->map(function (Rating $rating) {
        return [
            'id' => $rating->id,
            'title' => $rating->title,
            'value' => $rating->pivot->value ?? 0,
            'is_readonly' => $rating->extra_attributes->get('is_readonly', false),
            'is_disabled' => $rating->extra_attributes->get('is_disabled', false),
            'config' => $rating->extra_attributes->get('config', []),
        ];
    })->toArray();
}
```

---

## 🧪 Testing

### Unit Tests

```php
/** @test */
public function it_stores_year_specific_attributes(): void
{
    $rating = Rating::factory()->create();
    
    $rating->extra_attributes->anno = 2024;
    $rating->extra_attributes->is_readonly = false;
    $rating->save();
    
    $rating = $rating->fresh();
    
    $this->assertEquals(2024, $rating->extra_attributes->anno);
    $this->assertFalse($rating->extra_attributes->is_readonly);
}

/** @test */
public function it_queries_ratings_by_year(): void
{
    Rating::factory()->create(['extra_attributes' => ['anno' => 2024]]);
    Rating::factory()->create(['extra_attributes' => ['anno' => 2023]]);
    
    $ratings2024 = Rating::withExtraAttributes(['anno' => 2024])->get();
    
    $this->assertCount(1, $ratings2024);
    $this->assertEquals(2024, $ratings2024->first()->extra_attributes->anno);
}
```

---

## 🚨 Migration Notes

### Adding Schemaless Column

```php
// If not already present
Schema::table('ratings', function (Blueprint $table) {
    if (!Schema::hasColumn('ratings', 'extra_attributes')) {
        $table->schemalessAttributes('extra_attributes');
    }
});
```

### Data Migration Example

```php
// Migrate old year column to schemaless
$ratings = Rating::whereNull('extra_attributes')->get();

foreach ($ratings as $rating) {
    $rating->extra_attributes = [
        'anno' => $rating->anno ?? now()->year,
        'is_readonly' => false,
        'is_disabled' => false,
    ];
    $rating->save();
}
```

---

## 📚 Related Documentation

### Internal Docs
- [Xot Schemaless Attributes Guide](../../Xot/docs/spatie-schemaless-attributes-guide.md) - Complete guide
- [Claude Schemaless Rules](../../../docs/claude/schemaless-attributes-rules.md) - Quick rules
- [Code Quality Analysis](./code-quality-analysis.md) - Module analysis

### Package Docs
- [Spatie Package](https://github.com/spatie/laravel-schemaless-attributes)
- [Laravel JSON Columns](https://laravel.com/docs/11.x/eloquent-mutators#array-and-json-casting)

---

## ⚠️ Known Issues & Solutions

### Issue 1: Query Returns Empty

**Problem**: `Rating::where('extra_attributes->anno', 2024)->get()` returns empty

**Solution**: Use scope instead
```php
Rating::withExtraAttributes(['anno' => 2024])->get()
```

### Issue 2: Attributes Not Persisting

**Problem**: Changes to attributes are lost

**Solution**: Always call `save()`
```php
$rating->extra_attributes->anno = 2024;
$rating->save(); // REQUIRED
```

### Issue 3: Cast Not Working

**Problem**: `Trying to get property of non-object`

**Solution**: Ensure cast is defined
```php
protected function casts(): array {
    return ['extra_attributes' => SchemalessAttributes::class];
}
```

---

## ✅ Checklist

Before using schemaless attributes in Rating:

- [ ] Cast defined in Model
- [ ] Scope method implemented
- [ ] Schema documented in PHPDoc
- [ ] Accessor methods for common attributes
- [ ] Always use `withExtraAttributes()` for queries
- [ ] Always call `save()` after modifications
- [ ] Tests cover schemaless functionality

---

**Author**: Development Team  
**Last Updated**: 2025-01-02  
**Status**: ✅ Documented


