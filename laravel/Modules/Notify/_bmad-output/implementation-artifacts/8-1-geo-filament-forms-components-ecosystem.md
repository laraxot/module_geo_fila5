# Story 8.1: geo-filament-forms-components-ecosystem

Status: ready-for-dev

## Story

As a **developer building location-aware features across modules**,
I want **a complete set of Filament form components in the Geo module for geolocation**,
so that **I can reuse standardized, well-tested components instead of reinventing geolocation in every module**.

## Acceptance Criteria

1. `AddressInput` — Single address field with "use current location" button and browser geolocation
2. `AddressSection` — Grouped fields for street, number, city, postal code, country (separated)
3. `LatitudeLongitudeMapInput` — Interactive map (Leaflet/OSM) that saves lat/lng coordinates
4. `LocationSelector` — Combines AddressInput + map preview in one component
5. `CoordinatesInput` — Pure lat/lng numeric input pair with validation
6. All components integrate natively with Filament form schema system
7. All components have proper Livewire state binding (no `wire:ignore` workarounds)
8. All components have IT/EN translations
9. Documentation with usage examples for each component
10. Fixcity wizard migrates to use new components

## Tasks / Subtasks

### Task 1: Research and analyze existing patterns (AC: all)
- [ ] Study Livewire + Geolocation integration patterns from provided resources
- [ ] Study Filament custom field architecture (https://filamentphp.com/docs/5.x/forms/custom-fields)
- [ ] Study how to embed JS APIs in Filament/Livewire components
- [ ] Study existing Geo module components (AddressField, AddressesField, AddressSection)
- [ ] Identify what exists vs what needs to be created

### Task 2: Fix/improve AddressInput component (AC: #1, #6, #7, #8)
- [ ] Current `AddressInput` uses `Blade::render()` — convert to proper Filament field
- [ ] Fix Livewire state binding: use `$statePath` properly, not `wire:model.live` string
- [ ] Add Alpine.js `x-data` for geolocation button state
- [ ] Integrate browser `navigator.geolocation.getCurrentPosition()`
- [ ] Add reverse geocoding via Nominatim (free, no API key)
- [ ] Add loading state during geolocation
- [ ] Add error handling (permission denied, not supported, network error)
- [ ] Add validation rules (required, max length, format)
- [ ] Add IT/EN translations via `geo::address.*` namespace

### Task 3: Create AddressSection component (AC: #2, #6, #7, #8)
- [ ] Create `Modules/Geo/app/Filament/Forms/Components/AddressSection.php`
- [ ] Extends `Section` (Filament schema component)
- [ ] Contains grouped fields: street, number, city, postal_code, province, country, notes
- [ ] Supports `columns()` for responsive layout
- [ ] Integrates with Geo module's address data structure
- [ ] Supports autocomplete via Nominatim API (type address, get suggestions)
- [ ] Add IT/EN translations

### Task 4: Create LatitudeLongitudeMapInput component (AC: #3, #6, #7, #8)
- [ ] Create `Modules/Geo/app/Filament/Forms/Components/LatitudeLongitudeMapInput.php`
- [ ] Create view: `resources/views/filament/forms/components/latitude-longitude-map-input.blade.php`
- [ ] Use Leaflet.js (free, open source) — NOT Google Maps (requires API key)
- [ ] Interactive map with draggable marker
- [ ] Map center based on existing lat/lng or default location
- [ ] On marker drag: update `latitude` and `longitude` fields via `$wire.set()`
- [ ] On input change: update map marker position
- [ ] Support zoom controls, tile layer (OSM)
- [ ] Responsive: works on mobile and desktop
- [ ] Add validation (lat: -90 to 90, lng: -180 to 180)
- [ ] Add IT/EN translations

### Task 5: Create LocationSelector component (AC: #4, #6, #7, #8)
- [ ] Create `Modules/Geo/app/Filament/Forms/Components/LocationSelector.php`
- [ ] Combines `AddressInput` + `LatitudeLongitudeMapInput` in one component
- [ ] Layout: address input on top, map preview below
- [ ] Sync: when address changes, geocode and update map marker
- [ ] Sync: when map marker moves, reverse geocode and update address
- [ ] Toggle between "search by address" and "pick on map" modes
- [ ] Add IT/EN translations

### Task 6: Create CoordinatesInput component (AC: #5, #6, #7, #8)
- [ ] Create `Modules/Geo/app/Filament/Forms/Components/CoordinatesInput.php`
- [ ] Create view: `resources/views/filament/forms/components/coordinates-input.blade.php`
- [ ] Two numeric inputs: latitude, longitude
- [ ] Validation: lat -90 to 90, lng -180 to 180
- [ ] Optional: "use my location" button to auto-fill
- [ ] Support decimal degrees format (WGS84)
- [ ] Add IT/EN translations

### Task 7: Update Fixcity wizard to use new components (AC: #10)
- [ ] Replace current `AddressInput::make('address')` with improved version
- [ ] Test wizard Step 2 renders correctly
- [ ] Test geolocation button works
- [ ] Test Livewire state binding (no entangle errors)
- [ ] Test form submission with address data

### Task 8: Documentation (AC: #9)
- [ ] Create `Geo/docs/filament-forms-components.md` with usage examples
- [ ] Document each component with code samples
- [ ] Document translations
- [ ] Document troubleshooting (common issues, Livewire state problems)
- [ ] Update `Geo/docs/INDEX.md`
- [ ] Update `Fixcity/docs/INDEX.md` references

## Dev Notes

### Architecture: Filament Custom Fields

**Zen**: Filament custom fields extend `Field` and integrate natively with the form schema system. They are NOT Blade::render workarounds.

```php
class AddressInput extends Field
{
    protected string $view = 'geo::filament.forms.components.address-input';
    
    protected function setUp(): void
    {
        parent::setUp();
        
        // State hydration
        $this->afterStateHydrated(function (AddressInput $component, mixed $state): void {
            if (! is_string($state)) {
                $component->state('');
            }
        });
    }
}
```

### Livewire + Geolocation Integration

**Key insight from research**: Browser geolocation runs client-side (JavaScript). Livewire state must be updated via:

1. **Proper way** (Filament field):
```javascript
// In Blade view
function useMyLocation(statePath) {
    navigator.geolocation.getCurrentPosition(function(pos) {
        // Reverse geocode...
        const address = data.display_name;
        // Update via Livewire
        $wire.$set(statePath, address);
    });
}
```

2. **Alpine.js + $wire** (for embedded JS):
```blade
<div x-data>
    <input wire:model.live="{{ $statePath }}">
    <button x-on:click="getLocation('{{ $statePath }}')">Use location</button>
</div>
```

3. **NOT $wire directly in global JS** (doesn't work):
```javascript
// WRONG: window.Livewire.all() is fragile
// WRONG: $wire is not available in global scope
```

### Common Issues from Research

| Issue | Solution |
|---|---|
| Livewire not updating input value | Use `wire:model.live` not `wire:model.defer` for JS updates |
| Entangle error | Ensure state path is defined in component's `$statePath` |
| wire:ignore breaks updates | Remove wire:ignore, use proper Filament field pattern |
| JS can't find $wire | Pass statePath to JS function, use `$wire.$set()` |
| Custom field state not saving | Ensure `setUp()` calls `parent::setUp()` and statePath is correct |

### Existing Geo Module Components

| Component | Type | Status | Notes |
|---|---|---|---|
| `AddressInput` | Field | ⚠️ Needs improvement | Uses Blade::render, needs proper Filament integration |
| `AddressField` | Field | ✅ Exists | Single address field (legacy?) |
| `AddressesField` | Field | ✅ Exists | Multiple addresses (repeater-like) |
| `AddressSection` | Section | ⚠️ May need update | Check if it matches new design |

### Component Architecture

```
Geo/Filament/Forms/Components/
├── AddressInput.php          ← Single address with geolocation button
├── AddressSection.php        ← Grouped address fields (street, city, etc.)
├── CoordinatesInput.php      ← Lat/Lng numeric inputs
├── LatitudeLongitudeMapInput.php ← Interactive Leaflet map
└── LocationSelector.php      ← AddressInput + Map combined
```

### Testing Standards

- Each component: unit test for state handling
- Integration test: render in form schema
- Browser test: geolocation button (if browser supports)
- Map test: marker drag updates coordinates
- Validation test: invalid lat/lng rejected

### Dependencies

- **Leaflet.js** (CDN or npm) — free map tiles
- **Nominatim API** (OSM) — free geocoding/reverse geocoding
- **Alpine.js** (already loaded via Livewire/Filament)
- **No Google Maps API key required**

### References

- [Filament Custom Fields]: https://filamentphp.com/docs/5.x/forms/custom-fields
- [Filament Wizards]: https://filamentphp.com/docs/5.x/schemas/wizards
- [Livewire + Geolocation]: https://dev.to/bradisrad83/browser-location-with-laravel-livewire-54bd
- [Livewire State Issues]: https://laracasts.com/discuss/channels/livewire/livewire-not-updating-the-value-of-the-input-field
- [CheeseGrits Google Maps Plugin]: https://filamentphp.com/plugins/cheesegrits-google-maps
- [Fly.io Livewire Maps]: https://fly.io/laravel-bytes/map-livewire/

## Dev Agent Record

### Agent Model Used

{{agent_model_name_version}}

### Debug Log References

### Completion Notes List

### File List
