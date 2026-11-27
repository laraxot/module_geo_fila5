---
title: "Contratto — QueryNominatimAction"
type: contract
<<<<<<< .merge_file_iwA5Ta
action: "Modules\Geo\Actions\Osm\QueryNominatimAction"
tags: [contract, action, openstreetmap, nominatim, geocoding, rate-limit, privacy]
created: 2026-11-18
updated: 2026-11-24
related:
  - ../adr/osm-proxy-tile-nominatim.md
=======
action: "Modules\\Geo\\Actions\\Osm\\QueryNominatimAction"
module: Geo
status: active
tags: [contract, action, openstreetmap, nominatim, geocoding, privacy]
created: 2026-11-18
updated: 2026-11-26
related:
  - ../adr/0003-osm-proxy-tile-nominatim.md
>>>>>>> .merge_file_BlotAL
  - ../../app/Actions/Osm/QueryNominatimAction.php
  - ../../app/Http/Controllers/NominatimController.php
  - ../../tests/Feature/OsmProxyTest.php
---

# QueryNominatimAction

Ricerca indirizzi e geocodifica inversa su Nominatim passando dal nostro server, nel rispetto della Nominatim Usage
<<<<<<< .merge_file_iwA5Ta
Policy. Perché esiste: [ADR proxy tile e Nominatim](../adr/osm-proxy-tile-nominatim.md). Sorgente:
`app/Actions/Osm/QueryNominatimAction.php`; unico chiamante: `app/Http/Controllers/NominatimController.php`
(rotta `GET /api/geo/nominatim/{search|reverse}`, `throttle:30,1`).

Test: `cd laravel && vendor/bin/pest Modules/Geo/tests/Feature/OsmProxyTest.php` (oppure `--group=GEO-NOMINATIM-INV-<N>`).
=======
Policy. Perché esiste: [ADR proxy tile e Nominatim](../adr/0003-osm-proxy-tile-nominatim.md). Sorgente:
`app/Actions/Osm/QueryNominatimAction.php`; unico chiamante: `app/Http/Controllers/NominatimController.php`
(rotta `GET /api/geo/nominatim/{search|reverse}`, nome `geo.nominatim`, `throttle:30,1`).

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`). Prova:
`cd laravel && vendor/bin/pest Modules/Geo/tests/Feature/OsmProxyTest.php` (oppure `--group=GEO-NOMINATIM-INV-<N>`).
>>>>>>> .merge_file_BlotAL

## Input

| Parametro | Tipo | Note |
|---|---|---|
<<<<<<< .merge_file_iwA5Ta
| `$endpoint` | `'search'\|'reverse'` | altro valore = 422 (la rotta ammette già solo questi due) |
| `$input` | `array<string, mixed>` | query string grezza; passano solo `search`: `q, limit, addressdetails, countrycodes, viewbox, bounded`; `reverse`: `lat, lon, zoom, addressdetails` |
| `$language` | `string` | lingua della pagina; si tengono le prime 2 lettere, altrimenti `it` |

Configurazione (`geo.config.osm_proxy`): `nominatim.enabled` (interruttore senza deploy), `nominatim.upstream`
(default `https://nominatim.openstreetmap.org`), `nominatim.cache_days` (default 30, minimo 1), `timeout` (default 10 s).
=======
| `$endpoint` | `'search'\|'reverse'` | altro valore = 422 (la rotta ammette già solo questi due: `whereIn` in `routes/api.php`) |
| `$input` | `array<string, mixed>` | query string grezza; passano solo `search`: `q, limit, addressdetails, countrycodes, viewbox, bounded`; `reverse`: `lat, lon, zoom, addressdetails` |
| `$language` | `string` | lingua della pagina; si tengono le prime 2 lettere minuscole, altrimenti `it` |

Configurazione (`geo.config.osm_proxy`): `nominatim.enabled` (interruttore senza deploy, env `GEO_NOMINATIM_ENABLED`),
`nominatim.upstream` (default `https://nominatim.openstreetmap.org`), `nominatim.cache_days` (default 30, minimo 1),
`timeout` (default 10 s), `contact` (per lo User-Agent).
>>>>>>> .merge_file_BlotAL

## Output

`array{status: int, data: mixed}`, che il controller gira tale e quale come JSON:

| status | data |
|---|---|
| 200 | il JSON di Nominatim (dalla cache o appena ricevuto) |
| 422 | `{error: 'invalid parameters'}` |
| 429 | `{error: 'busy, retry'}` |
| 502 | `{error: 'upstream unreachable'}` o `{error: 'upstream error'}` |
| 503 | `{error: 'geocoding disabled'}` |

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
<<<<<<< .merge_file_iwA5Ta
| GEO-NOMINATIM-INV-1 | Al massimo 1 richiesta al secondo a Nominatim per tutto il sito (`RateLimiter` sulla chiave `geo:nominatim:upstream`): posto occupato = un'attesa di 1 s, poi 429. | `GEO-NOMINATIM-INV-1` |
=======
| GEO-NOMINATIM-INV-1 | Al massimo 1 richiesta al secondo a Nominatim per tutto il sito (`RateLimiter`, chiave `geo:nominatim:upstream`): posto occupato = un'attesa di 1 s, poi 429. Violata = rischio di blocco dell'IP del server da parte di OSMF. | `GEO-NOMINATIM-INV-1` |
>>>>>>> .merge_file_BlotAL
| GEO-NOMINATIM-INV-2 | A Nominatim arrivano solo i parametri ammessi per l'endpoint, più `format=json` e `accept-language` a due lettere. | `GEO-NOMINATIM-INV-2` |
| GEO-NOMINATIM-INV-3 | `limit` è sempre tra 1 e 10 (default 5); `zoom` tra 0 e 18. | `GEO-NOMINATIM-INV-3` |
| GEO-NOMINATIM-INV-4 | Una richiesta già vista (stessi parametri normalizzati) si serve dalla cache, senza chiamare Nominatim. | `GEO-NOMINATIM-INV-4` |
| GEO-NOMINATIM-INV-5 | Input non valido (`q` sotto 3 o sopra 200 caratteri, lat/lon non numeriche o fuori range) = 422 senza chiamare Nominatim. | `GEO-NOMINATIM-INV-5` |
<<<<<<< .merge_file_iwA5Ta
| GEO-NOMINATIM-INV-6 | Ogni richiesta porta lo User-Agent identificabile di `BuildOsmUserAgentAction`. | `GEO-NOMINATIM-INV-6` |
| GEO-NOMINATIM-INV-7 | Con `nominatim.enabled = false` risponde 503 senza chiamare Nominatim. | `GEO-NOMINATIM-INV-7` |
| GEO-NOMINATIM-INV-8 | Solo le risposte 200 di Nominatim finiscono in cache; gli errori no. | — |

## Effetti collaterali

- `Cache::put('geo:nominatim:<endpoint>:<sha1 dei parametri>', …, cache_days)` dopo una risposta 200.
- `RateLimiter::hit('geo:nominatim:upstream', 1)` prima di ogni richiesta reale.
- `Sleep::for(1)->second()` quando il posto del secondo corrente è occupato (blocca la richiesta PHP fino a 1 s).
- Una richiesta HTTP GET a `<upstream>/<endpoint>` se non in cache.
- `Log::warning` su Nominatim irraggiungibile o in errore.

## Errori

- Nessuna eccezione verso il chiamante: ogni esito è uno `status` (tabella sopra). `ConnectionException` = 502.
- Il servizio spento e l'input non valido si riconoscono **prima** di toccare cache e rate limiter.

## Non fa

- Non fa autocompletamento: la ricerca parte da un'azione esplicita (Invio o pulsante) nel JS delle mappe; aggiungere
  una ricerca "mentre si digita" viola la policy di Nominatim.
=======
| GEO-NOMINATIM-INV-6 | Ogni richiesta porta lo User-Agent identificabile di `BuildOsmUserAgentAction` (`<app>/osm-proxy ...`). | `GEO-NOMINATIM-INV-6` |
| GEO-NOMINATIM-INV-7 | Con `nominatim.enabled = false` risponde 503 senza chiamare Nominatim, prima di toccare cache e rate limiter. | `GEO-NOMINATIM-INV-7` |
| GEO-NOMINATIM-INV-8 | Solo le risposte 2xx di Nominatim finiscono in cache; 502 e 429 no (la `Cache::put` sta dopo i `return` di errore, righe 76-92). | — (non dimostrato) |

**Dimostrato** (`OsmProxyTest.php`): INV-2, INV-3, INV-4 e INV-6 da un'unica richiesta con `limit=50` e
`polygon_geojson=1` (a Nominatim arriva `limit=10`, nessun `polygon_geojson`, `accept-language=it`, due richieste
del cliente = una sola upstream); INV-1 con la seconda richiesta nello stesso secondo (429, una sola upstream, una
sola attesa di 1 s con `Sleep::fake()`); INV-5 con `q` di 2 caratteri, `lat=95` ed endpoint `lookup` (404 dalla
rotta); INV-7 con `enabled=false`. **Promesso ma non coperto da test**: il tetto di `zoom` a 18 (INV-3), la
lunghezza massima di `q` (200), INV-8.

## Effetti collaterali

In ordine:

1. Nessun effetto se il servizio è spento (503) o l'input non è valido (422).
2. Lettura della cache `geo:nominatim:<endpoint>:<sha1 dei parametri>`; con un valore presente si risponde qui, senza
   consumare il posto del rate limiter.
3. `RateLimiter::hit('geo:nominatim:upstream', 1)` prima di ogni richiesta reale; con il posto occupato
   `Sleep::for(1)->second()` (blocca la richiesta PHP fino a 1 s) e un solo secondo tentativo.
4. Una richiesta HTTP GET a `<upstream>/<endpoint>` (timeout `osm_proxy.timeout`).
5. `Log::warning` su Nominatim irraggiungibile (`Nominatim upstream unreachable`) o in errore
   (`Nominatim upstream error`).
6. `Cache::put(<chiave>, <json>, cache_days)` dopo una risposta 2xx.

## Errori

- Nessuna eccezione verso il chiamante: ogni esito è uno `status` (tabella Output). `ConnectionException` = 502.
- Il servizio spento e l'input non valido si riconoscono **prima** di toccare cache e rate limiter (INV-5, INV-7).

## Non fa

- Non fa autocompletamento: la ricerca parte da un'azione esplicita (Invio o pulsante) nel JS delle mappe;
  aggiungere una ricerca «mentre si digita» viola la policy di Nominatim.
>>>>>>> .merge_file_BlotAL
- Non geocodifica in blocco né in coda: per i modelli c'è `GetAddressDataFromFullAddressAction` (provider configurabile).
- Non salva né inoltra l'IP del richiedente; il limite per IP è della rotta (`throttle:30,1`), non dell'Action.
- Non sceglie la lingua dalla sessione: la passa il controller (`accept-language` in query, poi `Accept-Language`).
- Non espone `lookup`, `details` o altri endpoint di Nominatim.
<<<<<<< .merge_file_iwA5Ta
=======

## Limiti noti

- Il «posto» del rate limiter si prende con `tooManyAttempts` seguito da `hit` (due operazioni, `takeSlot`, righe
  138-146): sotto concorrenza reale due richieste possono passare nello stesso secondo. INV-1 è provato in sequenza.
- Una risposta 2xx con corpo non JSON viene memorizzata come `null`, e `Cache::get` restituisce `null` anche per «assente»:
  quella richiesta non risulta mai in cache.
- Il percorso server-side `GetAddressFromNominatimAction` (catena di `GetAddressDataFromFullAddressAction`) **non** passa
  da questa Action né dal suo limitatore: vedi [contratto](get-address-from-nominatim-action.md).
>>>>>>> .merge_file_BlotAL
