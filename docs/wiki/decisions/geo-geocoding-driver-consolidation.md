---
title: Geocoding — driver configurabile + pulizia duplicati orfani
type: decision
tags: [geo, geocoding, ponytail, config, actions]
created: 2026-06-30
updated: 2026-07-02
qmd: false
issues: https://github.com/laraxot/base_predict_fila5/issues/221
discussions: https://github.com/laraxot/base_predict_fila5/discussions/222
---

# ADR: Geocoding driver configurabile + pulizia duplicati orfani

## Status

Accepted (2026-06-30)

## Contesto

L'audit ponytail (`docs/audit/ponytail-audit.md`, finding G1/G2 in
`Modules/Geo/docs/ponytail-audit-over-engineering.md`) segnala che
`app/Actions/` contiene ~44 action di geocoding multi-provider, dove
l'orchestratore (`GetAddressDataFromFullAddressAction`) prova in sequenza 7
provider hardcoded (Google, Photon, Nominatim, BingMaps, Here, Mapbox,
OpenCage) tramite un array scritto nel codice.

Verifica caller (regola d'oro, `rg` su tutto il repo, non solo su
`Modules/Geo/`): **nessuna** delle ~44 action in `app/Actions/` è invocata da
altri moduli, Blade, Livewire o Filament al di fuori del modulo Geo stesso.
Gli unici chiamanti sono: la catena interna
`GetAddressDataFromFullAddressAction` → 7 provider, qualche action-su-action
interna (es. `CalculateDistanceAction` → `GoogleMaps\CalculateDistanceMatrixAction`),
e i rispettivi test Pest one-to-one. Le mappe in produzione (Theme Two,
Sixteen) usano embed Google Maps lato JS/Blade, non queste action PHP.

Nessuna chiave API risulta configurata in `.env`/`.env.example` del repo per
nessun provider (`google_maps`, `bing_maps`, `mapbox`); questo non esclude
chiavi impostate solo sul server di produzione, quindi non si è assunto che
nessun provider sia "vivo".

## Decisione

1. **Driver configurabile**: aggiunta `geo.driver` (env `GEO_DRIVER`, default
   `google_maps` — stesso ordine preesistente, nessun cambio di
   comportamento runtime) in `Modules/Geo/config/config.php`.
2. **Un solo dispatcher**: `GetAddressDataFromFullAddressAction::execute()`
   antepone il provider preferito (`config('geo.driver')`) alla catena di
   fallback, invece di provarli sempre nello stesso ordine fisso. La mappa
   `provider-key => Action::class` resta letterale dentro l'Action (non in
   config) per un vincolo di type-safety: Larastan tipizza
   `app($class)->execute()` come istanza concreta solo se `$class` è un
   `class-string<T>` letterale risolto nello stesso method-scope del
   try/catch che lo consuma — passarlo attraverso `config()` o un metodo
   separato lo fa collassare a `mixed` (verificato con repro isolati, vedi
   commento nel codice). `geo.driver` resta comunque l'unico punto di
   configurazione per scegliere il provider preferito, da env.
   Nessun'altra action provider è stata toccata: ognuna implementa
   un'integrazione API esterna realmente diversa (firme, parsing risposta,
   campi disponibili differiscono per provider), quindi forzare un'unica
   classe "driver" generica per tutti i 44 file avrebbe richiesto riscrivere
   tutte le integrazioni — fuori scope per un task "senza rompere nulla" e
   YAGNI finché nessuna in produzione le usa comunque.
3. **Duplicati orfani cancellati** dopo verifica con `rg` che non avessero
   alcun chiamante in tutto il repo:
   - **G2**: `app/Actions/Bing/GetAddressFromBingMapsAction.php` — cancellato
     (0 import da altri file, 0 chiamanti). `BingMaps\` (forward geocode)
     resta come unico action Bing. Se serve reverse geocode, si ripristina
     da git o si implementa su richiesta — YAGNI.
   - **G3**: 8 root-level Data duplicati cancellati (`AddressData.php`,
     `GeocodingData.php`, `PlaceData.php`, `ElevationData.php`,
     `ElevationResultDTO.php`, `IPLocationData.php`, `CoordinatesData.php`,
     `RouteData.php`). Identici ai canonicali in `Datas/Geocoding/`,
     `Datas/Elevation/`, `Datas/Location/`, `Datas/Routing/` — 0 import.
   - **G4**: `app/Datatransferobjects/LocationDTO.php` cancellato (duplicato
     esatto di `DataTransferObjects/LocationDTO.php`). Entrambi i LocationDTO
     marcati `@deprecated` → usare `Datas\LocationData` (Spatie Data).
   - I file già gestiti in sessioni precedenti
     (`FilterCoordinatesInRadius.php`, `ClusterLocationsAction.wip`,
     `clusterlocationsaction.wip`) restano nello stato `.bak` precedente.
4. **Risolto** (G2): `Bing\GetAddressFromBingMapsAction` (reverse geocode,
   coordinate → indirizzo) non aveva alcun chiamante in tutto il repo
   (verificato con `rg`). Cancellato. `BingMaps\` resta (forward geocode,
   usato dal dispatcher). Se serve reverse geocode in futuro, si può
   ripristinare da git.

## Conseguenze

- **Positive**: il provider preferito si cambia da env (`GEO_DRIVER`) senza
  toccare codice; zero rischio di rottura perché l'ordine di default replica
  esattamente quello hardcoded precedente; cancellati 1 action duplicato, 8
  Data duplicati, 1 DataTransferObject duplicato; marcati `@deprecated` 2
  LocationDTO.
- **Negative**: le ~40 action provider "vive ma mai chiamate da nessuno"
  restano nel modulo — non sono state toccate perché nessuna era
  funzionalmente ridondante rispetto a un'altra (ogni provider integra
  un'API esterna diversa) e tutte hanno un test Pest dedicato. Una vera
  riduzione del numero di file richiederebbe una decisione di prodotto su
  quali provider servono davvero in produzione (nessuno ha chiavi API
  visibili nel repo).
- **Risolto**: `app/Actions/Bing/GetAddressFromBingMapsAction.php` cancellato
  (0 chiamanti, vedi punto 4). L'ambiguità di naming con `BingMaps\` non è più
  un problema.

## Partecipanti

- Claude (agente di consolidamento, sessioni 2026-06-30 e 2026-07-02)
