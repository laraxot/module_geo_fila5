# Geo Module - Map Components Architecture

> **Last Updated**: 2026-04-20  
> **Status**: Active  
> **Module**: Geo  
> **Related**: CoordinatePicker, LatitudeLongitudeInput, MapPicker, PlacePicker

---

## Golden Rule: Class Selectors for Leaflet

**CRITICAL**: All map components MUST follow the class selector rule.

**FORBIDDEN:**
- `id="map"` in templates
- `getElementById('map')` in JavaScript
- `#map` in CSS

**MANDATORY:**
- `class="map-container"` in templates
- `this.querySelector('.map-container')` for lookup

📖 **Full Rule**: [`docs/rules/leaflet-class-selector.md`](../../../../docs/rules/leaflet-class-selector.md)

---

## Component Family

```
CoordinatePicker (Base)
├── LatitudeLongitudeInput
├── MapPicker
└── PlacePicker
```

All components share:
- Core state: `{ latitude: float|null, longitude: float|null }`
- Web component: `coordinate-picker-field.js` (or specialized variants)
- Alpine bridge pattern
- Light DOM for Leaflet compatibility

---

## File Structure

```
laravel/Modules/Geo/
├── app/Filament/Forms/Components/
│   ├── CoordinatePicker.php          # Base field
│   ├── LatitudeLongitudeInput.php    # Extends CoordinatePicker
│   ├── MapPicker.php                 # Extends CoordinatePicker
│   └── PlacePicker.php               # Extends CoordinatePicker
├── resources/views/filament/forms/components/
│   ├── coordinate-picker.blade.php
│   ├── latitude-longitude-input.blade.php
│   ├── map-picker.blade.php
│   └── place-picker.blade.php
└── resources/js/components/
    ├── coordinate-picker-field.js    # Core Lit + Leaflet
    ├── geo-latlng-input.js          # Specialized variant
    ├── map-picker-lit.js            # Specialized variant
    └── place-picker-lit.js          # Specialized variant
```

---

## Architecture Principles

### 1. Single Source of Truth
State lives in Filament form, not duplicated in Alpine or JS.

### 2. Alpine as Bridge Only
Alpine does NOT store state. It only:
- Watches `$wire` for updates
- Calls `$wire.$set()` on user interaction (with `false` defer)
- Listens to custom events from web components

### 3. Light DOM for Leaflet
```javascript
createRenderRoot() {
  return this;  // Light DOM, NOT Shadow DOM
}
```

Why: Leaflet controls need document-level CSS/events.

### 4. Class Selectors Only
```javascript
// ✅ CORRECT
const mapEl = this.querySelector('.map-container');

// ❌ FORBIDDEN
const mapEl = this.querySelector('#map');
```

### 5. Cleanup in disconnectedCallback
```javascript
disconnectedCallback() {
  const mapEl = this.querySelector('.map-container');
  if (mapEl?._leaflet_map) {
    mapEl._leaflet_map.remove();
    mapEl._leaflet_map = null;
  }
}
```

---

## Usage Examples

### CoordinatePicker (Base)

```php
use Modules\Geo\Filament\Forms\Components\CoordinatePicker;

CoordinatePicker::make('coordinates')
    ->defaultLocation(41.9028, 12.4964)  // Roma
    ->zoom(15)
    ->height('400px')
    ->reverseGeocoding(true);
```

### LatitudeLongitudeInput

```php
use Modules\Geo\Filament\Forms\Components\LatitudeLongitudeInput;

LatitudeLongitudeInput::make('location')
    ->hiddenLabel()
    ->defaultCenter(41.9028, 12.4964)
    ->defaultZoom(13)
    ->mapHeight('340px');
```

---

## Data Flow

```
User clicks map
    ↓
Web Component (Lit)
    ↓
Emits `coords-changed` event
    ↓
Alpine bridge captures event
    ↓
Calls `$wire.$set(statePath, {lat, lng}, false)`
    ↓
Livewire updates state (no re-render)
    ↓
$watch triggers → Web Component updates marker
```

---

## Testing

```bash
# Run PHPStan on Geo components
cd laravel
./vendor/bin/phpstan analyze Modules/Geo/app/Filament/Forms/Components --level=5

# Check for ID violations
grep -r "id=\"map\"" Modules/Geo/resources/js/components/
grep -r "getElementById.*map" Modules/Geo/resources/js/components/
```

---

## Related Documentation

- **Golden Rule**: [`docs/rules/leaflet-class-selector.md`](../../../../docs/rules/leaflet-class-selector.md)
- **BMAD Story**: [`.planning/stories/2.1-leaflet-class-selector-golden-rule.story.md`](../../../../.planning/stories/2.1-leaflet-class-selector-golden-rule.story.md)
- **Wiki Index**: [`docs/wiki/index.md`](../../../../docs/wiki/index.md)
- **Wiki Log**: [`docs/wiki/log.md`](../../../../docs/wiki/log.md)

---

## Remember

> **Classes, not IDs. Always.**
