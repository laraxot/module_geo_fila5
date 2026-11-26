---
title: "Marker e pulsanti del coordinate-picker nelle pagine ospiti"
type: concept
tags: [geo, coordinate-picker-lit, marker, controls, data-dc, css, dcp-152]
created: 2026-10-14
updated: 2026-10-14
qmd: "coordinate-picker-lit marker tipo stato markerCardStylesText ctrl-btn sfondo trasparente reset button data-dc light DOM"
related:
  - coordinate-picker-design-comuni-runtime-rule.md
  - ../../stories/dcp-152-marker-dettaglio-ticket-e-pulsanti-mappa-su-pagine-dc.story.md
status: active
---

# Marker e pulsanti del picker nelle pagine ospiti

`coordinate-picker-lit` e' in light DOM: gli stili che porta con se (`<style>` nel render) convivono con il CSS della pagina ospite.

## Marker
- Il cerchio, il glifo e il pin di default si disegnano con `markerCardStylesText`: il picker deve includerlo (come `map-lit`), altrimenti il pin e' nero e senza sfondo.
- Attributi opzionali (tutti insieme solo se il tipo e' noto): `marker-icon-url` (icona `fixcity::svg` del tipo, percorso che inizia con `/`), `marker-color` (esadecimale, colore dello stato), `marker-label` (nome del tipo, usato come iniziale solo se l'icona non e' utilizzabile). Senza attributi: cerchio primario DC con pin.
- Sorgente dei valori in Fixcity: `ResolveTicketTypeMarkerPropertiesAction` e `ResolveTicketStatusMarkerPropertiesAction`, le stesse del GeoJSON della mappa pubblica: stesso tipo, stessa icona, stesso colore in mappa e in dettaglio. Le due Action esistono; `BuildTicketsGeoJsonAction` usa quella del tipo; per quella dello stato e per "tutti insieme solo se il tipo e noto": (non verificato).

## Pulsanti
- Un reset sui `button` della pagina (es. `body:has(.page-content[data-dc]) button`, 0,2,2) batte `.ctrl-btn` (0,1,0). Le regole del tema sul picker sono spente nelle pagine `data-dc` dal plugin PostCSS (non verificato: il plugin sta nel tema, fuori da Geo; lo dice il commento di `resources/js/components/map/styles.js`). Il componente si protegge da solo: `.map-container .ctrl-btn.ctrl-btn` (0,3,0), senza `!important`.
- Regola generale: ogni elemento interattivo del picker che dipende da sfondo/bordo/raggio deve avere specificita' superiore ai reset di pagina, oppure essere ripristinato dal componente.

## Posizione corrente
Il GPS richiede un contesto sicuro: su HTTP/IP LAN il pulsante porta alla zona di partenza con un invito neutro (vedi [[coordinate-picker-field]] e DCP-127/146). Provarlo su `https://192.168.1.40:8080` (non verificato: indirizzo dell'ambiente di sviluppo).

## Verifica

Verificato il 2026-10-14 su `resources/js/components/**`: `markerCardStylesText` importato e incluso nel render del picker (`coordinate-picker-lit.js` righe 4 e 95, come `map-lit.js:142`); attributi `marker-icon-url`, `marker-color`, `marker-label` (righe 35-37); l'icona e accettata solo se il percorso inizia con `/` e non contiene `"'<>` (`sanitizeIconUrl` in `map/icon-glyph.js`); l'iniziale di `marker-label` appare solo se l'icona e indicata ma non utilizzabile (`createGeoMapLeafletIcon` in `map/marker-config.js`); `.map-container .ctrl-btn.ctrl-btn` (0,3,0, senza `!important`) in `map/styles.js` (il file e in modifica da un'altra sessione: nessun numero di riga); su origine non sicura `map/controls/geolocation.js` non chiede il GPS e ricade sul punto salvato o sulla vista iniziale.
