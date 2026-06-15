---
title: "PHPStan Error Resolution Patterns"
type: pattern
tags: [phpstan, type-safety, laravel, eloquent]
related:
  - "../memories/phpstan-modules-inventory.md"
  - "../../laravel/Modules/Ptv/docs/phpstan-analysis-2026-06-15.md"
---

# PHPStan Error Resolution Patterns

## Overview

This guide documents common PHPStan errors found across Laravel modules and proven resolution patterns. Used in sessions S347-S350+ for systematic error remediation.

## Error Category 1: method.nonObject (Property/Method on Nullable)

### Problem
```php
// Error: Access to property on mixed|null value
$value = $model->relationship?->property;  // OK
$value = $model->relationship->property;   // ❌ Error if relationship is nullable
```

### Symptoms
- "Call to method X on mixed"
- "Access to property X on mixed"
- PHPStan identifier: `method.nonObject`

### Root Causes
1. **Nullable Relationships:** belongsTo/hasOne not type-hinted as non-null
2. **Optional Properties:** Properties declared without definite types
3. **Mixed Types:** Property used in multiple contexts with different types

### Solutions

#### Solution 1.1: Add Null Check
```php
// ❌ Before
$amount = $scheda->budgetImportato->importo;

// ✅ After
if ($budgetImportato = $scheda->budgetImportato) {
    $amount = $budgetImportato->importo;
}
```

#### Solution 1.2: Use Safe Navigation
```php
// ✅ PHP 8.0+ optional chaining
$amount = $scheda->budgetImportato?->importo ?? 0;

// ✅ Laravel helper
$amount = optional($scheda->budgetImportato)->importo;
```

#### Solution 1.3: Type Hint Properties
```php
// ❌ Before
class BaseScheda
{
    public $budgetImportato;  // Type unknown
}

// ✅ After
class BaseScheda
{
    public ?BudgetImportato $budgetImportato = null;
}
```

#### Solution 1.4: Assert Type
```php
// When you know type at runtime
$budgetImportato = $scheda->budgetImportato;
Assert::isInstanceOf($budgetImportato, BudgetImportato::class);
$amount = $budgetImportato->importo;  // Now safe
```

### Best Practice
- Prefer **1.2 (safe navigation)** for optional properties
- Use **1.1 (null check)** in business logic where null has meaning
- Use **1.3 (type hints)** to prevent the issue upstream
- Use **1.4 (assertions)** in actions/services where type is guaranteed

---

## Error Category 2: argument.type (Type Mismatch on Parameters)

### Problem
```php
// Error: string given, class-string<Model> expected
hasMany($className)  // className is string, needs class-string verification
```

### Symptoms
- "Argument #1 expects class-string<X>, string given"
- "Expects array<string, mixed>, array given"
- PHPStan identifier: `argument.type`

### Root Causes
1. **String vs class-string:** Class name as string without type guarantee
2. **Spatie Macros:** Dynamic methods (belongsToManyX, hasMany) not fully typed
3. **Array Type Mismatch:** `array<string>` vs `array<string, mixed>`

### Solutions

#### Solution 2.1: Type Cast String to class-string
```php
// ❌ Before
$this->hasMany($modelClass);  // $modelClass is string

// ✅ After
Assert::classExists($modelClass);
/** @var class-string<Model> $modelClass */
$this->hasMany($modelClass);
```

#### Solution 2.2: Validate Class Before Use
```php
// ✅ With assertion
$userClass = XotData::make()->getUserClass();
Assert::subclassOf($userClass, Model::class);
return $this->belongsToMany($userClass);
```

#### Solution 2.3: Convert Array Type
```php
// ❌ Before: array<string> given, array<string, mixed> expected
return $this->sendError('Error', $validator->errors()->all());

// ✅ After: Convert to associative array
return $this->sendError('Error', $validator->errors()->toArray());
```

#### Solution 2.4: Add Type Assertion via PHPDoc
```php
// ✅ Using PHPDoc for type narrowing
/** @var array<int, mixed> $blocks */
$blocks = Arr::map($files, function($file) { ... });

return ComponentFileData::collection($blocks);
```

### Best Practice
- **2.1** for single string → class-string conversions
- **2.2** for business-critical class validations
- **2.3** for array method return type fixes
- **2.4** for collection/mapping operations

---

## Error Category 3: class.notFound (Missing/Optional Classes)

### Problem
```php
// Error: Class Modules\Comment\Support\CommentatorProperties not found
public function properties(): CommentatorProperties { ... }
```

### Symptoms
- "Class X not found"
- References optional/external module classes
- PHPStan identifier: `class.notFound`

### Root Causes
1. **Optional Dependencies:** Module references classes from not-installed modules
2. **External Interfaces:** Contracts from package/bundle not loaded
3. **Typos:** Class name misspelled

### Solutions

#### Solution 3.1: Exclude Optional Module References
```yaml
# phpstan.neon
ignoreErrors:
  - identifier: class.notFound
    message: '#Modules\\(Cms|Comment|Geo)\\#'
```

#### Solution 3.2: Move to Optional Traits
```php
// ❌ Before: Always referenced
interface HasComment {
    public function commentatorProperties(): CommentatorProperties;
}

// ✅ After: Conditional trait
trait CanBeCommented {
    public function commentatorProperties(): ?CommentatorProperties { ... }
}
```

#### Solution 3.3: Use Interface Fallback
```php
// ✅ Reference interface instead of class
interface CommentableContract extends Model { }

// User implements if Comment module is available
class User extends Model implements CommentableContract { }
```

### Best Practice
- **3.1** for optional module classes (quick fix)
- **3.2** for conditional functionality
- **3.3** for defining stable contracts

---

## Error Category 4: array.duplicateKey (Duplicate Array Keys)

### Problem
```php
// Error: Array has 2 duplicate keys
[
    'name' => 'First',
    'label' => 'Second',
    'name' => 'Duplicate!',  // ❌ Duplicate key
]
```

### Symptoms
- "Array has N duplicate keys with value 'X'"
- Usually in translation files or configuration arrays
- PHPStan identifier: `array.duplicateKey`

### Root Causes
1. **Copy-Paste:** Template duplication without cleanup
2. **Merge Conflicts:** Unresolved version merge
3. **Refactoring:** Old and new key definitions coexist

### Solutions

#### Solution 4.1: Remove Duplicate (Keep Better Version)
```php
// ❌ Before
[
    'copy_from_last_year' => 'Old text',
    'populate_year' => 'Old',
    'copy_from_last_year' => 'Better text',  // ← Keep this
    'populate_year' => 'Better',
]

// ✅ After
[
    'copy_from_last_year' => 'Better text',
    'populate_year' => 'Better',
]
```

#### Solution 4.2: Merge if Both Are Needed
```php
// ✅ If both are needed for different purposes
[
    'copy_from_last_year_short' => 'Copy',
    'copy_from_last_year_long' => 'Copy from previous year',
    'populate_year_short' => 'Populate',
    'populate_year_long' => 'Populate year with default values',
]
```

### Best Practice
- Always **remove duplicates** in translation files
- Keep **more descriptive/complete version**
- In configs, use **contextual key names** to avoid collisions

---

## Error Category 5: property.notFound (Accessing Undefined Properties)

### Problem
```php
// Error: Access to undefined property
$model->nonexistent_property;
```

### Solutions

#### Solution 5.1: Check Model Definition
```php
// ✅ Add property to model
class BaseScheda extends Model
{
    protected $fillable = ['budget_importato', ...];
    public ?int $budget_importato = null;
}
```

#### Solution 5.2: Use Accessor
```php
// ✅ Define accessor if computed property
public function budgetImportato(): Attribute
{
    return new Attribute(
        get: fn() => $this->getAttribute('budget_importato'),
    );
}
```

---

## Quick Reference: Error → Fix Mapping

| Error Type | Primary Cause | Quick Fix | Effort |
|-----------|---|---|---|
| `method.nonObject` | Nullable property access | Add null check / Optional chaining | ⭐ |
| `argument.type` | Type mismatch | Add assertion / Type cast | ⭐⭐ |
| `class.notFound` | Optional module | Exclude in phpstan.neon | ⭐ |
| `array.duplicateKey` | Duplicate keys | Remove older version | ⭐ |
| `property.notFound` | Missing property | Add to model / Accessor | ⭐⭐ |
| `return.type` | Return type mismatch | Update PHPDoc / Implementation | ⭐⭐⭐ |

---

## Workflow for Module Analysis

### Step 1: Categorize Errors
```bash
# Extract error types
grep "🪪" phpstan-output.log | cut -d' ' -f6 | sort | uniq -c
```

### Step 2: Group by File
```bash
# See error distribution
grep "✏️" phpstan-output.log | cut -d'/' -f2-4 | sort | uniq -c
```

### Step 3: Apply Patterns
- Start with **quick fixes** (category 3, 4)
- Move to **common patterns** (category 1, 2)
- Defer **architecture changes** (category 5, return.type)

### Step 4: Verify & Document
```bash
# Verify after fixes
./vendor/bin/phpstan analyse Modules/<Module> --memory-limit=4G
```

### Step 5: Document in Module
- Create `Ptv/docs/phpstan-analysis-[DATE].md`
- Document patterns found and fixes applied
- Reference this guide for future maintainers

---

## Real-World Example: Ptv Module

**Scenario:** 133 PHPStan errors in Ptv module

**Session Progress:**
- **T1:** Identified 145 errors (12 were duplicates)
- **T2:** Applied Solution 4.1 → 133 errors (12 duplicates removed)
- **T3:** Created pattern documentation → Ptv/docs/
- **T4:** Created architecture overview for maintainers

**Remaining Work:**
- Apply Solutions 1.1, 1.2 to ~45 `method.nonObject` errors
- Apply Solutions 2.1, 2.2 to ~30 `argument.type` errors
- Apply Solutions 3.1 to ~8 `class.notFound` errors

---

## Error Category N: match.alwaysFalse in Traits

### Problem
```php
// In trait — PHPStan analyzes each arm in context of each concrete class
return match (static::class) {
    Asz00k1::class => 'asz2kd',  // ❌ always false when analyzing Rep00f
    Qua00f::class => 'qua2kd',   // ❌ always false when analyzing Rep00f
    Rep00f::class => 'rep2kd',   // ✅ only this is true for Rep00f
    default => 'dal',
};
```

### Symptoms
- "Match arm comparison between class-string<static(X)> and 'Y' is always false"
- PHPStan identifier: `match.alwaysFalse`
- Multiplied by N models × M arms = many errors

### Root Cause
PHPStan analyzes traits in the context of **each concrete class** that uses them. In context of `Rep00f`, `static::class` is `class-string<Rep00f>`, so comparing to `Asz00k1::class` is always false.

### Solution: Polymorphic Override (PREFERRED)
```php
// ✅ Trait defines only the contract and shared logic
trait CommonScope {
    abstract public function rangeFromField(): string;
    abstract public function rangeToField(): string;
}

// ✅ Each model extends the module base and provides its own value
class Rep00f extends BaseDateRangeModel {
    public function rangeFromField(): string { return 'rep2kd'; }
    public function rangeToField(): string { return 'rep2ka'; }
}
```

### Why This Pattern
- OCP: new models don't require trait changes
- LSP: each class describes itself
- 100% PHPStan-clean at level max
- No `@phpstan-ignore` needed

### Anti-patterns (NEVER use)
- `match(static::class)` in traits → match.alwaysFalse
- `property_exists($this, 'x')` on non-nullable → function.alreadyNarrowedType
- `$this->staticProp` → staticProperty.nonStaticAccess

---

## Key Principles

1. **Fix from Root:** Address the cause, not the symptom
2. **Type Safety:** Use Webmozart\Assert for runtime validation
3. **Documentation:** Record patterns in module docs/
4. **Gradual Remediation:** Fix low-hanging fruit first
5. **Maintainability:** Document why fix was needed, not just that it was applied
6. **Polymorphism over Branching:** Use method overrides in models, not match/switch in traits
7. **Module BaseModel:** MAI `extends Model` direttamente — usare `BaseModel` del modulo (→ `BaseDateRangeModel` per modelli con date range)

---

**Last Updated:** 2026-06-15  
**Usage:** Reference for Ptv, User, UI, Sigma, and other module remediation  
**Applicable Level:** PHPStan max (level 9)
