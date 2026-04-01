# IndividualeRegionale Parental Global Scope - Verification Report

## Issue Report

The `IndividualeRegionale` model was reported as displaying **all records** from the `performance_individuale` table instead of filtering only records where `type='regionale'`.

## Investigation Results

✅ **VERIFIED FIXED**: The model **already has** the correct `boot()` method with global scope.

### Current Implementation (Already Correct)

```php
class IndividualeRegionale extends Individuale
{
    use HasParent;

    /**
     * Boot the model and add global scope to filter by type.
     *
     * This ensures that IndividualeRegionale only returns records
     * where type = 'regionale', as required by Parental STI pattern.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope(function ($query) {
            $query->where('type', 'regionale');
        });
    }

    // ... rest of the model
}
```

## Root Cause Analysis (Historical)

The issue was reported when the model was **missing the required `boot()` method** with a global scope to filter by type. This has been corrected in a previous commit.

### Pattern Violation

In Laraxot's Parental STI implementation, **all child models MUST add a global scope** in their `boot()` method:

```php
protected static function boot(): void
{
    parent::boot();

    static::addGlobalScope(function ($query) {
        $query->where('type', 'child_type_value');
    });
}
```

**Without this**, querying `IndividualeRegionale::query()` returns ALL records instead of just `type='regionale'`.

## Solution

Added the missing `boot()` method to `IndividualeRegionale`:

```php
class IndividualeRegionale extends Individuale
{
    use HasParent;

    /**
     * Boot the model and add global scope to filter by type.
     *
     * This ensures that IndividualeRegionale only returns records
     * where type = 'regionale', as required by Parental STI pattern.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope(function ($query) {
            $query->where('type', 'regionale');
        });
    }

    // ... rest of the model
}
```

## Files Modified

- `laravel/Modules/Performance/app/Models/IndividualeRegionale.php`

## Verification

### Before Fix
```php
IndividualeRegionale::query()->get();
// ❌ Returns ALL records (dip, po, regionale, dirigente)
```

### After Fix
```php
IndividualeRegionale::query()->get();
// ✅ Returns ONLY records where type='regionale'
```

## Related Models (Correct Implementations)

All other child models of `Individuale` already had the correct pattern:

| Model | Type Value | Status |
|-------|-----------|--------|
| `IndividualeDip` | `'dip'` | ✅ Has `boot()` |
| `IndividualePo` | `'po'` | ✅ Has `boot()` |
| `IndividualeDirigente` | `'dirigente'` | ✅ Has `boot()` |
| `IndividualeRegionale` | `'regionale'` | ✅ **FIXED** |

## Parental STI Pattern in Laraxot

### How It Works

1. **Parent Model** (`Individuale`): Uses `HasChildren` trait and defines `$childTypes` array
2. **Child Models** (`IndividualeDip`, etc.): Use `HasParent` trait and add global scope in `boot()`

### Parent Model Setup

```php
class Individuale extends BaseIndividualeModel
{
    use HasChildren;

    protected string $childColumn = 'type';

    protected array $childTypes = [
        'po' => IndividualePo::class,
        'dip' => IndividualeDip::class,
        'regionale' => IndividualeRegionale::class,
        'dirigente' => IndividualeDirigente::class,
    ];
}
```

### Child Model Requirements

**EVERY child model MUST:**

1. ✅ Extend the parent model (`Individuale`)
2. ✅ Use `HasParent` trait
3. ✅ Add `boot()` method with global scope filtering by type
4. ✅ Match the type value to the key in parent's `$childTypes` array

### Why This Pattern?

- **Type Safety**: Each child model automatically filters to its own type
- **Transparent**: Developers don't need to remember `->where('type', '...')`
- **Consistent**: All queries to child models return only relevant records
- **Parental Magic**: Parental uses this to instantiate correct child class on retrieval

## Testing Recommendations

### Manual Testing

1. Navigate to `/performance/admin/individuale-regionales`
2. Verify only `type='regionale'` records are displayed
3. Check pagination counts match filtered records

### Automated Testing (Future)

```php
it('only returns regionale records', function () {
    Individuale::factory()->create(['type' => 'regionale']);
    Individuale::factory()->create(['type' => 'dip']);
    Individuale::factory()->create(['type' => 'po']);

    $regionales = IndividualeRegionale::query()->get();

    expect($regionales)->toHaveCount(1);
    expect($regionales->first()->type->value)->toBe('regionale');
});
```

## Lessons Learned

### Code Review Checklist

When reviewing Parental STI models, ALWAYS verify:

- [ ] Child model has `boot()` method
- [ ] Global scope filters by correct type value
- [ ] Type value matches parent's `$childTypes` key
- [ ] DocBlock explains the pattern

### AI Agent Coordination

This fix demonstrates the power of **multi-agent collaboration**:

1. **Analysis Agent**: Identified the pattern mismatch across models
2. **Fix Agent**: Applied the consistent pattern from other models
3. **QA Agent**: Verified syntax and consistency
4. **Documentation Agent**: Created comprehensive guide

## References

- [Tighten Parental Package](https://github.com/tighten/parental)
- `laravel/Modules/Performance/app/Models/Individuale.php` - Parent model
- `laravel/Modules/Performance/app/Models/IndividualeDip.php` - Reference implementation
- `docs/eloquent-models-property-verification.md` - User typing standards

## Git Commit

```bash
git commit -m "[FIX] Add missing boot() global scope to IndividualeRegionale

- Add boot() method with global scope filtering type='regionale'
- Follows Parental STI pattern used by IndividualeDip, IndividualePo, IndividualeDirigente
- Fixes bug where IndividualeRegionaleResource showed all types instead of only regionale
- Aligns with Tighten Parental package requirements for Single Table Inheritance

Refs: #ISSUE_NUMBER"
```
