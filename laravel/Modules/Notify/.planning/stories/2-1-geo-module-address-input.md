# Story: Geo Module AddressInput Component — Modular Boundary Philosophy

## Status: ready-for-dev

## Epic
**Epic 2**: Modular Architecture — Domain-Driven Module Boundaries

## Story

As a developer building FixCity modular monolith,
I want the AddressInput component to live in the Geo module and be consumed by Fixcity through proper Filament form component API,
so that geolocation concerns remain owned by Geo (single source of truth) while Fixcity focuses on ticket business logic.

---

## Acceptance Criteria

### AC1: AddressInput Component in Geo Module
- **Given** the DDD principle of bounded contexts
- **When** I look for the AddressInput component
- **Then** it exists at `Modules/Geo/app/Filament/Forms/Components/AddressInput.php`
- **And** the Blade view is at `Modules/Geo/resources/views/filament/forms/components/address-input.blade.php`
- **And** it extends `Filament\Forms\Components\Field` (proper Filament form component)

### AC2: Fixcity Uses Geo's AddressInput via Import
- **Given** Fixcity needs an address field with geolocation
- **When** I inspect `CreateTicketWizardWidget.php`
- **Then** it imports `use Modules\Geo\Filament\Forms\Components\AddressInput;`
- **And** uses `AddressInput::make('address')` in the form schema
- **And** does NOT use `Placeholder` + `Blade::render()` hack

### AC3: No Cross-Module Blade Duplication
- **Given** the DRY principle across modules
- **When** I search for geolocation code in Fixcity
- **Then** no geolocation Blade templates exist in `Modules/Fixcity/resources/views/`
- **And** no geolocation logic exists in Fixcity PHP files

### AC4: Geo Module Documentation Updated
- **Given** the component ownership model
- **When** I read Geo module docs
- **Then** `Modules/Geo/docs/ADDRESS-INPUT.md` documents the component
- **And** it explains the cross-module usage pattern

---

## Tasks / Subtasks

### Task 1: Create AddressInput Filament Component in Geo Module (AC: 1)
- [ ] Create `Modules/Geo/app/Filament/Forms/Components/AddressInput.php`
- [ ] Extend `Filament\Forms\Components\Field`
- [ ] Implement `getInputView()` returning the Blade view
- [ ] Add `livewire()` method for geolocation button action
- [ ] Add `spriteUrl()` method for SVG icon path configuration

### Task 2: Create Blade View in Geo Module (AC: 1)
- [ ] Create `Modules/Geo/resources/views/filament/forms/components/address-input.blade.php`
- [ ] Match Design Comuni structure (cmp-card, form-group, link-wrapper)
- [ ] Use `wire:model.live="getState()"` for Livewire binding
- [ ] Use Alpine.js `x-on:click.prevent` for geolocation button
- [ ] Reference Geo module translations (`geo::address.*`)

### Task 3: Update CreateTicketWizardWidget to Use AddressInput (AC: 2)
- [ ] Replace `Placeholder` + `Blade::render()` with `AddressInput::make('address')`
- [ ] Remove `use Illuminate\Support\HtmlString;` if no longer needed
- [ ] Remove `getAddressComponent()` method
- [ ] Add `AddressInput` to step schema directly

### Task 4: Remove Duplicate Code from Fixcity (AC: 3)
- [ ] Delete `Modules/Fixcity/resources/views/filament/widgets/components/address-field.blade.php` if exists
- [ ] Search for any other geolocation code in Fixcity and remove

### Task 5: Create Geo Module Documentation (AC: 4)
- [ ] Create `Modules/Geo/docs/ADDRESS-INPUT.md`
- [ ] Document component API, usage examples, cross-module import pattern
- [ ] Update `Modules/Geo/docs/MODULE-BOUNDARIES.md` with geolocation ownership

### Task 6: Build + Verify
- [ ] Run `php artisan view:clear && php artisan config:clear`
- [ ] Navigate to `/it/tests/segnalazione-crea`
- [ ] Verify address field renders correctly with geolocation button
- [ ] Test geolocation button works

---

## Dev Notes

### Architecture Philosophy — The Zen of Modular Monolith

**Core Principle: Module Ownership of Domain Concerns**

Each module OWNS its domain. Other modules USE, never duplicate.

```
Geo Module (OWNER)          Fixcity Module (CONSUMER)
├── AddressInput             ├── CreateTicketWizardWidget
├── GeolocationService       │   └── uses: AddressInput::make('address')
├── Coordinates Model        │
├── Nominatim Client         │
└── docs/ADDRESS-INPUT.md    └── docs/ (ticket business logic only)
```

**Why AddressInput belongs in Geo:**
1. **Geolocation is a geo-spatial concern**, not a ticket concern
2. **Single source of truth**: one implementation, many consumers
3. **Independent evolution**: Geo can improve geolocation without touching Fixcity
4. **Testability**: Geo tests geolocation in isolation
5. **Reusability**: Any module (Predict, Activity, Tenant) can use AddressInput

**Why Fixcity must NOT duplicate:**
1. **DRY violation**: Two implementations diverge over time
2. **Maintenance burden**: Fix every bug in both places
3. **Architectural decay**: Module boundaries become meaningless
4. **Testing complexity**: Same logic tested twice

**The Rule:**
> If a component's primary concern is geographic (address, coordinates, maps, geolocation),
> it belongs in the Geo module. Other modules import it via `use Modules\Geo\...`.

### Current (WRONG) Implementation

```php
// Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php
protected function getAddressComponent(): Component
{
    return Placeholder::make('address_section')
        ->label('')
        ->content(new HtmlString(
            \Blade::render('geo::filament.components.address-field', [...])
        ));
}
```

This is a hack:
- Uses `Placeholder` (wrong component type — should be a proper `Field`)
- Uses `Blade::render()` (bypasses Filament form lifecycle)
- Cannot participate in form validation, state management, or Livewire binding properly

### Correct (Desired) Implementation

```php
// Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php
use Modules\Geo\Filament\Forms\Components\AddressInput;

private function makeStepData(): Step
{
    return Step::make('2')
        ->label((string) __('fixcity::segnalazione.steps.data.label'))
        ->schema([
            AddressInput::make('address')
                ->label((string) __('fixcity::segnalazione.fields.address.label'))
                ->required(),
            Select::make('issueType')->...,
            // ... rest of schema
        ]);
}
```

### Reference Documentation
- [Geo Module](../../Modules/Geo/docs/)
- [Fixcity Module](../../Modules/Fixcity/docs/)
- [Filament v5 Forms Components](https://filamentphp.com/docs/5.x/forms/fields)
- [DDD Bounded Contexts](https://martinfowler.com/bliki/BoundedContext.html)

---

## Change Log

| Date | Version | Description | Author |
|------|---------|-------------|--------|
| 2026-04-13 | 1.0 | Initial story from modular boundary analysis | AI Agent |

---

## Dev Agent Record

### Agent Model Used
_(not yet run)_

### Debug Log References
_(not yet run)_

### Completion Notes
_(not yet run)_

### File List
_(not yet run)_

### Change Log
_(not yet run)_
