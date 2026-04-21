# Map Picker Family Architecture

## Obiettivo

Allineare `LatitudeLongitudeInput`, `MapPicker`, `PlacePicker` e `CoordinatePicker` a un contratto tecnico comune:

- coordinate espresse come `{ latitude, longitude }`
- bridge Alpine minimale verso Livewire v4 (`$wire.$watch`, `$wire.$set(..., false)`)
- web components Lit UI-only senza conoscenza Filament/Livewire
- eventi mappa semantici e coerenti (`coords-changed`)

## Contratto eventi condiviso

Tutti i picker Lit devono emettere (direttamente o in compatibilita):

```js
new CustomEvent('coords-changed', {
  detail: { latitude: number, longitude: number },
  bubbles: true,
  composed: true,
})
```

Per retrocompatibilita, `map-picker-lit` mantiene anche `location-changed`.

## Controlli UX minimi obbligatori

Ogni mappa operativa deve avere:

- toggle modalita espansa/fullscreen
- azione esplicita "usa posizione corrente"
- marker draggable con aggiornamento coordinate al `dragend` (no spam di update)

## Sincronizzazione Livewire

- aggiornamenti verso backend solo in momenti utili (`click`, `dragend`, geoloc confermata)
- evitare loop usando aggiornamenti programmatici distinti da quelli utente
- evitare `@entangle` in flussi complessi mappa; preferire bridge esplicito

## Nota su Light DOM / Shadow DOM

- `coordinate-picker-field` e `place-picker-field` usano Light DOM intenzionale per compatibilita Leaflet CSS/controls.
- `map-picker-lit` mantiene compatibilita storica con il suo asset/stile attuale, ma espone ora `coords-changed` per convergenza del bridge.

## Riferimenti

- [coordinate-picker-field](./coordinate-picker-field.md)
- [map-picker-runtime-asset-governance](./map-picker-runtime-asset-governance.md)
- [map-picker-locationpicker-architecture](./map-picker-locationpicker-architecture.md)
