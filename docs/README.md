# Geo Module Documentation

Handles geographic data, maps, geocoding, and location-based services.

## Filament Components

- [AddressInput](address-field-component.md) — Campo indirizzo con geolocalizzazione browser e loading feedback (Filament Form component)

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
| **KISS** | Extend `Field`, not complex Blade wrappers |

## UX Ownership

- Async browser geolocation needs visible busy feedback.
- The `AddressInput` component owns that feedback because it owns the geolocation flow.
- Consumer modules should reuse the component, not reimplement loading UX around it.
