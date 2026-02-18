---
name: filament-resource
description: Create or modify Filament resources following Laraxot XotBase patterns. Use when creating new admin panel resources, editing resource pages, adding form fields or table columns. NEVER extend Filament classes directly.
---

# Filament Resource - Laraxot Pattern

Create and modify Filament resources using mandatory XotBase wrappers.

## When to Use

- Creating a new Filament resource for a module
- Adding form fields or table columns
- Creating List, Create, Edit, View pages
- Adding relation managers
- Modifying existing resources

## ABSOLUTE RULES

### Rule 1: NEVER Extend Filament Directly

| Filament Class | XotBase Wrapper (MUST USE) |
|---|---|
| `Filament\Resources\Resource` | `Modules\Xot\Filament\Resources\XotBaseResource` |
| `Filament\Resources\Pages\CreateRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord` |
| `Filament\Resources\Pages\EditRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord` |
| `Filament\Resources\Pages\ListRecords` | `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords` |
| `Filament\Resources\Pages\ViewRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord` |
| `Filament\Pages\Page` | `Modules\Xot\Filament\Pages\XotBasePage` |
| `Filament\Widgets\Widget` | `Modules\Xot\Filament\Widgets\XotBaseWidget` |
| `Filament\Resources\RelationManagers\RelationManager` | `Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager` |

### Rule 2: NO Hardcoded Labels

```php
// WRONG - hardcoded translations
TextInput::make('name')->label('Nome')->placeholder('Inserisci nome')

// CORRECT - translations automatic via LangServiceProvider
TextInput::make('name')
```

Translation keys follow pattern: `{module}::resource.fields.{field_name}.{type}`

### Rule 3: Table Methods in List Pages ONLY

```php
// WRONG - in Resource class
class MyResource extends XotBaseResource
{
    public static function getTableColumns(): array { ... } // NO!
}

// CORRECT - in ListRecords page
class ListMyRecords extends XotBaseListRecords
{
    protected function getTableColumns(): array { ... }
    protected function getTableFilters(): array { ... }
    protected function getTableActions(): array { ... }
    protected function getTableBulkActions(): array { ... }
}
```

### Rule 4: Form Schema in Resource

```php
// Resource only has getFormSchema()
class MyResource extends XotBaseResource
{
    protected static ?string $model = MyModel::class;

    public static function getFormSchema(): array
    {
        return [
            // INDEXED array, not associative
            TextInput::make('name')->required(),
            TextInput::make('email')->email(),
            Select::make('status'),
        ];
    }
}
```

### Rule 5: XotBasePage Restrictions

NO `navigationIcon`, `title`, `navigationLabel` in pages - these are auto-managed.

## Template: New Resource

```php
<?php

declare(strict_types=1);

namespace Modules\{Module}\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\{Module}\Models\{Model};
use Filament\Forms\Components\TextInput;

class {Model}Resource extends XotBaseResource
{
    protected static ?string $model = {Model}::class;

    public static function getFormSchema(): array
    {
        return [
            TextInput::make('name')->required(),
        ];
    }
}
```

## Template: List Page

```php
<?php

declare(strict_types=1);

namespace Modules\{Module}\Filament\Resources\{Model}Resource\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\{Module}\Filament\Resources\{Model}Resource;

class List{Models} extends XotBaseListRecords
{
    protected static string $resource = {Model}Resource::class;
}
```

## After Creating

1. Create translation file: `lang/it/{resource_name}.php`
2. Run PHPStan: `cd laravel && ./vendor/bin/phpstan analyse Modules/{Module} --memory-limit=-1`
3. Run Pint: `cd laravel && vendor/bin/pint --dirty`
