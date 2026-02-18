---
name: never-simplify-domain
description: CRITICAL - Never replace domain-specific code with generic alternatives. Never remove custom columns, traits, actions, blade includes, associative array keys, or year options. Always preserve business logic.
---

# NEVER Simplify Domain Logic

This skill defines INVIOLABLE rules about what must NEVER be changed when refactoring or cleaning up code.

## When This Applies

- ALWAYS. These rules override any "cleanup" or "simplification" instinct.
- When refactoring, fixing PHPStan errors, or improving code quality
- When tempted to replace complex code with simpler alternatives

## FORBIDDEN ACTIONS

### 1. NEVER Replace Custom Columns with TextColumn

Custom columns like `WorkerColumn`, `ValutatoreColumn`, `QuaColumn`, `RepartoColumn` encode domain-specific rendering, formatting, and behavior. They are NOT simple text displays.

```php
// WRONG - destroying domain logic
TextColumn::make('matr')->searchable(),
TextColumn::make('cognome')->searchable(),

// CORRECT - preserve custom columns
WorkerColumn::make('lavoratore'),
ValutatoreColumn::make('valutatore'),
```

**WHY**: Custom columns contain rendering logic, computed values, relationships, and UI behavior that TextColumn cannot replicate.

### 2. NEVER Remove Options from Select/Filter

If a select has year 2026, do NOT remove it. If it has specific options, keep ALL of them.

```php
// WRONG - removing the current/future year
->options(['2023' => '2023', '2024' => '2024', '2025' => '2025'])

// CORRECT - keep ALL original options
->options(['2023' => '2023', '2024' => '2024', '2025' => '2025', '2026' => '2026'])
```

**WHY**: Year options represent operational periods. The system needs forward-looking years for planning and data entry.

### 3. NEVER Change Associative Array Keys to Indexed

Named keys in arrays carry semantic meaning. Changing `$array['key']` to `$array[]` destroys the ability to reference specific items.

```php
// WRONG - losing the semantic key
$filters[] = SelectFilter::make('quadrimestre');

// CORRECT - preserve the named key
$filters['quadrimestre'] = SelectFilter::make('quadrimestre');
```

**WHY**: Named keys allow other code to reference, override, or modify specific filters/columns/actions by name.

### 4. NEVER Delete getHeaderActions() or Custom Actions

Header actions contain critical business functionality like imports, exports, bulk operations.

```php
// WRONG - deleting the entire method
// (deleted getHeaderActions with ImportValutatoriAction)

// CORRECT - ALWAYS preserve action methods and their content
protected function getHeaderActions(): array
{
    $actions = parent::getHeaderActions();
    $actions['import_valutatori_'] = ImportValutatoriAction::make('import_valutatori_')
        ->addFields([...])
        ->setStabiDirigenteModel(StabiDirigente::class)
        ->setSchedaModel(CondizioniLavoro::class);
    return $actions;
}
```

**WHY**: These actions implement core business workflows (imports, exports, etc.) that users depend on daily.

### 5. NEVER Replace Blade @include with Inline Code

Blade includes (`@include('module::path')`) are intentional abstractions for reusability and maintainability.

```php
// WRONG - inlining what was a reusable partial
<img src="{{ public_path('assets/ptv/img/logo.png') }}">

// CORRECT - preserve the blade include
@include('ptv::pdf.header')
```

**WHY**: Blade includes are shared across multiple views. Inlining creates duplication and breaks the DRY principle.

### 6. NEVER Remove Traits from Models

Traits like `HasValutatore`, `HasTeams`, `HasCommonScopes` add domain-specific behavior to models.

```php
// WRONG - removing a trait
class CondizioniLavoro extends Model
{
    // HasValutatore removed!
}

// CORRECT - preserve ALL traits
class CondizioniLavoro extends Model
{
    use HasValutatore;
    // ... other traits
}
```

**WHY**: Traits add relationships, scopes, accessors, and business methods that the application depends on.

### 7. NEVER Delete Files Without Explicit Request

Contract files, column classes, trait files, blade partials, and translation files must NEVER be deleted unless the user explicitly requests it with a clear reason.

## Root Cause Prevention

These errors occur when the AI:
1. **Oversimplifies** - Replaces domain abstractions with generic primitives
2. **Doesn't understand context** - Custom columns/traits/actions carry hidden business logic
3. **Focuses on "cleanliness" over functionality** - Clean code that doesn't work is worthless
4. **Removes perceived "complexity"** - Domain complexity is INTENTIONAL and NECESSARY

## The Golden Rule

> **When in doubt, PRESERVE the existing code.** Ask the user before simplifying, removing, or replacing any domain-specific construct. The existing code was written intentionally and serves a purpose you may not fully understand.
