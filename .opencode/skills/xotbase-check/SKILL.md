---
name: xotbase-check
description: Verify all Filament classes in a module extend XotBase wrappers instead of Filament directly. Automatically finds and reports violations with exact fix instructions.
---

# XotBase Check - Extension Compliance

Verify and fix Filament class extension compliance across modules.

## When to Use

- When auditing a module for compliance
- After creating new Filament resources or pages
- When the user asks to "check XotBase" or "verify extensions"
- As part of a module audit workflow

## Quick Check Commands

```bash
cd laravel

# Check for direct Filament Resource extensions
grep -rn "extends.*Filament\\\\Resources\\\\Resource[^s]" Modules/{Module}/app/

# Check for direct Page extensions
grep -rn "extends.*Filament\\\\Resources\\\\Pages\\\\CreateRecord" Modules/{Module}/app/
grep -rn "extends.*Filament\\\\Resources\\\\Pages\\\\EditRecord" Modules/{Module}/app/
grep -rn "extends.*Filament\\\\Resources\\\\Pages\\\\ListRecords" Modules/{Module}/app/
grep -rn "extends.*Filament\\\\Resources\\\\Pages\\\\ViewRecord" Modules/{Module}/app/

# Check for direct Page extensions
grep -rn "extends.*Filament\\\\Pages\\\\Page" Modules/{Module}/app/

# Check for direct Widget extensions
grep -rn "extends.*Filament\\\\Widgets" Modules/{Module}/app/

# Check for direct RelationManager extensions
grep -rn "extends.*Filament\\\\Resources\\\\RelationManagers\\\\RelationManager" Modules/{Module}/app/

# Check ALL modules at once
grep -rn "extends.*Filament\\\\Resources\\\\Resource[^s]" Modules/*/app/
grep -rn "extends.*Filament\\\\Resources\\\\Pages" Modules/*/app/ | grep -v XotBase
grep -rn "extends.*Filament\\\\Pages\\\\Page" Modules/*/app/ | grep -v XotBase
```

## Complete Mapping Table

| Direct Extension (WRONG) | XotBase Wrapper (CORRECT) |
|---|---|
| `Filament\Resources\Resource` | `Modules\Xot\Filament\Resources\XotBaseResource` |
| `Filament\Resources\Pages\CreateRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord` |
| `Filament\Resources\Pages\EditRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord` |
| `Filament\Resources\Pages\ListRecords` | `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords` |
| `Filament\Resources\Pages\ViewRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord` |
| `Filament\Resources\Pages\ManageRecords` | `Modules\Xot\Filament\Resources\Pages\XotBaseManageRecords` |
| `Filament\Pages\Page` | `Modules\Xot\Filament\Pages\XotBasePage` |
| `Filament\Widgets\Widget` | `Modules\Xot\Filament\Widgets\XotBaseWidget` |
| `Filament\Widgets\ChartWidget` | `Modules\Xot\Filament\Widgets\XotBaseChartWidget` |
| `Filament\Resources\RelationManagers\RelationManager` | `Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager` |
| `Filament\Resources\Pages\ManageRelatedRecords` | `Modules\Xot\Filament\Resources\XotBaseResource\Pages\XotBaseManageRelatedRecords` |

## Fix Pattern

```php
// BEFORE (violation)
use Filament\Resources\Resource;
class MyResource extends Resource { ... }

// AFTER (compliant)
use Modules\Xot\Filament\Resources\XotBaseResource;
class MyResource extends XotBaseResource { ... }
```

## Additional Checks in XotBase Pages

- NO `navigationIcon` property in pages
- NO `title` property in pages
- NO `navigationLabel` property in pages
- NO `getTableColumns()` in Resource class (must be in List page)
- NO `->label()` hardcoded strings

## After Fixing

1. Update import statements
2. Change the extends class
3. Remove any properties that XotBase manages automatically
4. Run PHPStan to verify
5. Run Pint for formatting
