---
title: "ADR del modulo Geo"
type: index
tags: [adr, decisioni, geo]
created: 2026-11-18
<<<<<<< .merge_file_e22MI5
updated: 2026-11-24
=======
updated: 2026-11-26
>>>>>>> .merge_file_eibxVy
---

# ADR del modulo Geo

<<<<<<< .merge_file_e22MI5
Il **perché** delle forme di codice di Geo che sembrano strane e che un agente rischia di "semplificare": il proxy
OpenStreetMap lato server (privacy e policy di OSMF), la mappa dei provider di geocodifica scritta dentro l'Action
(vincolo di PHPStan), i componenti mappa Lit in Light DOM (stabilità nei wizard Livewire).
=======
Il **perche'** delle forme di codice di Geo che sembrano strane e che un agente rischia di "semplificare": il proxy
OpenStreetMap lato server (privacy e policy di OSMF) e la sua cache delle rotte, la mappa dei provider di geocodifica scritta
dentro l'Action (vincolo di PHPStan), i componenti mappa Lit in Light DOM (stabilita' nei wizard Livewire), le integrazioni
HTTP come Actions invece che Services. Una decisione per file, con le alternative scartate; il nome del file e' `NNNN-argomento.md`,
senza date (la data sta nella frontmatter).

Leggili prima di: far chiamare al browser un servizio di mappe esterno, spostare la scelta dei provider in config o
aggiungerne uno, scrivere o copiare un componente mappa JS, aggiungere una classe in `app/Services`.

## Metodo

Scrivere un ADR solo per una scelta difficile da invertire, sorprendente o fondata su un trade-off reale; non e' un diario ne'
una spiegazione retroattiva inventata. Le decisioni si verificano contro codice e test correnti. Una modifica sostanziale crea
un nuovo ADR e segna il precedente `superseded` o `deprecated`. Se il codice di oggi contraddice la decisione, l'ADR non si
riscrive: si aggiunge `## Stato attuale` con la prova (file e riga). Regole: [action-behavioral-contract](../../../Xot/docs/rules/action-behavioral-contract.md)
e [ADR di Xot](../../../Xot/docs/adr/README.md).
>>>>>>> .merge_file_eibxVy

Leggili prima di: far chiamare al browser un servizio di mappe esterno, spostare la scelta dei provider in config o
aggiungerne uno, scrivere o copiare un componente mappa JS.

<<<<<<< .merge_file_e22MI5
Formato (cinque sezioni, `type: decision`, nome file senza date né numeri) e regole:
[action-behavioral-contract](../../../Xot/docs/rules/action-behavioral-contract.md). Chi cambia una decisione scrive un
nuovo ADR e segna il vecchio `status: superseded`.
=======
Frontmatter: `title`, `type: decision`, `status`, `module`, `decision-makers`, `created`, `updated`. Sezioni in quest'ordine
([modello](0000-template.md)):

1. `## Contesto` - fatti e vincoli, chiusi dalla domanda a cui l'ADR risponde.
2. `## Driver della decisione`
3. `## Alternative scartate` - ogni alternativa seria con il motivo.
4. `## Decisione` - cosa si fa, in concreto, e dove sta nel codice.
5. `## Conseguenze` - buone e cattive, debito che resta.
6. `## Conferma` - un test esistente, un comando eseguibile da `laravel/`, o «Nessuna conferma automatica oggi; proposta: ...».
7. `## Stato attuale` - solo se il codice contraddice la decisione.

## Indice

| File | Stato | Decisione | Conferma |
|---|---|---|---|
| [0001-map-components-lit-light-dom](0001-map-components-lit-light-dom.md) | accepted | Componenti mappa Lit in Light DOM; il pane Leaflet e' protetto da `guard`, `ResizeObserver` richiama `invalidateSize`. | solo revisione, con proposta di spec Playwright |
| [0002-geocoding-preferred-provider-with-fallback](0002-geocoding-preferred-provider-with-fallback.md) | accepted | `geo.driver` sceglie il primo provider, poi fallback letterale; la mappa resta nel metodo per restare tipizzata. | Pest `--group=GEO-GEOCODE-INV-1`, `-2`, `-3`; PHPStan |
| [0003-osm-proxy-tile-nominatim](0003-osm-proxy-tile-nominatim.md) | accepted | Tile e geocoding OpenStreetMap passano dal nostro server: il browser parla solo con il nostro dominio. | Pest `OsmProxyTest` e `NoThirdPartyBeforeConsentTest` dei temi |
| [0004-no-service-geo-integrations](0004-no-service-geo-integrations.md) | accepted | Le integrazioni geografiche sono Queueable Actions, non Services; `BaseGeoService` va rimosso. | Pest `NoServicesTest` e Arch (oggi violata, vedi sotto) |
| [0005-route-cache-includes-proxy](0005-route-cache-includes-proxy.md) | accepted | Il deploy rigenera la cache delle rotte con `route:trans:cache`; un 404 HTML su una tile segnala una cache obsoleta. | controllo di deploy (`route:list`) e `OsmProxyTest` |
| [geo-uses-proxy-for-osm](geo-uses-proxy-for-osm.md) | superseded | Stub: la versione breve di 0003, tenuta solo per i link storici. | - |
| [0000-template](0000-template.md) | - | Modello per i nuovi ADR. | - |
| [INDEX](INDEX.md), [index](index.md) | - | Inventari machine-readable della cartella. | - |

## Stato di copertura

- 5 ADR vivi e 1 stub superseded; tutti hanno le sei sezioni in italiano e la `Conferma` (verificato con
  `python3 -I <scratchpad>/audit_docs.py Modules/Geo`: nessun ADR con sezioni mancanti, salvo la frontmatter dello stub, ora completa).
- Conferma automatica che esiste: 0002 (3 invarianti con group Pest), 0003 (`OsmProxyTest` e i test dei temi), 0004 (Pest e Arch,
  ma la decisione e' violata). 0005 ha solo un controllo di deploy; 0001 nessuna conferma automatica.

## Dove il codice contraddice la decisione

- **0003**: 44 file sotto `resources/` (21 `.js`, 16 `.vue`, 7 `.blade.php`) scrivono a mano un URL di OSMF, e le Action
  `GetAddressFromNominatimAction` e `GetCoordinatesByAddressAction` chiamano Nominatim senza il limitatore del proxy
  (prove e comando in «Stato attuale»).
- **0004**: `app/Services` contiene ancora 8 file e `tests/Arch/debt.php` li tiene in debito (prove in «Stato attuale»).
  Serve una decisione del lead: cancellarli oppure segnare l'ADR superseded.
- **0002**: esiste un secondo dispatcher, `GetCoordinatesByAddressAction`, che ignora `geo.driver` (senza chiamanti di produzione).
>>>>>>> .merge_file_eibxVy

## Indice

- [Tile e geocoding OpenStreetMap passano dal nostro server](osm-proxy-tile-nominatim.md) — il browser parla solo con il nostro dominio; il server rispetta cache, User-Agent e 1 richiesta/s di OSMF.
- [Geocodifica: provider preferito da configurazione, poi fallback letterale](geocoding-preferred-provider-with-fallback.md) — `geo.driver` sceglie il primo provider; la mappa resta nel metodo per restare tipizzata.
- [Componenti mappa Lit in Light DOM con pane Leaflet protetto](map-components-lit-light-dom.md) — `createRenderRoot`, `guard([])` e `ResizeObserver` per mappe che sopravvivono a step, tab e Livewire.
