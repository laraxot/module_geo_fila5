# Story: Extract AddressInput to Geo Module — Proper Filament Component

## Status: Draft

## Epic
**Epic 0**: Project Infrastructure

## Story
As a developer building multi-module Laravel applications,
I want the Geo module to provide a reusable `AddressInput` Filament form component,
so that any business module (Fixcity, and others) can consume geolocation features without owning geographic logic.

---

## Acceptance Criteria

### AC1: AddressInput Component Exists in Geo Module
- **Given** the Geo module at `Modules/Geo/`
- **When** I inspect `Modules/Geo/Filament/Forms/Components/AddressInput.php`
- **Then** it exists as a proper Filament form component extending `Filament\Forms\Components\Field`
- **And** it implements geolocation button, reverse geocoding, address autocomplete
- **And** it uses its own Blade view for rendering

### AC2: CreateTicketWizardWidget Uses AddressInput from Geo
- **Given** the CreateTicketWizardWidget at `Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`
- **When** I inspect `makeStepData()`
- **Then** it uses `use Modules\Geo\Filament\Forms\Components\AddressInput;`
- **And** it calls `AddressInput::make('address')` instead of `Placeholder::make('address_section')` with `Blade::render()`
- **And** Fixcity does NOT contain any geolocation logic or Nominatim API code

### AC3: AddressInput is Configurable and Reusable
- **Given** any module wants to use AddressInput
- **When** they call `AddressInput::make('location')`
- **Then** they can configure: label, placeholder, required, geocoding provider
- **And** it works in any Filament form/schema context (not just wizards)
- **And** it integrates with Livewire state properly

### AC4: Geo Module Has Proper Service Provider Registration
- **Given** the Geo module's `GeoServiceProvider`
- **When** the application boots
- **Then** the AddressInput component is properly registered
- **And** its Blade view namespace `geo::` resolves correctly

### AC5: Fixcity Has NO Duplicate Address/Geolocation Code
- **Given** the Fixcity module
- **When** I search for geolocation, Nominatim, reverse geocoding code
- **Then** I find ZERO occurrences — all delegated to Geo's AddressInput
- **And** Fixcity only contains ticket/business logic

---

## Dev Technical Guidance — THE PHILOSOPHY

### Why AddressInput Belongs in Geo Module (The "Zen")

**Domain-Driven Design — Bounded Context:**

```
┌─────────────────────────────────────┐
│         Geo Module (Generic)        │
│  ┌───────────────────────────────┐  │
│  │ AddressInput Component         │  │
│  │ - Geolocation button           │  │
│  │ - Reverse geocoding (Nominatim)│  │
│  │ - Address autocomplete         │  │
│  │ - Coordinate extraction         │  │
│  │ - Map integration hooks         │  │
│  └───────────────────────────────┘  │
│                                     │
│  Ubiquitous Language:               │
│  "location", "coordinates",         │
│  "address", "geocode", "bounds"     │
└─────────────────────────────────────┘
         ↓ provides to ↓
┌─────────────────────────────────────┐
│      Fixcity Module (Core Domain)    │
│  ┌───────────────────────────────┐  │
│  │ CreateTicketWizardWidget       │  │
│  │ - Privacy step                 │  │
│  │ - Ticket type selection        │  │
│  │ - Summary & submit             │  │
│  │ - AddressInput::make('address')│  │  ← CONSUMES, doesn't own
│  └───────────────────────────────┘  │
│                                     │
│  Ubiquitous Language:               │
│  "ticket", "segnalazione",          │
│  "issue", "resolution", "status"    │
└─────────────────────────────────────┘
```

**The Problem with Current Approach:**

```php
// ❌ WRONG — Fixcity owns geolocation logic via Blade::render
protected function getAddressComponent(): Component
{
    return Placeholder::make('address_section')
        ->label('')
        ->content(new HtmlString(
            \Blade::render('geo::filament.components.address-field', [...])
        ));
}
```

This is wrong because:
1. **Fixcity knows about geographic rendering** — it shouldn't
2. **Blade::render() is a hack** — it bypasses Filament's form state management
3. **Not a real Filament component** — can't be configured, validated, or tested properly
4. **Tight coupling** — Fixcity must know the exact view path and sprite URL

**The Correct Approach:**

```php
// ✅ CORRECT — Fixcity consumes, Geo provides
use Modules\Geo\Filament\Forms\Components\AddressInput;

protected function makeStepData(): Step
{
    return Step::make('2')
        ->schema([
            AddressInput::make('address')
                ->label(__('fixcity::segnalazione.fields.address.label'))
                ->placeholder(__('fixcity::segnalazione.create.address.placeholder'))
                ->required(),
            Select::make('issueType')...
        ]);
}
```

### Why This Matters (The "Religion")

| Principle | If Address is in Fixcity | If Address is in Geo |
|---|---|---|
| **SRP** | Fixcity changes when Nominatim API changes ❌ | Only Geo changes when geocoding changes ✅ |
| **DRY** | Every module that needs addresses reimplements | One AddressInput, consumed by all modules ✅ |
| **Reusability** | Address logic trapped in Fixcity | Any module uses `AddressInput::make()` ✅ |
| **Testability** | Fixcity tests must mock geolocation | Geo tests geolocation, Fixcity tests tickets ✅ |
| **Evolution** | Fixcity bloated with geographic concerns | Geo evolves independently ✅ |
| **Team Ownership** | Fixcity team owns maps they don't understand | Geo team owns maps, Fixcity team owns tickets ✅ |

### AddressInput Component Structure

```
Modules/Geo/
├── Filament/
│   └── Forms/
│       └── Components/
│           └── AddressInput.php          ← Proper Filament Field component
├── resources/
│   └── views/
│       └── filament/
│           └── forms/
│               └── components/
│                   └── address-input.blade.php  ← Component view
├── app/
│   └── Services/
│       └── Geocoding/
│           ├── GeocodingService.php      ← Nominatim, Google Maps, etc.
│           └── NominatimProvider.php     ← OpenStreetMap provider
└── docs/
    └── ADDRESS-INPUT-COMPONENT.md        ← Usage docs
```

### AddressInput PHP Component

```php
<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Filament\Forms\Components\Field;
use Illuminate\Contracts\View\View;

class AddressInput extends Field
{
    protected string $view = 'geo::filament.forms.components.address-input';

    protected ?string $sprite = null;

    protected bool $showGeolocationButton = true;

    protected string $geocodingProvider = 'nominatim';

    public function sprite(string $sprite): static
    {
        $this->sprite = $sprite;
        return $this;
    }

    public function showGeolocationButton(bool $show = true): static
    {
        $this->showGeolocationButton = $show;
        return $this;
    }

    public function geocodingProvider(string $provider): static
    {
        $this->geocodingProvider = $provider;
        return $this;
    }

    public function getSprite(): string
    {
        return $this->sprite ?? '/themes/Sixteen/design-comuni/assets/bootstrap-italia/dist/svg/sprites.svg';
    }

    public function showGeolocationButtonFlag(): bool
    {
        return $this->showGeolocationButton;
    }

    public function getGeocodingProvider(): string
    {
        return $this->geocodingProvider;
    }
}
```

### AddressInput Blade View

```blade
@php
    $sprite = $getSprite();
    $showGeolocation = $showGeolocationButtonFlag();
    $provider = $getGeocodingProvider();
@endphp

<div x-data="geoAddressInput({
    provider: '{{ $provider }}',
    state: $wire.$entangle('{{ $getStatePath() }}'),
})">
    <input
        type="text"
        {{ $applyStateBindingAttributes(['wire:model' => 'state']) }}
        {{ $getExtraAttributeBag()->class(['form-control']) }}
        placeholder="{{ $getPlaceholder() }}"
    >
    @if($showGeolocation)
        <a href="#" x-on:click.prevent="useMyLocation()">
            <svg class="icon icon-sm icon-primary">
                <use href="{{ $sprite }}#it-map-marker"></use>
            </svg>
            <span>{{ __('geo::address.use_my_location') }}</span>
        </a>
    @endif
</div>

<script>
function geoAddressInput({ provider, state }) {
    return {
        state: state,
        useMyLocation() {
            navigator.geolocation.getCurrentPosition((pos) => {
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${pos.coords.latitude}&lon=${pos.coords.longitude}`)
                    .then(r => r.json())
                    .then(data => { this.state = data.display_name; });
            });
        }
    };
}
</script>
```

### Fixcity Widget After Refactor

```php
use Modules\Geo\Filament\Forms\Components\AddressInput;

private function makeStepData(): Step
{
    return Step::make('2')
        ->label((string) __('fixcity::segnalazione.steps.data.label'))
        ->schema([
            AddressInput::make('address')
                ->label((string) __('fixcity::segnalazione.fields.address.label'))
                ->placeholder((string) __('fixcity::segnalazione.create.address.placeholder'))
                ->required(),
            Select::make('issueType')
                ->label((string) __('fixcity::segnalazione.fields.type.label'))
                ->options(fn (): array => $this->getIssueTypeOptions())
                ->required()
                ->native(false),
            // ... rest of fields
        ]);
}

// Remove getAddressComponent() entirely — no longer needed
// Remove Blade::render() hack
// Remove Placeholder for address
```

### File Paths

| File | Action |
|------|--------|
| `Modules/Geo/Filament/Forms/Components/AddressInput.php` | **CREATE** — proper Filament Field |
| `Modules/Geo/resources/views/filament/forms/components/address-input.blade.php` | **CREATE** — component view |
| `Modules/Geo/lang/en/address.php` | **CREATE** — translations |
| `Modules/Geo/lang/it/address.php` | **CREATE** — translations |
| `Modules/Geo/docs/ADDRESS-INPUT-COMPONENT.md` | **CREATE** — usage documentation |
| `Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php` | **MODIFY** — use `AddressInput::make()` |
| `Modules/Geo/resources/views/components/geolocation/address-field.blade.php` | **KEEP** — for non-Filament contexts (CMS blocks, Volt pages) |

---

## Tasks / Subtasks

### Task 1: Create AddressInput Filament Component in Geo (AC: 1)
- [ ] Create `Modules/Geo/Filament/Forms/Components/AddressInput.php`
- [ ] Extend `Filament\Forms\Components\Field`
- [ ] Add configurable properties: sprite, showGeolocationButton, geocodingProvider
- [ ] Set view to `geo::filament.forms.components.address-input`
- [ ] Create `Modules/Geo/resources/views/filament/forms/components/address-input.blade.php`
- [ ] Move geolocation logic from `address-field.blade.php` into the component view
- [ ] Wire up Livewire state binding properly (`$wire.$entangle`)
- [ ] Test component renders in isolation

### Task 2: Add Translations to Geo Module (AC: 3)
- [ ] Create `Modules/Geo/lang/it/address.php` with Italian translations
- [ ] Create `Modules/Geo/lang/en/address.php` with English translations
- [ ] Keys: `use_my_location`, `geolocation_not_supported`, `geolocation_permission_denied`, `geolocation_error`

### Task 3: Update CreateTicketWizardWidget to Use AddressInput (AC: 2, 5)
- [ ] Read `CreateTicketWizardWidget.php` fully
- [ ] Add `use Modules\Geo\Filament\Forms\Components\AddressInput;`
- [ ] Replace `getAddressComponent()` call with `AddressInput::make('address')->label(...)->placeholder(...)->required()`
- [ ] Remove `getAddressComponent()` method entirely
- [ ] Remove `Placeholder` import if no longer used for address
- [ ] Remove `Blade::render()` import if no longer used
- [ ] Verify no geolocation code remains in Fixcity module
- [ ] Test: wizard still works, address field still functional

### Task 4: Create Geo Module Documentation (AC: 3)
- [ ] Create `Modules/Geo/docs/ADDRESS-INPUT-COMPONENT.md`
- [ ] Document: usage examples, configuration options, geocoding providers
- [ ] Show how to use in any module: `AddressInput::make('address')->required()`
- [ ] Document the DDD philosophy: why Geo owns this, why other modules consume it

### Task 5: Verify No Duplicate Address/Geolocation Code (AC: 5)
- [ ] Search Fixcity module for: `geolocation`, `nominatim`, `reverse`, `coords`, `latitude`, `longitude`
- [ ] All results should be ZERO (or only business-logic references, not implementation)
- [ ] Verify Geo module is the SINGLE source of truth for geospatial logic
- [ ] Document findings in Geo module docs

---

## Dev Notes

### DDD Philosophy Reference
- Martin Fowler — Bounded Context: `https://martinfowler.com/bliki/BoundedContext.html`
- The Geo module is a **generic subdomain** — provides capabilities, not business rules
- Fixcity is a **core subdomain** — contains the business value (ticket creation, routing, resolution)
- Generic subdomains should be extracted so they can be reused across applications

### Anti-Patterns to Avoid
1. ❌ `Blade::render()` to inject components — breaks Filament state binding
2. ❌ Fixcity knowing about sprite URLs, Nominatim, geolocation — violates bounded context
3. ❌ Duplicating address field logic in multiple modules — violates DRY
4. ❌ Placeholder hacks instead of proper Field components — unmaintainable

### Existing Code to Leverage
- `Modules/Geo/resources/views/components/geolocation/address-field.blade.php` — existing geolocation UI, adapt for Filament component
- `Modules/Geo/app/Services/` — check if geocoding services already exist

---

## Definition of Done

- [ ] All Tasks and Subtasks marked [x]
- [ ] `AddressInput` exists as proper Filament component in Geo module
- [ ] CreateTicketWizardWidget uses `AddressInput::make('address')` — no Blade::render
- [ ] Fixcity has ZERO geolocation implementation code
- [ ] Geo module has translations and documentation for AddressInput
- [ ] AddressInput works in any Filament form context (not just wizard)
- [ ] No duplicate address/geolocation code across modules
- [ ] Bidirectional docs links updated
