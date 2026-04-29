---
name: feedback_geo-map-widget
description: Feedback sull'uso del componente LeafletMarkerMapInput nel wizard di creazione ticket
type: feedback
---

Il componente LeafletMarkerMapInput sostituisce AddressInput nel wizard di creazione ticket per sfruttare direttamente i campi latitude e longitude del modello Ticket.

**Why:** L'AddressInput originale effettuava reverse geocoding per salvare solo un indirizzo testuale, perdendo le coordinate precise. Il nuovo approccio salva direttamente latitude e longitude nel modello, mantenendo la precisione geografica necessarie per funzionalità future come mappe di calcolo distanza, ricerca per prossimità, ecc.

**How to apply:** Quando si crea un nuovo widget che richiede selezione posizione geografica, valutare l'uso di LeafletMarkerMapInput dal modulo Geo invece di componenti di input indirizzo testuale. Il componente aggiorna automaticamente i campi sibling configurati (latitude/longitude di default) quando l'utente interagisce con la mappa.