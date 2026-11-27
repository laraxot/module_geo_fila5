---
title: "Contratto — FetchOsmTileAction"
type: contract
<<<<<<< .merge_file_eZeV5r
action: "Modules\Geo\Actions\Osm\FetchOsmTileAction"
tags: [contract, action, openstreetmap, tile, cache, privacy]
created: 2026-11-18
updated: 2026-11-24
related:
  - ../adr/osm-proxy-tile-nominatim.md
=======
action: "Modules\\Geo\\Actions\\Osm\\FetchOsmTileAction"
module: Geo
status: active
tags: [contract, action, openstreetmap, tile, cache, privacy]
created: 2026-11-18
updated: 2026-11-26
related:
  - ../adr/0003-osm-proxy-tile-nominatim.md
>>>>>>> .merge_file_VfXIpJ
  - ../../app/Actions/Osm/FetchOsmTileAction.php
  - ../../app/Http/Controllers/OsmTileController.php
  - ../../tests/Feature/OsmProxyTest.php
---

# FetchOsmTileAction

Un tile OpenStreetMap servito dal nostro server, con cache su disco, nel rispetto della Tile Usage Policy di OSMF.
<<<<<<< .merge_file_eZeV5r
Perché esiste: [ADR proxy tile e Nominatim](../adr/osm-proxy-tile-nominatim.md). Sorgente:
`app/Actions/Osm/FetchOsmTileAction.php`; unico chiamante: `app/Http/Controllers/OsmTileController.php`
(rotta `GET /api/geo/tiles/osm/{z}/{x}/{y}.png`, gruppo `api`, senza sessione).

Test: `cd laravel && vendor/bin/pest Modules/Geo/tests/Feature/OsmProxyTest.php` (oppure `--group=GEO-TILE-INV-<N>`).
=======
Perché esiste: [ADR proxy tile e Nominatim](../adr/0003-osm-proxy-tile-nominatim.md). Sorgente:
`app/Actions/Osm/FetchOsmTileAction.php`; unico chiamante: `app/Http/Controllers/OsmTileController.php`
(rotta `GET /api/geo/tiles/osm/{z}/{x}/{y}.png`, nome `geo.osm.tile`, gruppo `api`, senza sessione).

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`). Prova:
`cd laravel && vendor/bin/pest Modules/Geo/tests/Feature/OsmProxyTest.php` (oppure `--group=GEO-TILE-INV-<N>`).
>>>>>>> .merge_file_VfXIpJ

## Input

| Parametro | Tipo | Note |
|---|---|---|
<<<<<<< .merge_file_eZeV5r
| `$z`, `$x`, `$y` | `int` | coordinate del tile **già validate** dal chiamante (griglia `2^z`, `z <= tiles.max_zoom`) |
| `$referer` | `?string` | Referer della pagina che ha chiesto il tile; inoltrato a OSM se non vuoto |

Configurazione letta (`config/config.php`, chiave `geo.config.osm_proxy`): `tiles.upstream` (default
`https://tile.openstreetmap.org/{z}/{x}/{y}.png`), `tiles.min_cache_days` (minimo forzato 7), `timeout` (default 10 s),
`contact` (`GEO_OSM_CONTACT`, per lo User-Agent via `BuildOsmUserAgentAction`).
=======
| `$z`, `$x`, `$y` | `int` | coordinate del tile **già validate** dal chiamante (griglia `2^z`, `z <= tiles.max_zoom`): qui si assume un tile esistente |
| `$referer` | `?string` | Referer della pagina che ha chiesto il tile; inoltrato a OSM solo se non vuoto |

Configurazione letta (`config/config.php`, chiave `geo.config.osm_proxy`): `tiles.upstream` (default
`https://tile.openstreetmap.org/{z}/{x}/{y}.png`), `tiles.min_cache_days` (default 7, mai sotto 7), `timeout`
(default 10 s, minimo 1), `contact` (`GEO_OSM_CONTACT`, usato da `BuildOsmUserAgentAction`; se manca si usa
`mail.from.address`).
>>>>>>> .merge_file_VfXIpJ

## Output

- `array{body: string, etag: ?string, last_modified: ?string}`: il PNG e i validatori da girare al browser.
<<<<<<< .merge_file_eZeV5r
- `null` solo se il tile non è in cache **e** OSM non lo fornisce (il controller risponde 502).
=======
- `null` solo se il tile non è in cache **e** OSM non lo fornisce (il controller risponde 502,
  `OsmTileController.php:28`).
>>>>>>> .merge_file_VfXIpJ

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
<<<<<<< .merge_file_eZeV5r
| GEO-TILE-INV-1 | Con una copia in cache non scaduta non parte nessuna richiesta a OSM: al massimo una richiesta per tile per periodo di validità. | `GEO-TILE-INV-1` |
| GEO-TILE-INV-2 | La scadenza è il massimo tra `max-age`/`Expires` di OSM e `min_cache_days` giorni, e `min_cache_days` non scende mai sotto 7. | `GEO-TILE-INV-2` |
| GEO-TILE-INV-3 | Ogni richiesta a OSM porta lo User-Agent `<app>/osm-proxy (+<app.url>; <contatto>)` e il Referer della pagina, se c'è. | `GEO-TILE-INV-3` |
| GEO-TILE-INV-4 | A cache scaduta la richiesta è condizionale (`If-None-Match` / `If-Modified-Since`); un 304 rinnova i metadati senza riscrivere il PNG. | `GEO-TILE-INV-4` |
| GEO-TILE-INV-5 | OSM irraggiungibile o in errore: si serve la copia scaduta, se c'è; nessuna eccezione verso il chiamante. | `GEO-TILE-INV-5` |
| GEO-TILE-INV-6 | Si scarica solo il tile chiesto: nessun pre-scaricamento di tile vicini o di zone. | — |
| GEO-TILE-INV-7 | In cache finisce solo una risposta 2xx con `Content-Type: image/*`; una pagina d'errore HTML non sovrascrive un tile buono. | — |

## Effetti collaterali

- Scrive sul disco `local`: `geo/osm-tiles/{z}/{x}/{y}.png` (il tile) e `geo/osm-tiles/{z}/{x}/{y}.png.json`
  (`expires_at`, `etag`, `last_modified`). Il 304 riscrive solo il `.json`.
- Una richiesta HTTP GET a `tiles.upstream` solo a cache vuota o scaduta.
- `Log::warning` (`OSM tile upstream unreachable` / `OSM tile upstream error`) quando OSM non risponde o risponde male.

## Errori

- Nessuna eccezione verso il chiamante per errori di rete o di OSM (`ConnectionException` catturata, status non 2xx o
  contenuto non immagine gestiti): copia scaduta se c'è, altrimenti `null`.
- Metadati `.json` illeggibili = cache considerata assente (il tile si riscarica).
=======
| GEO-TILE-INV-1 | Con una copia in cache non scaduta non parte nessuna richiesta a OSM: al massimo una richiesta per tile per periodo di validità. Violata = più richieste di quelle che la policy tollera. | `GEO-TILE-INV-1` |
| GEO-TILE-INV-2 | La scadenza è il massimo tra `max-age`/`Expires` di OSM e `min_cache_days` giorni, e `min_cache_days` non scende mai sotto 7. Violata = tile riscaricati prima di una settimana. | `GEO-TILE-INV-2` |
| GEO-TILE-INV-3 | Ogni richiesta a OSM porta lo User-Agent `<app>/osm-proxy (+<app.url>; <contatto>)` e, se c'è, il Referer della pagina. Violata = il servizio non è identificabile per OSMF e rischia il blocco. | `GEO-TILE-INV-3` |
| GEO-TILE-INV-4 | A cache scaduta la richiesta è condizionale (`If-None-Match` / `If-Modified-Since`); un 304 rinnova i metadati e il PNG in cache viene servito senza riscriverlo. | `GEO-TILE-INV-4` |
| GEO-TILE-INV-5 | OSM irraggiungibile, in errore o con contenuto non immagine: si serve la copia scaduta, se c'è; nessuna eccezione verso il chiamante. | `GEO-TILE-INV-5` |
| GEO-TILE-INV-6 | Si scarica solo il tile chiesto: nessun pre-scaricamento di tile vicini o di zone (una sola `Http::get` per esecuzione, riga 73). | — (non dimostrato) |
| GEO-TILE-INV-7 | In cache finisce solo una risposta 2xx con `Content-Type: image/*`; una pagina d'errore HTML non sovrascrive un tile buono (righe 87-96). | — (non dimostrato) |

**Dimostrato** (`OsmProxyTest.php`): INV-1 e INV-2 con un tile con `max-age=3600` che a 6 giorni non genera richieste e
a 8 giorni sì; INV-3 con User-Agent e Referer esatti; INV-4 con `If-None-Match` e risposta 304; INV-5 con un 503
dopo un tile in cache. **Promesso ma non coperto da test**: il clamp di `min_cache_days` sotto 7 da config,
`If-Modified-Since`, il ramo `ConnectionException` di INV-5, INV-6 e INV-7.

## Effetti collaterali

In ordine:

1. Legge dal disco `local` `geo/osm-tiles/{z}/{x}/{y}.png` e `geo/osm-tiles/{z}/{x}/{y}.png.json`
   (`expires_at`, `etag`, `last_modified`); con copia fresca risponde qui e non scrive nulla.
2. Una richiesta HTTP GET a `tiles.upstream` (timeout `osm_proxy.timeout`), condizionale se esistono copia e metadati.
3. `Log::warning('OSM tile upstream unreachable')` su `ConnectionException`, oppure
   `Log::warning('OSM tile upstream error')` su status non 2xx o contenuto non immagine.
4. Su 304 riscrive solo il `.json`; su 2xx immagine scrive prima il PNG e poi il `.json` (due `put` separati).

## Errori

- Nessuna eccezione verso il chiamante per errori di rete o di OSM (`ConnectionException` catturata; status non 2xx o
  contenuto non immagine gestiti): copia scaduta se c'è, altrimenti `null` (INV-5).
- Metadati `.json` illeggibili o senza `expires_at` intero = cache considerata non fresca: il tile si riscarica senza
  richiesta condizionale (`readMeta`, righe 135-154).
>>>>>>> .merge_file_VfXIpJ
- Errori del disco (`Storage::put`) non sono catturati: arrivano al chiamante.

## Non fa

- Non valida z/x/y né applica il limite di richieste per IP: lo fanno `OsmTileController` (404 fuori griglia, senza
<<<<<<< .merge_file_eZeV5r
  chiamare OSM) e la rotta (`throttle:1200,1` in `routes/api.php`).
- Non risponde al browser con 304 né imposta `Cache-Control` verso il browser: è compito del controller.
- Non pulisce la cache su disco (cresce con le zone viste): debito dichiarato nell'ADR.
- Non pre-scarica zone né fa da tile server per terzi (vietato dalla policy).
- Non usa altri strati (Esri, OSM France): restano diretti dal browser, solo su scelta esplicita del cittadino.
=======
  chiamare OSM, riga 25) e la rotta (`throttle:1200,1` in `routes/api.php`).
- Non risponde al browser con 304 né imposta `Cache-Control`: lo fa il controller (righe 30-43).
- Non pulisce la cache su disco (cresce con le zone viste): debito dichiarato nell'ADR.
- Non pre-scarica zone né fa da tile server per terzi (vietato dalla policy).
- Non usa altri strati (Esri, OSM France, OpenTopoMap): restano diretti dal browser, solo su scelta esplicita del cittadino.

## Limiti noti

- Nessun lock «single flight»: due richieste simultanee per lo stesso tile a cache vuota o scaduta fanno due richieste a
  OSM. INV-1 vale per richieste sequenziali.
- Nessuna cache negativa: con OSM giù, ogni richiesta di un tile scaduto ritenta l'upstream (fino al timeout, 10 s di
  default) prima di servire la copia scaduta.
- Una copia scaduta viene servita senza limite di età.
- PNG e metadati sono scritti con due `put`: se il secondo fallisce resta un PNG senza metadati, che alla richiesta
  successiva viene riscaricato.
>>>>>>> .merge_file_VfXIpJ
