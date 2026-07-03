# Ponytail audit — Geo (over-engineering)

**Ultimo run:** 2026-07-02  
**Modulo:** geocoding, mappe, indirizzi.  
**Hub:** [../../../../docs/audit/ponytail-audit.md](../../../../docs/audit/ponytail-audit.md)  
**Remediation:** [../../../../docs/project/ponytail-audit-remediation.md](../../../../docs/project/ponytail-audit-remediation.md)  
**GitHub monorepo:** [Issue #221](https://github.com/laraxot/base_quaeris_fila5/issues) · [Discussion #222](https://github.com/laraxot/base_quaeris_fila5/discussions) · [Discussion #228](https://github.com/laraxot/base_quaeris_fila5/discussions)

## Scopo business

Un indirizzo in ingresso → coordinate e dati strutturati. In produzione serve **un** provider configurato; sette provider in cascata è fallback speculativo che moltiplica manutenzione e test.

## Findings ranked

| # | Tag | Cosa tagliare | Stato | Path |
|---|-----|---------------|-------|------|
| G1 | `yagni` | 7 provider in loop in `GetAddressDataFromFullAddressAction` | ✅ Commento `ponytail:` aggiunto. `config('geo.driver')` anteposto ai fallback. Dispatcher driver-based già attivo | `app/Actions/GetAddressDataFromFullAddressAction.php` |
| G2 | `shrink` | doppio `GetAddressFromBingMapsAction` (`Bing/` vs `BingMaps/`) | ✅ `Bing/` **cancellato** (0 chiamanti, duplicato funzionale — solo reverse geocode, nessun import da altri file) | `app/Actions/Bing/` |
| G3 | `yagni` | 12+ classi Data micro-granulari | ✅ 8 root-level Data duplicati **cancellati** (identici ai canonicali in sottodirectory, 0 import). Commenti `ponytail:` aggiunti ai canonicali | `app/Datas/` |
| G4 | `yagni` | `LocationDTO` vs `LocationData` | ✅ Entrambi i LocationDTO marcati `@deprecated` → usare `LocationData`. Lowercase `datatransferobjects/` cancellato (duplicato esatto) | `app/Datas/LocationDTO.php`, `app/DataTransferObjects/LocationDTO.php` |
| G5 | `delete` | `GeocodingServiceInterface` | ✅ Già assente (0 implementazioni, 0 import, verificato) | `app/Contracts/` |

## Contesto runtime

`GetAddressDataFromFullAddressAction` prova in sequenza: Google, Photon, Nominatim, BingMaps, Here, Mapbox, OpenCage. Lazy: un driver + retry opzionale, non un foreach di classi hardcoded.

## Azione eseguita

1. **G1**: Aggiunto commento `ponytail:` su driver config path. `config('geo.driver')` già anteposto ai fallback nel dispatcher.
2. **G2**: Cancellato `app/Actions/Bing/GetAddressFromBingMapsAction.php` e relativi test — duplicato di `BingMaps\`, 0 import, 0 chiamanti.
3. **G3**: Cancellati 8 root-level Data duplicati: `AddressData`, `GeocodingData`, `PlaceData`, `ElevationData`, `ElevationResultDTO`, `IPLocationData`, `CoordinatesData`, `RouteData`. Identici ai canonicali in sottodirectory.
4. **G4**: Cancellato `app/Datatransferobjects/LocationDTO.php` (duplicato esatto). Marcati `@deprecated` sia `Datas\LocationDTO` che `DataTransferObjects\LocationDTO` → puntano a `Datas\LocationData`.
5. **G5**: Verificato assente — `GeocodingServiceInterface` già cancellato in sessioni precedenti.
6. **PHP lint**: tutti i file modificati superano `php -l`.

## Collegamenti

- [00-INDEX.md](./00-INDEX.md)
- [module-philosophy.md](./module-philosophy.md)
- [ADR: geocoding driver consolidation](../wiki/decisions/geo-geocoding-driver-consolidation.md)
- [Notify audit](../../Notify/docs/ponytail-audit-over-engineering.md) (stesso pattern multi-provider)
