---
name: filament-resource-standard
description: Standards and protocols for creating and modifying Filament resources in Laraxot.
---

# Filament Resource Standard

This skill encodes the mandatory architectural patterns for Filament resources within the PTVX/Laraxot framework.

## 🚨 Critical Rules

### 1. NEVER Extend Filament Directly
Always use the `XotBase` wrappers located in `Modules\Xot\Filament`.

| Filament Class | XotBase Class |
|----------------|---------------|
| `Filament\Resources\Resource` | `Modules\Xot\Filament\Resources\XotBaseResource` |
| `Filament\Resources\Pages\CreateRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord` |
| `Filament\Resources\Pages\EditRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord` |
| `Filament\Resources\Pages\ListRecords` | `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords` |

### 2. Method Placement (Rule #7)
- **Resource Class**: Must NOT contain `getTableColumns()`, `getTableFilters()`, `getTableActions()`, or `getTableBulkActions()`.
- **List Page**: MUST contain the table configuration methods (`getTableColumns`, etc.).
- **Resource Class**: Should contain `getFormSchema()`.

### 3. Automatic Translations (Rule #5)
NEVER use `->label()`, `->placeholder()`, or `->tooltip()` with hardcoded strings. Translations are handled automatically by the infrastructure if the field name matches the translation key.

## 🛠️ Procedural Workflow

### Creating a New Resource
1. Create the Resource class extending `XotBaseResource`.
2. Implement `getFormSchema()` in the Resource class.
3. Create the List page extending `XotBaseListRecords`.
4. Implement `getTableColumns()` and other table configuration methods in the List page.
5. Verify with PHPStan Level 10.

### Verifying an Existing Resource
1. Check that it doesn't extend `Filament\Resources\Resource`.
2. Check that table methods are NOT in the Resource class.
3. Check for hardcoded `->label()`.
