---
title: "ADR — Componenti mappa Lit in Light DOM con pane Leaflet protetto"
type: decision
status: accepted
module: Geo
decision-makers: [team back office]
tags: [adr, geo, lit, leaflet, light-dom, livewire, wizard]
created: 2026-04-22
updated: 2026-11-26
related:
  - ../../resources/js/components/coordinate-picker-lit.js
  - ../../resources/js/components/location-picker-lit.js
  - ../../resources/js/components/map-picker-lit.js
---

# ADR: componenti mappa Lit in Light DOM, con il pane Leaflet protetto da `guard`

## Contesto

- I campi mappa del modulo (picker di coordinate, luogo, geopoint, mappa) vivono dentro form Filament a più step (wizard)
  e tab, ridisegnati da Livewire a ogni aggiornamento di stato.
- Con lo Shadow DOM i componenti soffrivano di: mappa grigia quando nascono in uno step nascosto (Leaflet misura un
  contenitore di 0 px), istanza della mappa persa quando Lit ridisegna il template dopo un aggiornamento Livewire, CSS di
  Leaflet e icone non applicati dentro la shadow root.
- Il componente usato dal pannello è `coordinate-picker-lit` (`vite.config.js`, `app/Providers/Filament/AdminPanelProvider.php`,
  viste `resources/views/filament/forms/components/*.blade.php`).

Domanda: come rendere stabili le mappe Leaflet dentro componenti Lit montati e ridisegnati da Livewire?

## Driver della decisione

- La mappa deve sopravvivere a step, tab e ridisegni Livewire senza perdersi o restare grigia.
- Il CSS di Leaflet e del tema deve applicarsi senza workaround di stile iniettato.
- Nessuna dipendenza JavaScript obbligatoria per il rendering della mappa.

## Alternative scartate

- Shadow DOM con `::part` e stili iniettati: era la situazione di partenza, con i difetti sopra.
- `wire:ignore` sul solo wrapper senza `guard`: Livewire smette di toccare il nodo ma Lit continua a ridisegnare il
  proprio template e a ricreare il contenitore della mappa.
- Ricreare la mappa a ogni `updated()`: perde zoom, posizione e marker trascinati dall'utente, e ricarica i tile.

## Decisione

- Light DOM: i componenti mappa definiscono `createRenderRoot() { return this; }`, così CSS di Leaflet e del tema si
  applicano e Livewire vede il markup.
- Il contenitore della mappa è avvolto in `guard([], () => html\`…\`)`: Lit non lo ridisegna mai, l'istanza Leaflet sopravvive.
- `ResizeObserver` + `map.invalidateSize()`: la mappa si ricalcola quando lo step o il tab diventa visibile.
- Le icone sono template `html`, non stringhe, per non essere escapate.
- Classi CSS specifiche (es. `.map-picker-leaflet-pane`) al posto di `:host`/`::part`, perché in Light DOM lo stile è globale.

## Conseguenze

- Pro: mappe stabili negli step e nei tab; lo stile si governa con CSS normale.
- Contro: in Light DOM il CSS è globale: nomi di classe specifici obbligatori.
- Debito misurato (2026-11-26, `rg -l` su `resources/js` da `laravel/Modules/Geo`; il 2026-11-24 i valori erano 22, 17, 9 e 12):
  23 file con `extends LitElement` (uno e' un `.bak`), 18 con `createRenderRoot` (Light DOM), 9 con `guard(` e 14 con
  `ResizeObserver`; restano varianti storiche (`geo-map-lit-new.js`, `geo-map-lit-final.js`,
  `coordinate-picker-lit-stable.js`) da consolidare. Copiare il componente montato dal pannello (`coordinate-picker-lit.js`),
  non le varianti.

## Conferma

Nessuna conferma automatica oggi: nessun test controlla `createRenderRoot`, `guard(` o `invalidateSize`. Da `laravel/Modules/Geo`,
`rg -n "createRenderRoot|guard\(|invalidateSize|shadowRoot" tests/Playwright tests/Browser` non trova nulla: i 16 spec di
`tests/Playwright` e quello di `tests/Browser` provano cluster, legenda, filtri e icone, non la stabilita' della mappa dentro il wizard.

Controllo di review su un componente mappa nuovo o modificato, da `laravel/Modules/Geo`:
`for p in createRenderRoot 'guard\(' ResizeObserver; do rg -c "$p" resources/js/components/<file>.js; done` deve dare un numero
maggiore di zero per tutti e tre; a mano, aprire un wizard con la mappa in uno step non iniziale e verificare che non resti grigia.

Proposta: uno spec Playwright che apre il form con la mappa in uno step nascosto e controlla che `.leaflet-pane` abbia dimensioni
diverse da zero.
