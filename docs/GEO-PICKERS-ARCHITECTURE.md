# Geo Picker Components Architecture (Filament v5)

## Overview
Questa documentazione definisce lo standard architetturale mandatorio per la famiglia di componenti geografici nel modulo `Geo`. 

## Regole d'Oro (Mandatorie)

### 1. No IDs - Solo Classi locali
Per permettere la coesistenza di più istanze (es. `LatitudeLongitudeInput` accanto a `MapPicker`), nessuna istanza di Leaflet o riferimento JS deve agganciarsi a un `id` HTML. Si utilizza esclusivamente il targeting via classe locale sull'host del web component: `this.querySelector('.map-container')`.

### 5. Mandatory Inheritance (XotBaseField)
- Tutti i componenti della famiglia Geo devono estendere **`XotBaseField`**.
- **`LatitudeLongitudeInput`** deve estendere direttamente `XotBaseField` e **NON** `CoordinatePicker`. La condivisione di logica avviene tramite il trait `HasCoordinatePicker`.
- Questa regola garantisce l'indipendenza dei componenti core del framework modulare.

### 6. Clean Naming (Anti-Redundancy)
Evitare prefissi "Default" nei metodi e nelle proprietà quando si tratta di configurazione dello stato. 
- ✅ `getLatitude()`, `getZoom()`, `height()`
- ❌ `getDefaultLatitude()`, `getDefaultZoom()`, `mapHeight()`
- I componenti possono fornire alias per compatibilità legacy (es. `defaultCenter()`), ma il core deve restare pulito.

### 3. Light DOM Enforcement
I componenti Lit utilizzano il **Light DOM** (`createRenderRoot() { return this; }`) per garantire che Leaflet possa accedere correttamente ai CSS globali, risolvere i path delle icone e gestire gli eventi di trascinamento senza le complessità dello Shadow DOM.

### 4. Unified State & Explicit Extraction
- Il campo Filament gestisce un singolo oggetto `{ latitude: float, longitude: float }`.
- Il field è `dehydrated(false)`.
- Il salvataggio avviene tramite la utility statica `CoordinatePicker::extractCoordinates($data)`.

## Stack Tecnico
- **PHP**: Filament v5 Forms
- **Bridge**: Alpine.js (Adapter minimale Livewire v4)
- **UI**: Lit 3 (Web Components)
- **Engine**: Leaflet.js (v1.9+)

---
*Ultimo aggiornamento: Aprile 2026 - Senior Architect. Disciplina DRY + KISS.*
