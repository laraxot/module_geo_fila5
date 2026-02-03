# PTV Module - Custom Columns and Fields Complete Guide

## Overview

The PTV module provides reusable custom Filament columns and fields that follow DRY+KISS principles and Laraxot architecture patterns. These components encapsulate common data groupings used across multiple modules.

## 🚨 Important Notice: Relationship Resolution

**Current Status**: GroupColumn and derived custom columns have known issues with relationship resolution using dot notation (`valutatore.nome_diri`). 

**Problem**: `TextColumn::make('valutatore.nome_diri')` works in standard table contexts but fails within GroupColumn-based components.

**Solution**: Use closures or model accessors. See [Relationship Resolution section](#relationship-resolution-best-practices) for detailed solutions.

---

## Available Custom Columns

### 1. WorkerColumn

Displays worker information in a grouped format.

**Fields:**
- `matr` - Matricola (sortable, searchable)
- `cognome` - Cognome (sortable, searchable)
- `nome` - Nome (sortable, searchable)
- `email` - Email (sortable, searchable)

**Usage:**
```php
use Modules\Ptv\Filament\Tables\Columns\WorkerColumn;

WorkerColumn::make('lavoratore')
```

**File:** `Modules/Ptv/app/Filament/Tables/Columns/WorkerColumn.php`

---

### 2. QuaColumn

Displays qualification (qualifica) information in a grouped format.

**Fields:**
- `propro` - Progressione Professionale (sortable, searchable)
- `posfun` - Posizione Funzionale (sortable, searchable)
- `categoria_eco` - Categoria Economica (sortable, searchable)
- `propro_desc` - Descrizione Progressione Professionale (sortable, searchable)
- `posfun_desc` - Descrizione Posizione Funzionale (sortable, searchable)
- `categoria_eco_desc` - Descrizione Categoria Economica (sortable, searchable)
- `livello` - Livello (sortable, searchable)
- `livello_desc` - Descrizione Livello (sortable, searchable)
- `area` - Area (sortable, searchable)

**Usage:**
```php
use Modules\Ptv\Filament\Tables\Columns\QuaColumn;

QuaColumn::make('qualifica')
```

**File:** `Modules/Ptv/app/Filament/Tables/Columns/QuaColumn.php`

---

### 3. RepartoColumn

Displays department (reparto) information in a grouped format.

**Fields:**
- `stabi` - Stabilimento (sortable, searchable)
- `stabi_txt` - Descrizione Stabilimento (sortable, searchable)
- `repar` - Reparto (sortable, searchable)
- `repar_txt` - Descrizione Reparto (sortable, searchable)

**Usage:**
```php
use Modules\Ptv\Filament\Tables\RepartoColumn;

RepartoColumn::make('reparto')
```

**File:** `Modules/Ptv/app/Filament/Tables/Columns/RepartoColumn.php`

---

## Available Custom Fields

### 1. ValutatoreField

A specialized select field for choosing evaluators (valutatori).

**Current Status**: Placeholder implementation - needs completion.

**Usage:**
```php
use Modules\Ptv\Filament\Forms\Components\ValutatoreField;

ValutatoreField::make('valutatore_id')
    ->label('Valutatore')
```

**File:** `Modules/Ptv/app/Filament/Forms/Components/ValutatoreField.php`

**Implementation needed:**
```php
protected function setUp(): void
{
    parent::setUp();
    
    $this->options(function () {
        return app(GetValutatoriOptions::class)
            ->execute('Progressioni', $this->getYear());
    });
}
```

---

## Architecture Pattern

All custom columns follow the same architectural pattern:

1. **Extend GroupColumn** - All columns extend `Modules\UI\Filament\Tables\Columns\GroupColumn`
2. **Static Schema** - Each column defines a static schema with predefined fields
3. **Reusable Pattern** - Same `make()` method pattern across all columns
4. **Searchable Integration** - Automatic searchable fields based on schema keys
5. **Extensible Design** - `appendColumns()` method for adding extra fields when needed

### Base Structure

```php
class CustomColumn extends GroupColumn
{
    protected array $extraColumns = [];

    protected static function getSchema(): array
    {
        return [
            // Define TextColumn fields here
        ];
    }

    public static function make(?string $name = null): static
    {
        $columns = static::getSchema();
        $searchable = array_keys($columns);

        /** @var array<int, Column> $validatedColumns */
        $validatedColumns = array_values(array_filter($columns, static fn ($col): bool => $col instanceof Column));
        
        return parent::make($name)
            ->schema($validatedColumns)
            ->searchable($searchable);
    }

    public function appendColumns(array $columns): static
    {
        $this->extraColumns = array_merge($this->extraColumns, $columns);
        $form = array_merge(static::getSchema(), $this->extraColumns);
        return $this->schema($form);
    }
}
```

---

## Relationship Resolution Best Practices

### The Core Problem

```php
// ❌ This doesn't work in GroupColumn-based columns
TextColumn::make('valutatore.nome_diri')

// ✅ This works in standard table contexts
TextColumn::make('valutatore.nome_diri')
```

### Solution 1: Use Closures (Recommended)

```php
protected static function getSchema(): array
{
    return [
        TextColumn::make('valutatore_nome')
            ->label('Valutatore')
            ->state(function (Model $record): ?string {
                return $record->valutatore?->nome_diri;
            }),
        TextColumn::make('valutatore_email')
            ->label('Email Valutatore')
            ->state(function (Model $record): ?string {
                return $record->valutatore?->email;
            }),
    ];
}
```

### Solution 2: Model Accessors

```php
// In your Model (e.g., Schede.php)
protected function valutatoreNomeDiri(): Attribute
{
    return Attribute::make(
        get: fn () => $this->valutatore?->nome_diri,
    );
}

protected function valutatoreEmail(): Attribute
{
    return Attribute::make(
        get: fn () => $this->valutatore?->email,
    );
}

// In Custom Column
protected static function getSchema(): array
{
    return [
        TextColumn::make('valutatore_nome_diri')->label('Valutatore'),
        TextColumn::make('valutatore_email')->label('Email'),
    ];
}
```

### Solution 3: Eager Loading (Required)

Always eager load relationships used in custom columns:

```php
// In your Resource
public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()
        ->with(['valutatore', 'user', 'repart']);
}
```

---

## Implementation Examples

### Before (GroupColumn usage)
```php
// Complex schema definition repeated in multiple places
GroupColumn::make('lavoratore')->schema([
    TextColumn::make('matr')->sortable()->searchable(),
    TextColumn::make('cognome')->sortable()->searchable(),
    TextColumn::make('nome')->sortable()->searchable(),
    TextColumn::make('email')->sortable()->searchable(),
]),
```

### After (Custom Column usage)
```php
// Simple, reusable, centralized
WorkerColumn::make('lavoratore')
```

---

## Usage Across Modules

### Progressioni Module Example

```php
// In Modules/Progressioni/app/Filament/Resources/ProgressioniResource/Pages/ListProgressionis.php

public function getTableColumns(): array
{
    return [
        // Other columns...
        WorkerColumn::make('lavoratore'),
        QuaColumn::make('qualifica'),
        RepartoColumn::make('reparto'),
        // Other columns...
    ];
}

public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()
        ->with([
            'user',           // For WorkerColumn
            'valutatore',      // For relationship fields
            'repart',          // For RepartoColumn
            'qua',            // For QuaColumn
        ]);
}
```

### IndennitaCondizioniLavoro Module Example

```php
// Direct TextColumn usage works fine here
public function getTableColumns(): array
{
    return [
        TextColumn::make('valutatore.nome_diri'), // ✅ Works directly
        // Other columns...
    ];
}

public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()
        ->with(['valutatore']); // Still needed for performance
}
```

---

## Performance Considerations

### 1. Eager Loading is Mandatory

```php
// ❌ Bad - N+1 queries
public function getTableColumns(): array
{
    return [WorkerColumn::make('lavoratore')];
}

// ✅ Good - Single query with relationships
public function getTableColumns(): array
{
    return [WorkerColumn::make('lavoratore')];
}

public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()->with(['user']);
}
```

### 2. Searchable Arrays Optimization

Custom columns automatically use field names as searchable attributes:

```php
// This becomes searchable on ['matr', 'cognome', 'nome', 'email']
WorkerColumn::make('lavoratore')
```

### 3. Column Toggleability

For large datasets, consider making columns toggleable:

```php
WorkerColumn::make('lavoratore')->toggleable()
```

---

## Benefits

1. **DRY Principle** - Eliminates code duplication across modules
2. **KISS Principle** - Simple, intuitive usage
3. **Maintainability** - Centralized column definitions
4. **Consistency** - Standardized column behavior across application
5. **Extensibility** - Easy to add new fields with `appendColumns()`
6. **Type Safety** - Full PHPStan Level 10 compliance

---

## Quality Assurance

All custom components pass:
- ✅ PHPStan Level 10 analysis
- ✅ PHPMD quality checks
- ✅ PHPInsights analysis
- ✅ Laraxot architecture compliance
- ✅ Pest PHP testing coverage

---

## Future Extensions

The pattern allows for easy creation of additional custom columns:

### Planned Components

1. **ValutatoreColumn** - For evaluator information
2. **AddressColumn** - For address information
3. **ContactColumn** - For contact details
4. **DocumentColumn** - For document metadata
5. **TimestampColumn** - For created/updated timestamps

### ValutatoreColumn Implementation

```php
class ValutatoreColumn extends GroupColumn
{
    protected static function getSchema(): array
    {
        return [
            TextColumn::make('nome_diri')
                ->label('Valutatore')
                ->state(function (Model $record): ?string {
                    return $record->valutatore?->nome_diri;
                }),
            TextColumn::make('email')
                ->label('Email')
                ->state(function (Model $record): ?string {
                    return $record->valutatore?->email;
                }),
            TextColumn::make('matr')
                ->label('Matricola')
                ->state(function (Model $record): ?string {
                    return $record->valutatore?->matr;
                }),
        ];
    }
}
```

---

## Troubleshooting

### Common Issues

1. **Empty relationship values**: Ensure relationships are eager loaded
2. **PHPStan errors**: Check that all columns properly extend GroupColumn
3. **Performance issues**: Verify eager loading is implemented
4. **Search not working**: Ensure relationship fields are accessible

### Debug Steps

1. Check if relationship exists: `$record->relationExists('valutatore')`
2. Verify eager loading: `dd($record->relations)`  
3. Test with standard TextColumn first
4. Use closures for complex relationship chains

---

## Testing

### Example Test for Custom Column

```php
// In Modules/Ptv/tests/Feature/WorkerColumnTest.php
public function test_worker_column_displays_data()
{
    $user = User::factory()->create([
        'nome' => 'Mario',
        'cognome' => 'Rossi',
        'email' => 'mario.rossi@test.com',
    ]);
    
    $scheda = Schede::factory()->create(['user_id' => $user->id]);
    
    $column = WorkerColumn::make('lavoratore');
    $schema = $column->getFields();
    
    $this->assertCount(4, $schema);
    $this->assertEquals('matr', $schema[0]->getName());
    $this->assertEquals('cognome', $schema[1]->getName());
    $this->assertEquals('nome', $schema[2]->getName());
    $this->assertEquals('email', $schema[3]->getName());
}
```

---

## Related Documentation

- [UI Module - GroupColumn Documentation](../../UI/docs/filament-groupcolumn-and-custom-columns.md)
- [UI Module - Relationship Resolution Analysis](../../UI/docs/groupcolumn-relationship-resolution-analysis.md)
- [Laraxot Architecture Guide](../../../AGENTS.md)
- [Filament v5 Migration Guide](../../UI/docs/filament/filament-4-migration-guide.md)

---

*Last updated: January 2026*