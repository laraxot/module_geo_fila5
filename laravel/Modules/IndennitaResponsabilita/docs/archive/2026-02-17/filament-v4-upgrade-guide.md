# Filament v4 Upgrade Guide - IndennitaResponsabilita Module

## Overview
This document outlines the specific changes needed to upgrade the IndennitaResponsabilita module from Filament v3 to v4.

## High-Impact Changes Implemented

### 1. File Visibility Changes
Files are now `private` by default instead of `public`.

**Files Affected:**
- `FileUpload` form fields
- `ImageColumn` table columns
- `ImageEntry` infolist entries

**Solution Applied:**
```php
// In AppServiceProvider boot()
FileUpload::configureUsing(fn (FileUpload $fileUpload) => $fileUpload
    ->visibility('public'));
ImageColumn::configureUsing(fn (ImageColumn $imageColumn) => $imageColumn
    ->visibility('public'));
ImageEntry::configureUsing(fn (ImageEntry $imageEntry) => $imageEntry
    ->visibility('public'));
```

### 2. Grid/Section Layout Changes
Layout components no longer span full width by default.

**Files Affected:**
- All Resource forms using `Grid` and `Section`
- All infolists using layout components

**Solution Applied:**
```php
// All getFormSchema() methods now use:
Section::make('Title')->columnSpanFull()->schema([...])
Grid::make(columns)->schema([...])
```

### 3. Table Filters Deferred by Default
Filters now require user interaction before applying.

**Files Affected:**
- `ListImportiCategorias`
- `ListLettFs`
- `ListLettIs`

**Solution Applied:**
```php
// In AppServiceProvider boot()
Table::configureUsing(fn (Table $table) => $table
    ->deferFilters(false));
```

### 4. unique() Validation Rule Change
Now ignores current record by default.

**Files Affected:**
- All forms with unique validation

**Solution Applied:**
```php
// In AppServiceProvider boot()
Field::configureUsing(fn (Field $field) => $field
    ->uniqueValidationIgnoresRecordByDefault(false));
```

### 5. Pagination Page Options
The 'all' option is not available by default.

**Files Affected:**
- All List pages

**Solution Applied:**
```php
// In AppServiceProvider boot()
Table::configureUsing(fn (Table $table) => $table
    ->paginationPageOptions([5, 10, 25, 50, 'all']));
```

## Medium-Impact Changes

### 1. Enum Field State
Enum fields now always return enum instances.

**Files Affected:**
- Any Select/CheckboxList/Radio fields using enums

**Code Pattern:**
```php
// Before: Mixed value/instance
// After: Always instance
Select::make('status')
    ->options(Status::class)
    ->afterStateUpdated(function (?Status $state) {
        // $state is always Status instance or null
    });
```

### 2. URL Parameter Names
Several URL parameters have been renamed.

| Old Parameter | New Parameter |
|---------------|-------------|
| `activeRelationManager` | `relation` |
| `activeTab` | `tab` |
| `isTableReordering` | `reordering` |
| `tableFilters` | `filters` |

### 3. Radio Component inline() Method
Now only affects radio buttons, not labels.

**Solution Applied:**
```php
// For old behavior (radio + label inline)
Radio::make()->inline()->inlineLabel()

// For new behavior (only radio inline)
Radio::make()->inline()
```

## Low-Impact Changes

### 1. Method Signature Changes
Several `make()` method signatures changed.

**Updated Signatures:**
```php
// Before:
public static function make(string $name): static

// After:
public static function make(?string $name = null): static
```

**Alternative Pattern:**
```php
// Use getDefaultName() instead of overriding make()
public static function getDefaultName(): ?string
{
    return 'default_name';
}

// Use setUp() for default configuration
protected function setUp(): void
{
    parent::setUp();
    $this->label('Default Label');
}
```

### 2. Import/Export Job Changes
- Jobs now retry 3 times with 60s backoff
- No Login event fired during jobs

### 3. Table Default Key Sorting
Tables now sort by primary key by default.

**Solution Applied:**
```php
// In AppServiceProvider boot()
Table::configureUsing(fn (Table $table) => $table
    ->defaultKeySort(false));
```

## Migration Checklist

### ✅ Completed
- [x] File visibility configured for public access
- [x] Grid/Section components using columnSpanFull()
- [x] Table filters behavior configured
- [x] unique() validation adjusted
- [x] Pagination options configured
- [x] Enum field state handling updated
- [k] URL parameter names updated
- [x] Radio component behavior fixed
- [ ] Method signatures updated
- [ ] Job retry behavior noted
- [ ] Table key sorting configured

### 📋 In Progress
- [ ] Check for custom Field/Column/Entry extensions
- [ ] Verify authorization method overrides
- [ ] Test enum field functionality
- [ ] Validate filter behavior

## Code Examples

### Before (v3)
```php
public static function form(Form $form): Form
{
    return $form->schema([
        Section::make('Details')->schema([
            // Full width by default
        ]),
    ]);
}

// Unique validation
TextInput::make('email')->unique()
```

### After (v4)
```php
public static function getFormSchema(): array
{
    return [
        'details_section' => Section::make('Details')
            ->columnSpanFull()
            ->schema([
                // Explicit full width
            ]),
    ];
}

// Unique validation (ignores record by default)
TextInput::make('email')->unique(ignoreRecord: true)
```

## Resources

- [Official Filament v4 Upgrade Guide](https://filamentphp.com/docs/4.x/upgrade-guide)
- [PTVX Architecture Rules](../architecture/filament-rules.md)
- [Module Architecture Overview](../architecture-overview.md)

## Next Steps

1. Run automated upgrade script if not already done
2. Test all forms and tables
3. Verify file upload functionality
4. Check enum field behavior in forms
5. Validate filter functionality
6. Test pagination behavior