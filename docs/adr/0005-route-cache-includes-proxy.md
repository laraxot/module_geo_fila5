---
title: "ADR — Il proxy Geo resta nella cache delle rotte"
type: decision
status: accepted
module: Geo
decision-makers: [team back office]
created: 2026-11-23
updated: 2026-11-26
issues: []
---

# Il proxy Geo resta nella cache delle rotte

## Contesto

Le mappe del front office chiedono tile e geocoding al dominio applicativo.
Le rotte di `Modules/Geo/routes/api.php` sono registrate dal provider del
modulo; una cache delle rotte generata prima della registrazione del provider
nasconde `/api/geo/tiles/osm/...` e restituisce il fallback HTML 404.

## Driver della decisione

- Il proxy OSM esiste solo se la rotta e' registrata: con una cache delle rotte vecchia le tile rispondono 404 HTML, sintomo facile da
  scambiare per una tile fuori griglia.
- Con `mcamara/laravel-localization` il `route:cache` semplice non copre le rotte tradotte: serve `route:trans:cache`.
- Una sola fonte per l'API: nessuna rotta o alias duplicati nel tema per compensare una cache obsoleta.
- La cache delle rotte resta attiva in produzione (prestazioni e prevedibilita').

## Alternative scartate

- Chiamare direttamente `tile.openstreetmap.org` dal browser: viola il proxy
  privacy e aggira il contratto del modulo Geo.
- Aggiungere una rotta duplicata nel tema: crea due owner per la stessa API.
- Disabilitare la cache in produzione: peggiora prestazioni e prevedibilità.

## Decisione

Il deploy rigenera la cache con `php artisan route:trans:cache`, con fallback a
`php artisan route:clear` quando il comando localizzato non è disponibile.
Non si aggiungono alias o controller nel tema per compensare una cache obsoleta.

## Conseguenze

- Dopo modifiche ai provider o alle rotte è necessario rigenerare la cache.
- La rotta deve mantenere `Content-Type: image/png` per le tile valide.
- Un 404 HTML su una tile è un segnale di bootstrap/cache non aggiornato, non
  una tile geografica invalida.

## Conferma

- Rigenerazione al deploy: `deploy.sh` (radice del repository, righe 217-221) esegue
  `php artisan route:trans:cache --quiet || php artisan route:clear --quiet`; `route:trans:cache` e' il comando di
  `mcamara/laravel-localization`.
- Dopo un deploy, da `laravel/`: `php artisan route:list --path=api/geo` deve mostrare `geo.nominatim` e `geo.osm.tile`, definite in
  `Modules/Geo/routes/api.php` (righe 33 e 38).
- `cd laravel && vendor/bin/pest Modules/Geo/tests/Feature/OsmProxyTest.php`: una tile valida risponde 200 con `image/png` sull'URL
  `/api/geo/tiles/osm/...`. Il test non usa la cache delle rotte: con una cache obsoleta il sintomo sarebbe un 404 HTML.
- Nessuna conferma automatica della rigenerazione della cache: e' un controllo di deploy. Proposta: un passo di `deploy.sh` che fallisce
  se `route:list --path=api/geo` e' vuoto.
