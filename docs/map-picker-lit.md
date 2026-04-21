# MapPickerLit Component Implementation

## Overview

This document describes the implementation of the `map-picker-lit` web component - a custom interactive map picker using Lit.js and Leaflet.js, integrated with Filament forms.

## Component Structure

### File Location
- **Source**: `/var/www/_bases/base_fixcity_fila5/laravel/Modules/Geo/resources/js/components/map-picker-lit.js`
- **Built Output**: `/var/www/_bases/base_fixcity_fila5/laravel/Modules/Geo/resources/dist/js/geo.js`
- **Blade View**: `/var/www/_bases/base_fixcity_fila5/laravel/Modules/Geo/resources/views/filament/forms/components/map-picker.blade.php`

### Key Features

1. **Light DOM**: `createRenderRoot()` returns `this` so Leaflet tiles, controls and fullscreen interact predictably with Filament/Livewire (avoids common Shadow DOM stacking issues).
2. **Interactive Map**: Uses Leaflet.js for mapping functionality
3. **Custom SVG Marker**: Inline SVG marker (no external image dependencies)
4. **Custom Controls**: Locate me, fullscreen, layer switch using L.Control with click propagation disabled on the toolbar (usable in fullscreen, farmshops-like)
5. **Search**: Address search via Nominatim OpenStreetMap
6. **Events**: Dispatches `coords-changed` when coordinates update
7. **External API**: `setCoordinatesFromExternal()` for programmatic coordinate setting
8. **Pending Coords**: Handles coordinates set before map initialization

## Usage

### HTML Element

```html
<map-picker-lit
    id="my-map"
    lat="41.9028"
    lng="12.4964"
    zoom="13"
    height="400px"
    show-search="true"
></map-picker-lit>
```

### Listening for Coordinate Changes

```javascript
document.getElementById('my-map').addEventListener('coords-changed', (event) => {
    const { lat, lng, source } = event.detail;
    console.log(`Coordinates updated: ${lat}, ${lng} (source: ${source})`);
});
```

### Setting Coordinates Programmatically

```javascript
const mapElement = document.getElementById('my-map');
// Call the public method to set coordinates
mapElement.setCoordinatesFromExternal(41.9028, 12.4964);
```

## Properties

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| lat | Number | null | Latitude coordinate |
| lng | Number | null | Longitude coordinate |
| zoom | Number | 13 | Map zoom level |
| height | String | '400px' | Map container height |
| showSearch | Boolean | true | Show/hide address search box |

## Events

### coords-changed

Fired when coordinates are updated via marker drag, map click, search, or geolocation.

```javascript
detail: {
    lat: number;      // Latitude
    lng: number;      // Longitude
    source: string;   // 'drag' | 'click' | 'search' | 'geolocation' | 'external'
}
```

## Public Methods

### setCoordinatesFromExternal(lat, lng)

Programmatically set marker position. Handles coordinates set before map initialization via pending coords pattern.

```javascript
element.setCoordinatesFromExternal(41.9028, 12.4964);
```

**Features:**
- Normalizes input to numbers
- Ignores if already syncing from external (prevents loops)
- Stores coords as pending if map not ready
- Updates marker position and map view when ready

## Custom SVG Marker

The component uses an inline SVG marker (no external image files required):

```svg
<svg width="35" height="45" viewBox="0 0 35 45" fill="none">
  <path d="M17.5 0C7.835 0 0 7.835 0 17.5C0 30.625 17.5 45 17.5 45C17.5 45 35 30.625 35 17.5C35 7.835 27.165 0 17.5 0Z" fill="#EF4444"/>
  <circle cx="17.5" cy="17.5" r="9.5" fill="#FFFFFF"/>
  <circle cx="17.5" cy="17.5" r="5" fill="#EF4444"/>
</svg>
```

**Benefits:**
- Works after bundling (no path issues)
- Fully customizable via CSS
- Consistent rendering across browsers

## Custom Controls

Controls are implemented as Leaflet `L.Control` classes, ensuring they persist during fullscreen mode:

1. **Locate Me** (top-right): GPS geolocation button
2. **Fullscreen** (top-right): Toggle fullscreen mode
3. **Layer Switch** (top-right): Toggle between street/satellite views
4. **Zoom** (bottom-right): Built-in Leaflet zoom controls
5. **Scale** (bottom-left): Metric scale bar

## Build Process

1. **Source**: component in `resources/js/components/map-picker-lit.js`, entry `resources/js/app.js`
2. **Build**: da `laravel/Modules/Geo` eseguire `npm run production` (Laravel Mix → `resources/dist/js/geo.js`)
3. **Deploy**: copiare `resources/dist/js/geo.js` in `public_html/themes/Geo/js/geo.js` (e, se usi `laravel/public` come web root, anche `laravel/public/themes/Geo/js/geo.js`)
4. **Load**: Filament registra `asset('themes/Geo/js/geo.js')` in `GeoServiceProvider` (insieme a Leaflet da unpkg)

Se in console compare `DomUtil.disableClickPropagation is not a function`, il bundle servito è obsoleto rispetto ai sorgenti: Leaflet 1.9+ espone `disableClickPropagation` su `L.DomEvent`, non su `L.DomUtil`. Ricompilare e ridistribuire `geo.js`.

## Integration with Filament

The Blade view (`map-picker.blade.php`) provides Alpine.js integration:

```blade
<x-geo::map-picker
    :value="$getState()"
    wire:modelable="value"
/>
```

**Alpine.js Integration:**
- Uses `x-data` to manage state
- Wire modelable for Livewire compatibility
- Calls `setCoordinatesFromExternal()` on Alpine state change
- Handles `@coords-changed` event from web component

## Browser Support

- Modern browsers with ES6+ support
- Leaflet.js for map rendering
- Lit.js for web component lifecycle
- Shadow DOM for style isolation

## Performance Considerations

1. **Lazy Loading**: Leaflet and CSS imported dynamically
2. **Event Debouncing**: Coordinates sync with 100ms debounce
3. **Shadow DOM**: Scoped styles prevent conflicts
4. **Cleanup**: Proper disposal in `disconnectedCallback`
5. **Resize Handling**: ResizeObserver for container size changes

## Troubleshooting

### Map doesn't render
- Verify `geo.js` is loaded in the page
- Check browser console for errors
- Ensure Leaflet CSS is loaded

### Marker not visible
- Verify coordinates are valid numbers
- Check if map is initialized before setting coords
- Use `setCoordinatesFromExternal()` instead of direct property setting

### Coordinates not syncing
- Ensure `coords-changed` event listener is set up correctly
- Check if `_isSyncingFromExternal` flag is causing loops
- Verify wire:modelable binding is correct for Livewire

## Changelog

### 2026-04-17
- Added `setCoordinatesFromExternal()` public method
- Added pending coords pattern for early coordinate setting
- Implemented custom SVG marker with inline SVG
- Added custom controls (locate me, fullscreen, layer switch) using L.Control
- Fixed fullscreen handling with ResizeObserver
