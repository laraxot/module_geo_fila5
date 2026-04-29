# Story 8.7: Mappa Step 2 — Fix UX (triplo "Luogo", spaziatura, lat/lng, satellite)

**Status**: in-progress
**Epic**: 8 — Tooling & Developer Experience
**Story ID**: 8-7
**Story Key**: 8-7-segnalazione-crea-map-ux-fix-satellite-lat-lng
**Data creazione**: 2026-04-15

---

## Story

Come **utente che compila il passo 2 del wizard di segnalazione**,
voglio vedere la sezione "Luogo" con una mappa pulita senza titoli duplicati, spaziatura corretta, aggiornamento automatico dei campi latitude/longitude quando clicco sulla mappa, e la possibilità di passare a vista satellite e altre viste,
così da poter identificare e confermare il luogo del disservizio in modo intuitivo.

---

## Problemi da risolvere (URL: `http://127.0.0.1:8000/it/tests/segnalazione-crea?step=form.dati-della-segnalazione%3A%3Adata%3A%3Awizard-step`)

| # | Problema | Causa | Fix |
|---|---------|-------|-----|
| 1 | "Luogo" appare 3 volte di seguito | `Section::make('Luogo')` + `->label('Luogo')` su `LatitudeLongitudeInput` + `<h2>{{ $getLabel() }}` nel blade | Aggiungere `->hiddenLabel()` al campo; rimuovere `<h2>` dal blade |
| 2 | Troppo spazio verticale fra descrizione e box mappa | Card wrapper con padding `p-big p-lg-4` + `mt-3` sul `form-group` | Ridurre padding con Tailwind |
| 3 | Lat/lng non visibilmente aggiornati (verifica) | `wire.set()` già presente — verificare path e visibilità campi | Test interattivo + eventuali fix path |
| 4 | Mancano vista satellite e altre viste | Solo OSM tile layer attivo | Aggiungere Leaflet layer control con OSM + Satellite (Esri) + Terreno (OpenTopoMap) |

---

## Acceptance Criteria

### AC1 — "Luogo" appare una sola volta
**Given** il passo 2 è caricato,
**Then** la parola "Luogo" appare esattamente **una** volta (come heading della Section Filament),
**And** il campo mappa non ha label duplicata sopra di esso,
**And** il blade non mostra `<h2>` con il nome del campo.

### AC2 — Spaziatura verticale ridotta
**Given** la sezione Luogo è visibile,
**Then** lo spazio fra "Indica il luogo del disservizio" (description Section) e il box mappa è ≤ 12px,
**And** non ci sono padding eccessivi (> 24px) attorno alla mappa.

### AC3 — Lat/lng aggiornati al click/drag sulla mappa
**Given** l'utente clicca sulla mappa o trascina il marker,
**Then** i campi `latitude` e `longitude` visibili nel blade si aggiornano in tempo reale (via `wire.set()`),
**And** i valori hanno 6 decimali di precisione.

### AC4 — Selezione vista mappa (OSM / Satellite / Terreno)
**Given** la mappa è visibile,
**Then** è presente un controllo (Tailwind + Alpine) per selezionare il tile layer:
  - "Mappa" (OSM — default)
  - "Satellite" (Esri WorldImagery — gratuito, no API key)
  - "Terreno" (OpenTopoMap)
**And** cambiando vista il marker rimane nella stessa posizione e lat/lng non vengono resettati.

### AC5 — Nessuna regressione
**Then** la pagina risponde HTTP 200 senza errori console,
**And** il wizard completa il submit con `latitude`/`longitude` popolati nel Ticket.

---

## Tasks

- [ ] **Task 1** — Fix triplo "Luogo": aggiungere `->hiddenLabel()` in `CreateTicketWizardWidget.php`; rimuovere `<h2>` + `card-header` dal blade
- [ ] **Task 2** — Fix spaziatura: sostituire classi Bootstrap card con wrapper Tailwind compatto nel blade
- [ ] **Task 3** — Verificare e fix lat/lng update via `wire.set()` (path check)
- [ ] **Task 4** — Aggiungere layer control Tailwind+Alpine (3 viste: Mappa/Satellite/Terreno) nel blade
- [ ] **Task 5** — Test visivo su URL di riferimento + smoke test submit wizard
- [ ] **Task 6** — Aggiornare sprint-status.yaml a `done`

---

## Dev Notes

### File da toccare

| File | Azione |
|---|---|
| `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php` | Aggiungere `->hiddenLabel()` a `LatitudeLongitudeInput::make('location')` |
| `laravel/Modules/Geo/resources/views/filament/forms/components/latitude-longitude-input.blade.php` | Rimuovere `<h2>` card-header, ridurre padding, aggiungere layer control Tailwind |

### Tile layers da aggiungere

```javascript
var osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors', maxZoom: 19
});
var satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
    attribution: 'Tiles &copy; Esri', maxZoom: 19
});
var terrainLayer = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
    attribution: 'Map data: &copy; OpenStreetMap contributors, SRTM | &copy; OpenTopoMap (CC-BY-SA)', maxZoom: 17
});
```

### Layer control Tailwind+Alpine (custom, no Bootstrap)

```html
<div x-data="{ activeLayer: 'osm' }" class="flex gap-1 mb-2">
    <button type="button" @click="activeLayer='osm'; $dispatch('map-layer', 'osm')"
        :class="activeLayer==='osm' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border'"
        class="px-2 py-1 text-xs rounded shadow-sm">Mappa</button>
    <button type="button" @click="activeLayer='satellite'; $dispatch('map-layer', 'satellite')"
        :class="activeLayer==='satellite' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border'"
        class="px-2 py-1 text-xs rounded shadow-sm">Satellite</button>
    <button type="button" @click="activeLayer='terrain'; $dispatch('map-layer', 'terrain')"
        :class="activeLayer==='terrain' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border'"
        class="px-2 py-1 text-xs rounded shadow-sm">Terreno</button>
</div>
```

Il listener JS ascolta `map-layer` sull'elemento per cambiare il tile layer senza reset marker.

### Guardrail

- NON toccare la logica PHP `prepareTicketData()` per lat/lng extraction
- NON rimuovere `wire:ignore` dal div mappa
- NON rimuovere `@once` Leaflet CSS/JS
- La mappa usa `wire.set()` per aggiornare — NON usare `wire:model.live` direttamente sul div

---

## Dev Agent Record

### Agent Model Used
claude-sonnet-4-6

### Completion Notes List
(da compilare durante implementazione)

### File List
- `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`
- `laravel/Modules/Geo/resources/views/filament/forms/components/latitude-longitude-input.blade.php`
- `_bmad-output/implementation-artifacts/sprint-status.yaml`

---

## Change Log

| Data | Descrizione |
|---|---|
| 2026-04-15 | Story 8-7 creata. Fix triplo "Luogo", spaziatura, lat/lng update, aggiunta satellite/terreno. |
