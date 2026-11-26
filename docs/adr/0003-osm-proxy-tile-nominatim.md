---
qmd: "adr proxy openstreetmap tile nominatim privacy consenso"
title: "ADR — Tile e geocoding OpenStreetMap passano dal nostro server"
type: decision
module: Geo
tags: [adr, geo, openstreetmap, nominatim, privacy, gdpr, consenso]
created: 2026-11-17
updated: 2026-11-26
status: accepted
decision-makers: [team back office]
issues:
  - "https://github.com/laraxot/theme_sixteen_fila5/issues/106"
related:
  - ../../../Gdpr/docs/stories/dcp-454-terze-parti-prima-del-consenso-gravatar-e-openstreetmap.story.md
  - ../../app/Actions/Osm/FetchOsmTileAction.php
  - ../../app/Actions/Osm/QueryNominatimAction.php
  - ../contracts/fetch-osm-tile-action.md
  - ../contracts/query-nominatim-action.md
  - ../../tests/Feature/OsmProxyTest.php
---

# ADR: tile e geocoding OpenStreetMap passano dal nostro server

## Contesto

- Le mappe del front office (home, elenco, dettaglio, wizard) chiedevano i tile a `{a,b,c}.tile.openstreetmap.org` e gli
  indirizzi a `nominatim.openstreetmap.org` direttamente dal browser: OSMF riceveva l'IP del cittadino prima di ogni scelta
  sui cookie (misurato con Playwright il 2026-11-17).
- LG Muenchen 3 O 17493/20: passare l'IP a un terzo senza consenso e' illecito quando il terzo non serve, perche' il servizio
  si puo' ottenere senza contattarlo. Il titolare e' un Comune: il rischio e la responsabilita' sono suoi.
- La ricerca indirizzi interrogava Nominatim mentre si digitava: la Nominatim Usage Policy vieta l'autocompletamento e chiede
  al massimo 1 richiesta al secondo per l'intera applicazione.
- La mappa e' il cuore del servizio (dove sta il problema): non puo' sparire finche' il cittadino non accetta.

Domanda: come mostrare una mappa e cercare un indirizzo senza che il browser del cittadino contatti OSMF prima del consenso,
restando dentro le policy d'uso di OSMF?

## Driver della decisione

- Privacy: zero richieste a domini terzi prima di una scelta del cittadino (DCP-454, issue theme_sixteen_fila5#106).
- Policy di OSMF: User-Agent identificabile con contatto, cache di almeno 7 giorni con richieste condizionali, nessun
  pre-scaricamento, 1 richiesta al secondo a Nominatim per tutta l'applicazione, niente autocompletamento.
- La mappa deve restare disponibile anche a chi non accetta i cookie (e' il modo di indicare dove sta il problema).
- Costo e manutenzione proporzionati al traffico di un Comune: niente infrastruttura di tile da gestire per ogni installazione.
- Il geocoding deve potersi spegnere senza deploy, come chiede la Nominatim Usage Policy.

## Alternative scartate

- Mappa dietro il banner dei cookie: il cittadino che non accetta non puo' indicare dove sta il problema, cioe' non puo' usare
  il servizio.
- Lasciare e dichiarare in informativa: per lo stesso schema la giurisprudenza tedesca ha ritenuto illecito il trasferimento
  non necessario; e l'autocompletamento resterebbe vietato dalla policy di Nominatim.
- Server di tile proprio (OpenMapTiles, tileserver): nessun terzo, ma servono decine di GB di dati e un servizio da mantenere
  per ogni installazione; sproporzionato per il traffico di un Comune.
- Fornitore commerciale (Mapbox, MapTiler): sposta l'IP a un altro terzo, aggiunge un contratto e una chiave.

## Decisione

- Tile e Nominatim passano da rotte API del modulo Geo (`/api/geo/tiles/osm/...`, `/api/geo/nominatim/{search,reverse}`),
  senza sessione: il browser parla solo con il nostro dominio.
- Il server rispetta le policy di OSMF: User-Agent con contatto, Referer inoltrato, cache su disco di almeno 7 giorni con
  richieste condizionali, 1 richiesta al secondo a Nominatim, cache dei risultati, parametri filtrati.
- La ricerca parte solo con Invio o con il pulsante.
- Il modulo resta agnostico: il proxy si usa solo se il layout lo dichiara su `<html data-geo-tile-url data-geo-nominatim-url>`;
  Nominatim si spegne da configurazione (`geo.config.osm_proxy.nominatim.enabled`), senza deploy.

## Conseguenze

- Pro: zero richieste a domini terzi prima della scelta (13 pagine misurate); mappa piu' veloce (tile dallo stesso dominio, in
  cache: 0,19 s contro 0,69 s alla prima richiesta); meno carico su OSMF; conformita' alle policy di tile e Nominatim.
- Contro: il nostro server porta il traffico dei tile e occupa disco (`storage/app/geo/osm-tiles`, cresce con le zone viste);
  la Tile Usage Policy dice che un proxy e' «generally not recommended»: se OSMF lo chiedesse, si cambia `tiles.upstream`.
- Gli strati scelti esplicitamente dal cittadino (satellitare e topografico Esri, umanitario OSM France) restano diretti: partono
  solo per una sua scelta, e informativa e cookie policy lo dicono.
- Da fare se il traffico cresce: pulizia periodica della cache dei tile piu' vecchi; valutare un tile server proprio.
- La regola vale solo dove il browser usa gli indirizzi risolti da `endpoints.js`: ogni componente che scrive a mano un URL di
  OSMF la aggira (vedi «Stato attuale»).

## Conferma

- `cd laravel && vendor/bin/pest Modules/Geo/tests/Feature/OsmProxyTest.php` (8 test): tile servito dal nostro dominio
  senza cookie con User-Agent e Referer, cache di almeno 7 giorni con richiesta condizionale, copia scaduta se OSM è giù,
  404 fuori griglia senza chiamare OSM, Nominatim in JSON con parametri filtrati e cache, 422 senza chiamata, spegnimento
  da config (503), mai più di 1 richiesta al secondo. Le singole regole hanno un group: vedi le tabelle Invarianti di
  [FetchOsmTileAction](../contracts/fetch-osm-tile-action.md) e [QueryNominatimAction](../contracts/query-nominatim-action.md)
  (`--group=GEO-TILE-INV-<N>`, `--group=GEO-NOMINATIM-INV-<N>`).
- `cd laravel && vendor/bin/pest Themes/Sixteen/tests/Feature/NoThirdPartyBeforeConsentTest.php` (e l'analogo in
  `Themes/Civic/tests/Feature/`): ogni pagina del tema dichiara `data-geo-tile-url` e `data-geo-nominatim-url` su `<html>` e
  non contiene `tile.openstreetmap.org` ne' `nominatim.openstreetmap.org`.
- Throttle delle rotte: `throttle:1200,1` (tile) e `throttle:30,1` (Nominatim) in `Modules/Geo/routes/api.php`.
- Solo revisione: che nessun componente JS o vista Blade chiami OSMF scrivendo l'URL a mano: nessun test controlla le
  richieste del browser ne' i sorgenti JS. Controllo a mano, da `laravel/Modules/Geo`: il comando riportato in «Stato attuale»
  deve elencare solo `resources/js/components/map/endpoints.js` (l'unico che nomina OSMF, come ripiego); oggi ne elenca 45.

## Stato attuale

Misurato il 2026-11-26 sul codice. La decisione vale per il percorso principale e non per tutto il modulo.

- **Rispettata**: il componente montato dal pannello, `resources/js/components/coordinate-picker-lit.js` (entrata Vite in
  `vite.config.js:48`), importa `map/events.js` e `map/controls/search.js`, che risolvono tile e Nominatim con
  `osmTileUrl()` e `nominatimUrl()` di `resources/js/components/map/endpoints.js`. I due layout dei temi (`Themes/Sixteen` e
  `Themes/Civic`, `components/layouts/main.blade.php:57`) dichiarano gli attributi `data-geo-*` su `<html>`.
- **Contraddetta**: `endpoints.js` ricade sugli indirizzi pubblici di OSMF (`endpoints.js:10-11`) quando il layout non
  dichiara gli attributi, e **44 file** sotto `resources/` (oltre a `endpoints.js`: 21 `.js`, 16 `.vue`, 7 `.blade.php`)
  scrivono ancora a mano un URL di OSMF; 13 file nominano Nominatim. Comando (45 risultati, `endpoints.js` incluso):
  `rg -l "https?://(\{s\}\.|[abc]\.)?(tile\.openstreetmap\.org|tile\.osm\.org|nominatim\.openstreetmap\.org)" resources --glob '!**/leaflet-src.js*' --glob '!**/*.min.js' --glob '!**/index.html'`.
  Solo 4 file usano `endpoints.js` (`components/map/layers.js:1`, `components/map-picker-layers.js:1`,
  `components/map/reverse-geocode.js:5`, `components/map/controls/search.js:6`).
- Chiamate dirette a OSMF dal browser (Nominatim e tile), tra le altre: `resources/js/filament/map-picker.js:18` (geocodifica inversa) e
  `:167` (tile); `resources/js/components/map-picker-lit.js:282` (ricerca) e `:183` (tile);
  `resources/js/components/map-positioner-lit.js:394` (ricerca) e `:286` (tile); `resources/js/components/coordinate-picker.js:214`
  e `:161`; `resources/js/components/geo-map-picker-field.js:79`; `resources/js/components/map-picker-search.js:6`; le viste
  `resources/views/filament/forms/components/address-input.blade.php:104`,
  `resources/views/filament/components/address-field.blade.php:60`,
  `resources/views/components/geolocation/address-field.blade.php:76`,
  `resources/views/filament/widgets/base-map.blade.php:233` e `resources/views/filament/forms/components/location-map.blade.php:61`.
- Parte di questi file sono probabili varianti storiche (i 16 componenti `.vue`, `coordinate-picker-lit-stable.js`): questa
  passata non ha verificato se qualche pagina li monta; se lo fanno, il browser contatta OSMF anche con il layout dei temi.
- Lato server la regola «il server rispetta le policy di OSMF» non vale per la catena di geocodifica delle Action:
  `Nominatim/GetAddressFromNominatimAction.php:35-36` (User-Agent fisso `Xot/1.0`) e `GetCoordinatesByAddressAction.php:42,261`
  (`Http::get` senza intestazioni, riga 145) chiamano Nominatim senza il limitatore a 1 richiesta al secondo, senza cache e senza
  l'interruttore `geo.config.osm_proxy.nominatim.enabled`; contratti:
  [GetAddressFromNominatimAction](../contracts/get-address-from-nominatim-action.md),
  [GetCoordinatesByAddressAction](../contracts/get-coordinates-by-address-action.md).
- Decisione che serve (non presa qui, il codice non e' stato toccato): far passare tutti i componenti da `endpoints.js`
  e togliere le varianti non usate, oppure dichiarare che il proxy vale solo per i componenti del front office e
  spostare i restanti in un modulo di back office. Finche' non c'e' un test sui sorgenti, il comando sopra e' l'unico controllo.
