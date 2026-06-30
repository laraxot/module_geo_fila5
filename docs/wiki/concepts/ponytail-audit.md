# Ponytail audit — Geo

**Run:** 2026-06-30

Documento canonico: [ponytail-audit-over-engineering.md](../../ponytail-audit-over-engineering.md)

## Sintesi

- `GeocodingServiceInterface` → già `.bak`
- 7 provider geocoding in loop — YAGNI (un driver da config)
- `LocationDTO` duplicati → `.bak`, usare `LocationData`
