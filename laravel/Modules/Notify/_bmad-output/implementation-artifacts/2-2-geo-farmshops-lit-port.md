---
story_id: 2-2-geo-farmshops-lit-port
story_key: 2-2-geo-farmshops-lit-port
story_title: Farmshops.eu Port to Lit Web Component in Geo Module
epic: GEO
status: draft
created: 2026-04-16
author: bmad-create-story
---

# Story: Farmshops.eu Port to Lit Web Component in Geo Module

## User Story

Come sviluppatore del modulo `Geo`,
voglio un Web Component Lit che riproduca la parità funzionale di `farmshops.eu`,
così da integrare nel progetto una mappa Leaflet avanzata, moderna e modulare senza ereditare jQuery e script globali legacy.

## Context

Sorgenti di riferimento:
- upstream: `CodeforKarlsruhe/farmshops.eu` (MIT)
- copia locale già presente in `laravel/Modules/Geo/resources/views/maps/farmshops/`
- script locale di riferimento: `laravel/Modules/Geo/resources/views/maps/farmshops/js/direktvermarkter.js`

Interpretazione vincolante:
- consegna richiesta = **functional parity**
- non = copia letterale del codice legacy

## Mandatory Scope

- Lit Web Component nel modulo `Geo`
- Leaflet con clustering
- marker distinti per categoria
- popup su click
- layer switcher base/satellite
- geolocate control
- integrazione modulare con asset bundle locale
- nessun jQuery
- nessun CDN

## Acceptance Criteria

1. Tutti i file vivono nel modulo `Geo`.
2. Il componente usa Lit + Leaflet e light DOM.
3. Il comportamento utente replica il core di `farmshops.eu`.
4. Le categorie `farm`, `vending_machine`, `marketplace`, `beekeeper` sono riconoscibili.
5. L’architettura finale rimuove jQuery e bootstrap globale legacy.
6. Dataset e popup seguono un contratto dati esplicito.
7. Esiste un wrapper/integration point coerente con i pattern del modulo.
8. Gli asset sono costruiti e registrati tramite build/provider del progetto.
9. Esistono test Pest lato PHP per wrapper e configurazione.
10. La validazione segue la regola progetto-first, poi modulo se il rumore è troppo alto.

## Implementation Tasks

- Analizzare l’implementazione locale `farmshops`.
- Definire API del Web Component e schema dati.
- Implementare il componente Lit.
- Integrare wrapper Blade/PHP nel modulo.
- Migrare solo gli asset realmente necessari.
- Aggiungere test e verifiche.

## Notes

- Usare prima gli asset locali già presenti nel repo.
- Portare il comportamento, non il debito tecnico.
- Nessuna cancellazione dei documenti/sorgenti originali dopo ingest.
