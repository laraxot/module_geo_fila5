# PHPStan Rules and Best Practices for the Rating Module

This document outlines the key patterns and practices used to ensure the Rating module is compliant with PHPStan level 9.

## Namespace Structure

The correct namespace structure for this module is:

```php
namespace Modules\Rating\<subdirectory>;
```

Note that we DO NOT use `App` in the namespace path, even though files may physically be in the `app` directory.

```php
// CORRECT
namespace Modules\Rating\Datas;
namespace Modules\Rating\Filament\Resources;
namespace Modules\Rating\Models;

// INCORRECT - avoid including 'App' segment
namespace Modules\Rating\App\Datas;
```

## Data Transfer Objects

We use Spatie's Laravel Data package for our DTOs, located in the `Modules\Rating\Datas` directory:

```php
namespace Modules\Rating\Datas;

use Spatie\LaravelData\Data;

class RatingData extends Data
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly bool $disabled = false,
        // other properties...
    ) {
    }
    
    // Factory method with proper type checking
    public static function fromArray(array $data): self
    {
        return new self(
            // Type-safe string handling
            title: is_string($data['title'] ?? '') 
                ? ($data['title'] ?? '') 
                : (is_scalar($data['title'] ?? '') ? (string)($data['title'] ?? '') : ''),
            // other properties...
        );
    }
}
```

## QueueableActions vs Services

We prefer Spatie's QueueableAction pattern over traditional Services:

```php
namespace Modules\Rating\Actions;

use Spatie\QueueableAction\QueueableAction;

class CreateRatingAction
{
    use QueueableAction;
    
    public function execute(RatingData $data): Rating
    {
        // Implementation
    }
}
```

Usage example:

```php
$action = app(CreateRatingAction::class);
$rating = $action->execute($ratingData);

// Or queued execution
$action->onQueue('ratings')->execute($ratingData);
```

## Enum Implementation

Enums should be placed in the `Modules\Rating\Enums` namespace:

```php
namespace Modules\Rating\Enums;

enum SupportedLocale: string
{
    case IT = 'it';
    case EN = 'en';
    
    // Provides human-readable labels
    public function getLabel(): string {...}
    
    // Safely converts string values to enum instances
    public static function fromString(string $value): self {...}
}
```

## Filament Forms and Tables

When implementing Filament Resources:

1. Forms must have properly keyed arrays:

```php
// CORRECT - using string keys
public static function getFormSchema(): array
{
    return [
        'title' => TextInput::make('title')->required(),
        'description' => TextArea::make('description'),
    ];
}
```

2. Similar rules apply to table columns and actions:

```php
public function getListTableColumns(): array
{
    return [
        'id' => TextColumn::make('id')->sortable(),
        'title' => TextColumn::make('title')->searchable(),
    ];
}

public function getTableActions(): array
{
    return [
        'edit' => EditAction::make(),
        'delete' => DeleteAction::make(),
    ];
}
```

## Type Safety in Mixed Contexts

When handling mixed types or user input, always apply proper type checking:

```php
// AVOID direct casting without checking
$title = (string)$data['title']; // PHPStan error: Cannot cast mixed to string

// RECOMMENDED approach
$title = is_string($data['title']) ? $data['title'] : (is_scalar($data['title']) ? (string)$data['title'] : '');
```

## Handling Options Arrays in Filament Components

When providing options to components that expect specific formats:

```php
RadioImage::make('view')
    ->options(is_array($options) 
        ? array_map(fn($value) => is_scalar($value) ? (string)$value : '', $options) 
        : [])
```

## Relationship Typing

For MorphToMany and other complex relationships, ensure complete type information is provided:

```php
/**
 * @return MorphToMany<Rating, Rating|\Illuminate\Database\Eloquent\Model>
 */
public function ratings(): MorphToMany;
```

## Common Issues and Solutions

| Common PHPStan Error | Solution |
|----------------------|----------|
| Cannot cast mixed to string | Check if the value is a string or scalar first |
| Cannot cast mixed to int | Use `is_numeric()` before casting |
| Undefined property access | Always check if the property exists with `isset()` or `property_exists()` |
| Missing generics in relations | Specify all template types in PHPDoc annotations |
| Trait is used zero times | If needed, create a mock implementation for PHPStan analysis |
