# Geo Module Documentation

Handles geographic data, maps, geocoding, and location-based services.

## 🗺️ Map Components Architecture

### ⚠️ CRITICAL RULES

#### 1. Class Selectors for Leaflet (Golden Rule)
**FORBIDDEN:** `id="map"` | **MANDATORY:** `class="map-container"`
📖 [`docs/rules/leaflet-class-selector.md`](../../../../docs/rules/leaflet-class-selector.md)

#### 2. XotBaseField Extension (CRITICAL)
**FORBIDDEN:** `extends Field` | **MANDATORY:** `extends XotBaseField`
```php
use Modules\Xot\Filament\Forms\Components\XotBaseField;
class CoordinatePicker extends XotBaseField  // ✅ CORRECT
class MapPicker extends XotBaseField         // ✅ CORRECT
```
📖 [`docs/rules/xotbasefield-mandatory.md`](../../../../docs/rules/xotbasefield-mandatory.md)

---

**Quick Reference:**
- ✅ `class="map-container"` + `extends XotBaseField`
- ✅ Custom SVG marker (farmshops-inspired) - local assets only
- ❌ `id="map"` + `extends Field` + Leaflet default markers + unpkg/CDN
- ✅ `MapPicker`, `CoordinatePicker`, `LatitudeLongitudeInput`, `GeopointPicker` → `extends XotBaseField`
- ✅ se `latitude` o `longitude` mancano, il picker tenta geolocalizzazione e valorizza entrambe le coordinate correnti
- ✅ marker `MapPicker` custom locale (`svg/png`) in stile farmshops-like
- ❌ marker default Leaflet / `unpkg` / CDN per il marker runtime
- [`.planning/stories/2.1-leaflet-class-selector-golden-rule.story.md`](../../../../.planning/stories/2.1-leaflet-class-selector-golden-rule.story.md) — BMAD story

## Filament Components

- [AddressInput](address-field-component.md) — Campo indirizzo con geolocalizzazione browser e loading feedback (Filament Form component)
- [Filament form components](filament-forms-components.md) — AddressInput, LatitudeLongitudeInput, LeafletMarkerMapInput

## Actions

- **Geocoding**: `GetCoordinatesAction`, `GetAddressFromNominatimAction`, `ReverseGeocodeAction`
- **Providers**: Bing, Google Maps, Here, Mapbox, LocationIQ, OpenCage, OpenStreetMap, Photon
- **Utilities**: `CalculateDistanceAction`, `ValidateCoordinatesAction`, `FilterCoordinatesInRadiusAction`

## Models

- [Analisi dominio modelli (duplicati logici, quale preferire)](./geo-models-domain-analysis.md)

## Philosophy (Zen Laraxot)

Geo module owns ALL geo-spatial concerns. Other modules (Fixcity, Transport, Logistics) consume Geo components and Actions rather than duplicating geolocation logic.

| Principle | Meaning |
|-----------|---------|
| **Domain ownership** | Geocoding, coordinates, maps, timezone = Geo |
| **Cross-cutting** | Geolocation is NOT app-specific; it's infrastructural |
| **DRY** | One `AddressInput`, many consumers |
| **KISS** | Extend `XotBaseField`, keep one shared PHP base and move special logic into focused traits/components |

## UX Ownership

- Async browser geolocation needs visible busy feedback.
- The `AddressInput` component owns that feedback because it owns the geolocation flow.
- Consumer modules should reuse the component, not reimplement loading UX around it.

## JS Ownership

- Geo can own reusable frontend map components, including Web Components implemented with Lit.
- When a Geo JS component is bundled by the `Sixteen` theme, package resolution happens in the theme Vite pipeline, not in the Geo folder.
- If a Geo JS file uses bare imports like `lit` or `leaflet`, the theme must expose those dependencies through reachable aliases or a shared reachable `node_modules`.
- This prevents Rollup/Vite failures when importing Geo files from outside the theme root.
- If a Geo Web Component wraps a library that depends on global CSS, like Leaflet, prefer light DOM unless the component also reinjects the vendor stylesheet into its shadow root.
