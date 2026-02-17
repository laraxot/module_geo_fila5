# Compila Page Systematization Pattern

## Overview
The `Compila` page is a specialized evaluation interface built with Filament. The goal of systematization is to provide a clean, reactive, and type-safe experience following the "Super Mucca" methodology.

## Key Principles
- **Unified Form**: All record information (header + body + summary) exists within the Filament `$form` schema.
- **Live Reactivity**: Real-time calculations using `live()` on fields and `recalculateReadonlyFields` on state updates.
- **Type Safety**: Full PHPStan Level 10 compliance using explicit type narrowing (`getSpecificRecord()`).

## Architecture Implementation

### 1. Type-Safe Record Access
To satisfy PHPStan Level 10 when using `InteractsWithRecord`, use a helper method:

```php
protected function getSpecificRecord(): IndennitaResponsabilita
{
    if (! $this->record instanceof IndennitaResponsabilita) {
        throw new \LogicException('Record is missing or invalid.');
    }

    return $this->record;
}
```

### 2. Form Schema Structure
Organize the form into logical sections:
- **Informazioni Generali**: Worker metadata (Read-Only).
- **Valutazioni**: Dynamic input fields for ratings.
- **Riepilogo Calcoli**: Real-time calculated summary.

```php
protected function getFormSchema(): array
{
    return [
        Section::make('Informazioni Generali')->columns(4)->schema([...]),
        Section::make('Valutazioni')->schema($this->getRatingsSchema()),
        Section::make('Riepilogo Calcoli')->columns(4)->schema([...]),
    ];
}
```

### 3. Reactive Logic
Use `recalculateReadonlyFields` to update summary fields whenever a rating changes:

```php
$item->live(onBlur: true)
    ->afterStateUpdated(function (Set $set, Get $get) use (&$readonlyFields): void {
        $this->recalculateReadonlyFields($set, $get, $readonlyFields);
    });
```

## Benefits
- **KISS**: Reduces Blade HTML overhead.
- **DRY**: Logic is centralized in the Livewire component.
- **SOLID**: Clear separation of schema definition and calculation logic.
