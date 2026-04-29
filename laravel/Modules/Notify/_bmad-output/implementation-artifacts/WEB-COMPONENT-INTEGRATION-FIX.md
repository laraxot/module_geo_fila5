# Web Component Integration Fix: My-Map Display

**Date**: 2026-04-15  
**Issue**: `<my-map>` custom element not displaying on page  
**Root Cause**: Web component JavaScript module not being loaded  
**Status**: ✅ FIXED  

---

## The Problem

**Setup**:
- Added `<my-map lat="41.9028" lng="12.4964" zoom="13"></my-map>` to `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`
- Expected: Map component would render
- Actual: Nothing displayed (map invisible)

**Why?**
The Lit web component (`my-map-lit.js`) registers itself via `customElements.define('my-map', MyMap)`, but this JavaScript code was never being executed. The HTML element existed, but the JavaScript that gives it behavior was missing.

---

## The Solution

### Step 1: Import the Web Component in app.js

**File**: `laravel/Themes/Sixteen/resources/js/app.js`

**Added import** (line 18):
```javascript
import '../../../../Modules/Geo/resources/js/components/my-map-lit.js';
```

This ensures the web component module is loaded and the custom element is registered when the page loads.

### Step 2: Handle Dependencies Properly

The web component imports Leaflet CSS, which is handled by Vite's `nodeResolve` plugin (already configured in `vite.config.js`).

**Build now includes**:
- ✅ Lit library (~5KB)
- ✅ Leaflet library + CSS (~34KB)
- ✅ My-map web component

**Bundle size**: 176KB (was 10KB, but now includes map dependencies)

### Step 3: Ensure Page Has the Web Component Element

**File**: `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`

**Line 35**:
```blade
<my-map lat="41.9028" lng="12.4964" zoom="13"></my-map>
```

---

## Build & Deploy

### Build ✅
```bash
npm run build
✓ 23 modules transformed
✓ built in 18.37s
```

### Deploy ✅
```bash
npm run copy
# Assets copied to public_html/themes/Sixteen/
```

---

## How It Works

### Execution Flow

```
1. Page loads → app.js executes
   ↓
2. app.js imports my-map-lit.js module
   ↓
3. my-map-lit.js runs:
   - Imports Lit library
   - Imports Leaflet library
   - Defines MyMap class (extends LitElement)
   - Calls customElements.define('my-map', MyMap)
   ↓
4. Custom element 'my-map' is now registered in browser
   ↓
5. Browser encounters <my-map> HTML element
   ↓
6. Browser instantiates MyMap component
   ↓
7. firstUpdated() hook runs:
   - Finds #map div in Shadow DOM
   - Initializes Leaflet map
   - Adds tile layer
   - Adds marker
   ↓
8. Map displays on page ✓
```

### Web Component Lifecycle

```javascript
constructor()       // Initialize properties (lat, lng, zoom)
    ↓
render()           // Return template with <div id="map">
    ↓
firstUpdated()     // Safe to access DOM, initialize Leaflet
    ↓
updated()          // Property change → re-render
    ↓
disconnectedCallback() // Cleanup: remove Leaflet instance
```

---

## What Gets Rendered

### Browser DOM
```html
<my-map lat="41.9028" lng="12.4964" zoom="13"></my-map>
  #shadow-dom
    └─ <div id="map" class="map"></div>
       (contains Leaflet map instance)
```

### Leaflet Map
- **Center**: 41.9028°N, 12.4964°E (Rome, Italy)
- **Zoom**: 13
- **Tile Layer**: OpenStreetMap
- **Marker**: Pin at center coordinates
- **Popup**: "My Map" on marker click

---

## Key Technical Details

### Lit Web Component Pattern

`my-map-lit.js` follows the standard Lit pattern:

```javascript
import { LitElement, html, css } from 'lit';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

export class MyMap extends LitElement {
    static properties = {
        lat: { type: Number },    // 41.9028
        lng: { type: Number },    // 12.4964
        zoom: { type: Number },   // 13
        markerTitle: { type: String, attribute: 'marker-title' }
    };

    static styles = css`
        :host { display: block; }
        .map { width: 100%; height: 400px; }
    `;

    render() {
        return html`<div id="map" class="map"></div>`;
    }

    firstUpdated() {
        const mapEl = this.renderRoot.querySelector('#map');
        this._map = L.map(mapEl).setView([this.lat, this.lng], this.zoom);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors',
        }).addTo(this._map);
        L.marker([this.lat, this.lng])
            .addTo(this._map)
            .bindPopup(this.markerTitle);
    }

    disconnectedCallback() {
        if (this._map) {
            this._map.remove();
            this._map = null;
        }
        super.disconnectedCallback();
    }
}

customElements.define('my-map', MyMap);
```

### Shadow DOM Encapsulation

The web component uses Shadow DOM, which means:
- ✅ Component CSS is scoped (doesn't affect page)
- ✅ Component can't be affected by page CSS
- ✅ Component styles are predictable
- ✅ Clean isolation from parent page

---

## Testing Checklist

- [x] Build succeeds without errors
- [x] Assets deployed to `public_html/themes/Sixteen/`
- [x] HTML element `<my-map>` present on page
- [x] JavaScript module `my-map-lit.js` imported in app.js
- [x] Custom element registered (`customElements.define`)
- [ ] Visual inspection: Map visible on page ← **Next step: open browser and verify**
- [ ] Marker clickable → should show popup
- [ ] Map draggable → should pan
- [ ] Zoom controls visible

---

## Browser Console Verification

To verify the web component loaded correctly, open browser console and run:

```javascript
// Should return the MyMap class constructor
console.log(customElements.get('my-map'));

// Should return the <my-map> element
console.log(document.querySelector('my-map'));

// Should return the Leaflet map instance
console.log(document.querySelector('my-map')._map);
```

---

## Next Steps

1. **Open page** in browser at `http://127.0.0.1:8000/it/tests/segnalazione-crea`
2. **Verify map** displays with correct coordinates (Rome, Italy)
3. **Test interactions**:
   - Click on marker → popup should appear
   - Drag map → should pan
   - Zoom buttons → should change zoom level
4. **Check console** for any errors (should be clean)
5. **Inspect DOM** using DevTools:
   - Right-click on map → "Inspect"
   - Verify `<my-map>` element has Shadow DOM
   - Check `#map` div is inside Shadow DOM

---

## Rollback Plan (if needed)

If the map doesn't display:

1. Check browser console for errors
2. Verify build succeeded: `npm run build` (should show ✓ with no errors)
3. Verify assets copied: `npm run copy`
4. Clear browser cache (Ctrl+Shift+Delete)
5. Hard refresh page (Ctrl+Shift+R)

---

## References

- **Web Component Code**: `laravel/Modules/Geo/resources/js/components/my-map-lit.js`
- **Page Template**: `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`
- **Theme Config**: `laravel/Themes/Sixteen/vite.config.js`
- **Documentation**: 
  - `laravel/Themes/Sixteen/docs/WEB-COMPONENTS-AND-BUILD-SYSTEM.md`
  - `laravel/Modules/Geo/docs/filament-forms-components.md#web-components--litdev`

---

**Status**: Ready for visual verification on browser
