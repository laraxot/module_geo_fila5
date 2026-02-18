---
name: create-filament-page
description: Create Filament pages (List, Create, Edit, View, custom) using XotBase wrappers. Use when adding new pages to Filament resources or creating standalone admin pages.
---

# Create Filament Page - XotBase Patterns

Create Filament resource pages and standalone pages with mandatory XotBase extensions.

## When to Use

- Adding CRUD pages to a Filament resource
- Creating custom admin panel pages
- Creating dashboard widgets
- When the user asks to "create page" or "add page"

## Page Templates

### ListRecords Page

```php
<?php

declare(strict_types=1);

namespace Modules\{Module}\Filament\Resources\{Model}Resource\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\{Module}\Filament\Resources\{Model}Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;

class List{Models} extends XotBaseListRecords
{
    protected static string $resource = {Model}Resource::class;

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('id')->sortable(),
            TextColumn::make('name')->searchable(),
            TextColumn::make('created_at')->dateTime(),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
```

### CreateRecord Page

```php
<?php

declare(strict_types=1);

namespace Modules\{Module}\Filament\Resources\{Model}Resource\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;
use Modules\{Module}\Filament\Resources\{Model}Resource;

class Create{Model} extends XotBaseCreateRecord
{
    protected static string $resource = {Model}Resource::class;
}
```

### EditRecord Page

```php
<?php

declare(strict_types=1);

namespace Modules\{Module}\Filament\Resources\{Model}Resource\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
use Modules\{Module}\Filament\Resources\{Model}Resource;

class Edit{Model} extends XotBaseEditRecord
{
    protected static string $resource = {Model}Resource::class;
}
```

### ViewRecord Page

```php
<?php

declare(strict_types=1);

namespace Modules\{Module}\Filament\Resources\{Model}Resource\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Modules\{Module}\Filament\Resources\{Model}Resource;

class View{Model} extends XotBaseViewRecord
{
    protected static string $resource = {Model}Resource::class;
}
```

### Custom Standalone Page

```php
<?php

declare(strict_types=1);

namespace Modules\{Module}\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;

class {PageName} extends XotBasePage
{
    // NO navigationIcon, title, navigationLabel - auto-managed!

    protected static string $view = '{module}::filament.pages.{page-name}';
}
```

### Widget

```php
<?php

declare(strict_types=1);

namespace Modules\{Module}\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;

class {Widget}Widget extends XotBaseWidget
{
    protected static string $view = '{module}::filament.widgets.{widget-name}';
}
```

### RelationManager

```php
<?php

declare(strict_types=1);

namespace Modules\{Module}\Filament\Resources\{Model}Resource\RelationManagers;

use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class {Related}RelationManager extends XotBaseRelationManager
{
    protected static string $relationship = '{relationship}';
}
```

## CRITICAL REMINDERS

1. **NEVER** use `navigationIcon`, `title`, `navigationLabel` in pages
2. **Table methods** (getTableColumns, etc.) go in List pages ONLY
3. **Form schema** goes in Resource class ONLY
4. **NO hardcoded labels** - translations are automatic
5. Use `TextColumn` with `->badge()` instead of deprecated `BadgeColumn`

## After Creating

1. Register pages in the Resource's `getPages()` method
2. Create translation file in `lang/it/`
3. Run PHPStan and Pint
