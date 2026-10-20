---
title: "Geo — Indice docs (canonico)"
type: index
status: verified
module: Geo
date: 2026-10-20
updated: 2026-10-20
tags: [geo, docs, module, index, bmad, geocoding, actions, no-services, verified]
---
# Geo — Indice docs (verified 2026-10-20)

**Status:** verified · **Date:** 2026-10-20 · **No-Services applied:** `app/Services/` assente (ratchet `[]`); 41 Actions in `app/Actions/`.

## File chiave
- `docs/` — `bmad/`, `decisions/services-retirement.md`, `scopo.md`, `wiki/`
- `app/Actions/` — `GetCoordinatesAction`, `GetAddressDataFromFullAddressAction`, `ClusterLocationsAction`, `CalculateDistanceAction`, `FilterCoordinatesAction`, etc.
- `app/Filament/Forms/Components/` — `AddressInput`, `LeafletMarkerMapInput`
- `app/Models/` — `Address`, `Location`, `Place`, `Comune`

## Relazioni
- **Fixcity** — consumer (ticket/segnalazioni, coordinate, indirizzi)
- **User** — consumer (`Address` morph, indirizzi utente)
- **Ticket** — consumer (localizzazione segnalazione)
- **Event** — consumer (luogo evento)
- **Mobile** — consumer (geolocalizzazione)
- **Xot** — framework base (`QueueableAction` contract)
- **CMS / Sixteen** — rendering mappe

## Decisioni
- [`docs/decisions/services-retirement.md`](docs/decisions/services-retirement.md) — BMAD wave3: ritiro `app/Services/`, mapping Service→Action

Modulo **Geo** — proprietario di tutto ciò che è geo-spaziale: geocoding, mappe, indirizzi, posizioni, coordinate (Nominatim, Google Maps, Mapbox, Bing). I moduli consumatori (Fixcity, Mobile, User, Ticket, Event) importano i componenti da Geo. Consumo via **Queueable Actions**, mai `app/Services/`.

## Panoramica / File chiave
- [`README.md`](README.md) — scopo e mappa del modulo (ingresso attivo)
- [`00-INDEX.md`](00-INDEX.md) — indice operativo (con componenti, Actions, modelli, enum, widget) — mantenuto
- [`00-index.md`](00-index.md) — stub verso `00-INDEX.md`
- [`scopo.md`](scopo.md) — perché esiste il modulo
- [`docs/bmad/bmad-dossier.md`](docs/bmad/bmad-dossier.md) — dossier BMAD (PRD, architettura, epic, gap)
- [`docs/bmad/decision-log.md`](docs/bmad/decision-log.md) — log decisioni
- [`bmad-planning.md`](bmad-planning.md) — piano implementazione
- [`bmad-brainstorming.md`](bmad-brainstorming.md) — brainstorming
- [`docs/bmad/filament-blueprint.md`](docs/bmad/filament-blueprint.md) — blueprint Filament
- [`docs/decisions/services-retirement.md`](docs/decisions/services-retirement.md) — **decisione BMAD: ritiro `app/Services/`** (Services → Actions, wave3)
- [`decisions/services-retirement.md`](decisions/services-retirement.md) — canon No-Services Geo (wave3)
- [`CORRECTION-NoServices-Geo-2026-10-20.md`](CORRECTION-NoServices-Geo-2026-10-20.md) — correzione Hindsight (nome storico; contenuto allineato a services-retirement)
- [`wiki/decisions/geo-geocoding-driver-consolidation.md`](wiki/decisions/geo-geocoding-driver-consolidation.md) — ADR: driver geocoding configurabile (`config('geo.driver')`) e pulizia duplicati orfani

## Struttura
- `app/Filament/Forms/Components/` — `AddressInput`, `AddressSection`, `LatitudeLongitudeInput`, `LeafletMarkerMapInput`, `AddressField` (legacy), `AddressesField`
- `app/Actions/` — `GetCoordinatesAction`, `GetAddressDataFromFullAddressAction` (dispatcher multi-provider), `Nominatim/ReverseGeocodeAction`, `Nominatim/SearchPlacesAction`, `FilterCoordinatesInRadius.php` (duplicato buggato, mai chiamato — non `.bak`), `ClusterLocationsAction.php`
- `app/Models/` — `Address`, `Location`, `Place`, `Comune`
- `app/Enums/` — `AddressItemEnum`, `AddressTypeEnum`
- `app/Filament/Widgets/` — `LocationWidget`, `OSMMapWidget`
- `lang/it|geolocation.php` — traduzioni (`geo::address.*`, `geo::geolocation.*`)
- `docs/` — `bmad/`, `stories/`, `wiki/` (concepts/rules/decisions/memories), `phpstan/`, `roadmap/`, `analysis/`, `models/`, `performance/`, `testing/`, `raw/` (evidenza immutabile), `merge-conflicts/`, `git-conflicts/`

## Stato
Wave PHPStan: report in `docs/phpstan/`; gate unico `laravel/phpstan.neon` (neon in `Geo/` e `Geo/docs/` = legacy). `app/Services/` **assente per policy** (ratchet `archAllowedServicesDirs()` = `[]`): 5 file zombie vietati. Attenzione: `FilterCoordinatesInRadius.php` esiste ancora accanto a `FilterCoordinatesInRadiusAction.php`; `ClusterLocationsAction.wip` / `clusterlocationsaction.wip` ancora presenti; `ClusterLocationsAction.php` esiste con test in `tests/Unit/Actions/ClusterLocationsActionTest.php` (riallineamento `cd999d97e` del 2026-10-08). Nome file nuovo: lowercase senza data/suffissi sequenziali.

## Relazioni
- **Fixcity** — consumer (ticket/segnalazioni, ticket correlati, native contract)
- **Mobile** — consumer (geolocalizzazione, mappe, GeoJSON)
- **User** — consumer (indirizzi utente, `Address` morph)
- **Ticket** — consumer (localizzazione segnalazione)
- **Event** — consumer (luogo evento)
- **Notify** — consumer minimo (nessun legame diretto dichiarato)
- **Xot** — base framework (namespace `Modules\Geo\...`, `QueueableAction` contract)
- **CMS / Sixteen** — rendering mappe lato tema

## BMAD / Decisioni
- **[decisions/services-retirement.md](docs/decisions/services-retirement.md)** — decisione BMAD canonica: ritiro `app/Services/`, mapping Service → Action, difetto `BuildHaversineSqlAction` corretto rosso→verde
- [ADR geo-geocoding-driver-consolidation](wiki/decisions/geo-geocoding-driver-consolidation.md) — G1/G2: `config('geo.driver')`, dispatcher unico, `.bak` su duplicati orfani
- [Decision log Geo](docs/bmad/decision-log.md) — decisioni correnti
- [Story services-to-actions-geo](stories/services-to-actions-geo.story.md) — probe prima/dopo (330 uguali, 20 spiegati), duplicati, decisioni aperte
- [Story PHPStan wave Geo](stories/phpstan-test-wave-geo.story.md) + [phpstan-wave-coord](stories/phpstan-wave-coord.story.md) — gate e coordinamento wave
- Riferimento `google-oauth-redirect-fix.md` (User/docs/decisions/) — non applicabile a Geo (nessun auth/OAuth nel modulo); indicato come esempio di forma canonica di una decisione BMAD in `docs/decisions/`
- Convenzione docs: [`Xot/docs/conventions/docs-organization.md`](../../Xot/docs/conventions/docs-organization.md)
