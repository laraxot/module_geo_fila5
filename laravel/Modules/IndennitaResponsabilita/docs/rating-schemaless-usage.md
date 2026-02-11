# Rating Model - Schemaless Attributes Usage

**Module**: IndennitaResponsabilita  
**Model**: Rating  
**Package**: spatie/laravel-schemaless-attributes  
**Last Updated**: 2026-02-11

---

## 📋 Overview

Il modello `Rating` utilizza il pacchetto Spatie Schemaless Attributes per gestire attributi dinamici legati all'anno di riferimento. Questo permette di avere configurazioni diverse per anno senza modificare la struttura del database.

---

## 🔍 Correct Implementation

### Model Setup (CORRECTED - 2026-02-11)

```php
<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Models;

use Modules\Rating\Models\BaseRating;

/**
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes|null $extra_attributes
 *
 * @method static Builder|Rating withExtraAttributes(array|string $attributes = [], mixed $value = null)
 */
class Rating extends BaseRating
{
    protected $connection = 'indennita_responsabilita';

    // casts(), scopeWithExtraAttributes(), $fillable ereditati da BaseRating (DRY)
    // Vedi: Modules/Rating/app/Models/BaseRating.php
}
```

**Pattern DRY+KISS**: Tutti i moduli che usano Rating devono estendere `BaseRating`,
che fornisce casts, scope e fillable. Solo `$connection` va overridato.

---

## ⚠️ Common Errors to Avoid

### 1. Wrong Import

```php
// ❌ WRONG - imports the SchemalessAttributes class itself
use Spatie\SchemalessAttributes\SchemalessAttributes;

// ✅ CORRECT - imports the Cast class
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;
```

### 2. Ereditare casts() da BaseRating (DRY)

```php
// ✅ CORRECT - BaseRating definisce casts() con SchemalessAttributes
// Non serve override se i casts sono gli stessi
class Rating extends BaseRating
{
    protected $connection = 'indennita_responsabilita';
    // casts() ereditato da BaseRating include extra_attributes => SchemalessAttributes::class
}

// ✅ CORRECT - Override solo se servono casts aggiuntivi
class Rating extends BaseRating
{
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'custom_field' => 'json',
        ]);
    }
}
```

### 3. Incorrect PHPDoc for Property

```php
// ❌ WRONG - using imported class name
 * @property SchemalessAttributes|null $extra_attributes

// ✅ CORRECT - using fully qualified class name
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes|null $extra_attributes
```

---

## ✅ CORRECT Usage Examples

### Query by Single Attribute

```php
// ✅ Using scope with single attribute
$rows = Rating::withExtraAttributes('anno', 2024)->get();

// ✅ Using scope with array syntax
$rows = Rating::withExtraAttributes(['anno' => 2024])->get();

// ✅ Using JSON path syntax (also valid)
$rows = Rating::where('extra_attributes->anno', 2024)->get();
```

### Query by Multiple Attributes

```php
// ✅ Using scope with multiple attributes
$rows = Rating::withExtraAttributes([
    'anno' => 2024,
    'type' => 'performance',
])->get();

// Equivalent to:
$rows = Rating::where('extra_attributes->anno', 2024)
    ->where('extra_attributes->type', 'performance')
    ->get();
```

### Setting Attributes

```php
$rating = new Rating(['title' => 'Test']);

// ✅ Set single attribute
$rating->extra_attributes->anno = 2024;

// ✅ Set using array syntax
$rating->extra_attributes['type'] = 'performance';

// ✅ Set using set() method
$rating->extra_attributes->set('config.multiplier', 10.0);

// ✅ Replace all attributes
$rating->extra_attributes = [
    'anno' => 2024,
    'type' => 'performance',
    'config' => ['multiplier' => 10.0],
];

// ⚠️ REQUIRED: Always save!
$rating->save();
```

### Getting Attributes

```php
// ✅ Direct access (if exists)
if (isset($rating->extra_attributes->anno)) {
    $anno = $rating->extra_attributes->anno;
}

// ✅ Using get() with default
$anno = $rating->extra_attributes->get('anno', date('Y'));

// ✅ Array access
$anno = $rating->extra_attributes['anno'];

// ✅ Nested access with dot notation
$multiplier = $rating->extra_attributes->get('config.multiplier', 1.0);
```

---

## 🎯 Use Cases in IndennitaResponsabilita

### 1. Year-Specific Ratings in CompilaIndennitaResponsabilita

```php
// In CompilaIndennitaResponsabilita::getViewData()
$anno = $record->anno;

// ✅ CORRECT: Query ratings for specific year
$rows = Rating::withExtraAttributes('anno', $anno)
    ->where('is_disabled', '!=', true)
    ->where('is_readonly', '!=', true)
    ->get();

// ✅ CORRECT: Alternative syntax
$rows = Rating::where('extra_attributes->anno', $anno)
    ->where('is_disabled', '!=', true)
    ->where('is_readonly', '!=', true)
    ->get();
```

### 2. Filter in ListRatings

```php
// In ListRatings::getTableFilters()
Filter::make('filter')
    ->schema([
        Select::make('anno')
            ->options(self::getYears()),
    ])
    ->query(function (Builder $query, array $data): Builder {
        $anno = $data['anno'] ?? null;
        if ($anno === null) {
            return $query;
        }

        // ✅ CORRECT: Use scope for filtering
        return $query->withExtraAttributes('anno', $anno);
        
        // Alternative (also valid):
        // return $query->where('extra_attributes->anno', $anno);
    }),
```

### 3. Copy from Last Year Action

```php
// In ListRatings::getTableHeaderActions()
Action::make('copy_from_last_year')
    ->action(function () use ($anno): void {
        $anno_prec = $anno - 1;
        
        // ✅ CORRECT: Query by extra_attributes
        $rows = Rating::withExtraAttributes('anno', $anno_prec)->get();
        
        foreach ($rows as $row) {
            $data = $row->toArray();
            unset($data['id']);
            
            $rowCreated = Rating::query()->firstOrCreate(
                ['title' => $data['title']],
                $data
            );
            
            // ✅ CORRECT: Update schemaless attribute
            if ($rowCreated->extra_attributes !== null) {
                $rowCreated->extra_attributes->set('anno', $anno);
                $rowCreated->save(); // REQUIRED!
            }
        }
    }),
```

---

## 📊 Schema Documentation

### Extra Attributes Structure for Rating

```php
/**
 * Rating extra_attributes schema:
 *
 * - anno: int - Anno di riferimento (es. 2024, 2025)
 * - type: string|null - Tipo di rating (es. 'performance', 'bonus')
 * - config: array|null - Configurazioni specifiche per anno
 *   - min_value: int - Valore minimo (default: 0)
 *   - max_value: int - Valore massimo (default: 5)
 *   - multiplier: float - Moltiplicatore per calcolo (default: 1.0)
 */
```

---

## 🧪 Testing Examples

```php
/** @test */
public function it_stores_year_in_extra_attributes(): void
{
    $rating = Rating::factory()->create();
    
    $rating->extra_attributes->anno = 2024;
    $rating->save();
    
    $fresh = $rating->fresh();
    
    $this->assertEquals(2024, $fresh->extra_attributes->anno);
}

/** @test */
public function it_queries_by_year_using_scope(): void
{
    Rating::factory()->create([
        'title' => 'Rating 2024',
        'extra_attributes' => ['anno' => 2024],
    ]);
    
    Rating::factory()->create([
        'title' => 'Rating 2023',
        'extra_attributes' => ['anno' => 2023],
    ]);
    
    $ratings2024 = Rating::withExtraAttributes('anno', 2024)->get();
    
    $this->assertCount(1, $ratings2024);
    $this->assertEquals('Rating 2024', $ratings2024->first()->title);
}
```

---

## 📚 Related Documentation

- [Spatie Package](https://github.com/spatie/laravel-schemaless-attributes)
- [Laravel JSON Columns](https://laravel.com/docs/11.x/eloquent-mutators#array-and-json-casting)

---

## ✅ Checklist

Before using schemaless attributes in Rating:

- [x] Import `Spatie\SchemalessAttributes\Casts\SchemalessAttributes` (NOT the class itself)
- [x] Define `casts()` method with `extra_attributes => SchemalessAttributes::class`
- [x] Implement `scopeWithExtraAttributes()` for querying
- [x] Document property as `\Spatie\SchemalessAttributes\SchemalessAttributes|null`
- [x] Always call `save()` after modifying attributes
- [x] Use `where('extra_attributes->key', $value)` or `withExtraAttributes()` scope

---

**Author**: Development Team
**Last Updated**: 2026-02-11
**Status**: Fixed - Rating ora estende BaseRating (DRY)
**Errori documentati**: [Rating/docs/schemaless-attributes-errors.md](../../Rating/docs/schemaless-attributes-errors.md)
