# PHPStan Filament 5 - tableFilters Property Issue

**Status**: ⏳ Pending Analysis  
**Date**: 2026-06-18  
**Issue Type**: `property.notFound`  
**Severity**: Medium (functionality works, but type checking fails)

## Problem

Files use `$this->tableFilters` to access filter values applied to Filament tables:
- `CondizioniLavoroAdmsTable.php:41` — Pass to ReplicateIndennita action
- `CondizioniLavorosTable.php:32, 41` — Pass to MakePdf and ReplicateIndennita actions

### Code Pattern
```php
$tableFilters = is_array($this->tableFilters) ? $this->tableFilters : [];
app(ReplicateIndennita::class)->execute($tableFilters);
```

### Root Cause
- `$this->tableFilters` is a **public property of Livewire component**, not declared in class
- PHPStan cannot infer its type (appears as `mixed` or undefined)
- Property is provided by base class `XotBaseResourceTable` which inherits from Filament's Table behavior

## Solution Options

### Option A: Add PHPDoc Type Hint (RECOMMENDED)
Define property as PHPDoc above usage:
```php
/** @var array<string, mixed>|null $tableFilters */
$tableFilters = $this->tableFilters ?? [];
```

**Pros**: 
- ✅ Preserves functionality
- ✅ Tells PHPStan about expected type
- ✅ Minimal code change
- ✅ Follows Xot module pattern (see ExportXlsAction)

**Cons**: 
- Doesn't declare property formally in class

### Option B: Declare Property in Class
```php
class CondizioniLavoroAdmsTable extends XotBaseResourceTable
{
    /** @var array<string, mixed>|null */
    public $tableFilters;
}
```

**Pros**: 
- ✅ Formal property declaration
- ✅ IDE autocomplete

**Cons**: 
- ✗ May conflict with parent class property
- ✗ Redundant if parent already defines it

### Option C: Use Xot Helper Method (if available)
Check if `XotBaseResourceTable` provides accessor method for filters.

**Status**: Need to investigate Xot base class

## Relationship to Xot Module

The property is used throughout Xot for export functionality:
- `ExportXlsAction.php` — accesses `$livewire->tableFilters`
- `ExportPdfAction.php` — accesses `$livewire->tableFilters`
- `ExportXlsTableAction.php` — accesses `$livewire->tableFilters`

Xot module already handles `tableFilters` in these actions, suggesting it's stable API.

## Recommended Fix

1. **Investigate** `XotBaseResourceTable` class structure
2. **Check** if property is documented in base class
3. **Apply** Option A (PHPDoc) as minimal fix
4. **Test** that PDF export and replicate functions still work with actual filter values
5. **Document** the Filament 5 API quirk in wiki

## Impact Assessment

**Functionality**: ✅ Works (filters passed correctly at runtime)  
**Type Safety**: ❌ PHPStan errors (property not typed)  
**User Impact**: None (feature works as designed)

## Related Files

- `Actions/MakePdf.php` — Receives tableFilters
- `Actions/ReplicateIndennita.php` — Receives tableFilters  
- Modules/Xot — Uses same pattern in export actions

## See Also

- `/docs/best-practices/filament-guide.md` — Filament patterns
- Modules/Xot/app/Filament/Actions/Header/ExportXlsAction.php — Reference implementation
