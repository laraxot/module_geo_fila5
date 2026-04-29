# Story: GeoMapWidget - Interactive GIS Map Widget

## Story ID
geo-mapwidget-001

## Project
GEO Module - Interactive Map Widget

## Context
Creare un Filament v5 widget avanzato per visualizzazione mappa GIS nel modulo GEO, studiando e replicando il pattern del progetto farmshops.eu (CodeforKarlsruhe).

Il widget deve mostrera una mappa Leaflet con:
- Caricamento GeoJSON statico (max ~3000 punti, single load)
- Clustering con leaflet.markercluster
- LOD (Level of Detail): cluster < zoom 12, categoria aggregata zoom 12-15, dettaglio zoom >15
- Stateful client senza reload
- Multi-layer system (points, cluster, heatmap, zones/polygons)
- Layer UI attivabili/disattivabili combinabili
- Marker click -> popup, selezione, sync stato interno
- Client-side filtering
- Web Component Lit per isolamento
- npm/vite build (NO CDN)

## Reference Study: farmshops.eu Pattern

### Key Components (from direktvermarkter.js)
1. **Map Initialization**: Leaflet with permalink support for URL state
2. **ExtraMarkers**: Different icons for farm, vending_machine, marketplace, beekeeper
3. **GeoJSON Layer**: L.geoJson with pointToLayer custom icons
4. **Clustering**: L.markerClusterGroup with dynamic radius (80 at zoom<12, 45 at zoom>=12)
5. **Cluster Icons**: Custom HTML with farm/market/machine/beekeeper type indicators
6. **Layer Control**: L.control.layers for OSM/Satellite toggle
7. **Locate Control**: Geolocation button
8. **Sidebar**: For details panel
9. **Popup**: Dynamic content loading via AJAX on click (lazy loading)

### Data Pattern
- GeoJSON importato statico (farmShop GeoJson object nel codice)
- Lazy loading dettagli: layer.once("click") -> $.getJSON('data/' + id + '/details.json')
- Proprieta JSON: p (type: farm/vending_machine/marketplace/beekeeper), id

### Libraries Used
- leaflet.js (core)
- leaflet.extra-markers (custom markers)
- leaflet.markercluster (clustering)
- leaflet.permalink (URL state sharing)
- leaflet.sidebar-v2 (details panel)
- leaflet.locatecontrol (geolocation)

## Architecture

### Files Structure (in GEO Module)
```
app/Filament/Widgets/
  GeoMapWidget.php           # Widget base class

resources/views/filament/widgets/
  geo-map.blade.php          # Main widget view with Lit component

resources/js/components/
  GeoMapWidget.ts            # Lit Web Component
```

### Data Pattern (for 3000 points)
```typescript
// GeoJSON FeatureCollection structure
interface GeoJsonFeature {
  type: "Feature";
  geometry: { type: "Point"; coordinates: [lng, lat] };
  properties: {
    id: string;
    p: "farm" | "vending_machine" | "marketplace" | "beekeeper";
    name: string;
    // ... other fields
  };
}
```

### Layer Types
1. **points**: Raw markers at zoom >= 15
2. **cluster**: MarkerClusterGroup at zoom < 15
3. **heatmap**: Heatmap layer (optional, using heatmap.js or alternative)
4. **zones**: Polygon zones layer (optional)

### LOD Logic
- zoom < 12: Show clusters with count only
- zoom 12-14: Show clusters with category icons inside
- zoom >= 15: Show individual points

## Implementation Tasks

### PHASE 1: Widget Base + View
- [ ] Create GeoMapWidget.php extending XotBaseTableWidget
- [ ] Configure default query scope
- [ ] Create geo-map.blade.php with Alpine init

### PHASE 2: Lit Web Component
- [ ] Implement GeoMapWidget.ts (LitElement)
- [ ] Add Leaflet initialization with proper layers
- [ ] Implement ExtraMarkers icons for categories
- [ ] Add markerClusterGroup with LOD logic
- [ ] Add layer activation/deactivation system

### PHASE 3: Features
- [ ] Add popup rendering system
- [ ] Add selection state management
- [ ] Add client-side filtering
- [ ] Add layer switching UI
- [ ] Implement cluster custom icons (category indicators)

### PHASE 4: Data + Performance
- [ ] Create sample GeoJSON data structure
- [ ] Implement performance optimizations
- [ ] Add memoization for filter operations

## Acceptance Criteria

### Must Have
- [ ] Widget displays interactive Leaflet map
- [ ] GeoJSON points render with custom icons by category
- [ ] Clustering works with dynamic radius
- [ ] LOD logic: clusters at low zoom, detail at high zoom
- [ ] Layer toggle UI (points/clusters/heatmap/zones)
- [ ] Marker click shows popup with details
- [ ] Client-side filtering by category works
- [ ] Selection state syncs internally
- [ ] NO CDN dependencies (via npm/Vite)

### Should Have
- [ ] Permalink support for URL state
- [ ] Geolocation button
- [ ] Heatmap layer
- [ ] Zone/polygon layer support

### Quality
- [ ] PHPStan passes (Level max)
- [ ] PHPMD passes (no violations)
- [ ] PHP Insights passes
- [ ] Pest tests pass

## Dependencies (from npm)
- leaflet
- leaflet.markercluster
- leaflet.extra-markers (or custom icon solution)

## Dev Notes

### Pattern from farmshops
1. Use window.L for Leaflet global (after import)
2. Implement custom pointToLayer for icon selection
3. Use getAllChildMarkers() for cluster content analysis
4. Implement iconCreateFunction for custom cluster HTML
5. Lazy load details on marker click

### Performance Optimizations
1. Single GeoJSON load at initialization
2. Memoize filter results
3. Use requestAnimationFrame for map events
4. Debounce filter inputs
5. Use WebglHeatmap for large datasets (optional)