# Rating Hydration Pattern in IndennitaResponsabilita Module

This document outlines the correct pattern for hydrating Filament forms with `Rating` data, especially when dealing with `schemaless-attributes` and polymorphic relationships. This pattern ensures that ratings configured for a specific year (stored in `extra_attributes` of the `Rating` model) are correctly loaded and associated with the `IndennitaResponsabilita` record, while preserving existing pivot values.

## 🎯 The Problem

A common mistake is to attempt to filter ratings on the pivot table using `wherePivot('anno', $year)`. This is incorrect because `anno` (year) is stored in the `extra_attributes` JSON column of the `Rating` model itself, not as a direct column on the pivot table (`rating_morph_table`).

Attempting to use `wherePivot('anno', ...)` will result in:
- SQL errors (column `anno` not found on pivot table)
- Incorrect data retrieval (if a similarly named column accidentally exists)
- Misunderstanding of the `schemaless-attributes` architecture.

## ✅ The Correct Pattern

To correctly hydrate ratings for a specific year (`anno`) associated with an `IndennitaResponsabilita` record, follow these steps:

1.  **Query the `Rating` model by `anno` using `withExtraAttributes()`**: First, retrieve all `Rating` configurations that match the desired `anno` from the `Rating` model itself.
2.  **Synchronize these ratings to the record's pivot table**: Use `syncWithoutDetaching()` to ensure that all `Rating` records found in step 1 are associated with the `IndennitaResponsabilita` record. This is crucial for form hydration as it guarantees the pivot entries exist. `syncWithoutDetaching()` is important here because it adds new relationships without removing existing ones, preserving any `value` or other pivot data already set.
3.  **Fetch the freshly hydrated relationship data**: Retrieve the ratings associated with the current `IndennitaResponsabilita` record, filtering them to include only those relevant for the `anno` (obtained in step 1), and ensuring their `pivot` data is loaded.

### Example Implementation (`initializeFormData` method)

```php
use Modules\IndennitaResponsabilita\Models\Rating;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;

// ... inside initializeFormData() ...

/** @var IndennitaResponsabilita $rec */
$rec = $this->record;
$modelData = $rec->attributesToArray();

// 1. Get all Rating configurations for the current year using schemaless attributes.
// The 'anno' attribute is stored in the `extra_attributes` JSON column of the Rating model.
$ratingsForYear = Rating::withExtraAttributes(['anno' => $rec->anno])->get();

// 2. Ensure these ratings are attached to the current record's pivot table.
// syncWithoutDetaching ensures existing pivot data (like 'value') is preserved
// and new ratings for the year are attached without detaching others.
$rec->ratings()->syncWithoutDetaching($ratingsForYear->pluck('id'));

// 3. Get the fresh, hydrated relationship data for the current year's ratings.
// Use wherePivotIn to filter by the relevant rating IDs for the year,
// ensuring 'pivot' data (like 'value') is correctly loaded.
$hydratedRatings = $rec->ratings()->wherePivotIn('rating_id', $ratingsForYear->pluck('id'))->get();

/** @var array<int|string, array<string, mixed>> $ratingsKeyed */
$ratingsKeyed = $hydratedRatings->keyBy('id')->toArray();

// ... continue with pre-calculation logic using $ratingsKeyed ...

$modelData['ratings'] = $ratingsKeyed;
$this->form->fill($modelData);
```

### Example Implementation (`getFormSchema` method)

The same logic should be applied when building the form schema to ensure the correct set of ratings for the year is displayed and correctly associated with the record.

```php
use Modules\IndennitaResponsabilita\Models\Rating;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;

// ... inside getFormSchema() ...

/** @var IndennitaResponsabilita $currRecord */
$currRecord = $this->record;

// 1. Get all Rating configurations for the current year.
$ratingsForYear = Rating::withExtraAttributes(['anno' => $currRecord->anno])->get();

// 2. Fetch the associated ratings for the current record, filtered by those for the current year.
// This ensures that only relevant ratings are displayed in the form.
$ratings = $currRecord->ratings()->wherePivotIn('rating_id', $ratingsForYear->pluck('id'))->get();

// ... continue building schema using $ratings ...
```

## 🔗 Related Documentation

-   [Spatie Laravel Schemaless Attributes - Guida Completa PTVX](../../../docs/claude/schemaless-attributes.md)
-   [Rating Module - Schemaless Attributes Usage (Rating Module Docs)](../../Rating/docs/schemaless-attributes.md)
-   [Filament Forms Overview](https://filamentphp.com/docs/5.x/forms/overview#field-hydration) - General Filament form hydration patterns.
