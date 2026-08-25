# Wizard Location Data Flow - Fix Documentation

## 🔴 Problema Identificato

**Bug**: La location della mappa non viene passata al salvataggio del ticket nel wizard.

### Root Cause

---

## 📊 Data Flow Attuale (Rottura)

```
┌─────────────────┐
│  User Clicks    │
│  sulla Mappa    │
└────────┬────────┘
         ▼
┌─────────────────┐
│ Lit Component │
│ coordinate-     │
│ picker-lit.js   │
└────────┬────────┘
         │ dispatch 'coords-changed'
         ▼
┌─────────────────┐
│ Alpine.js       │
│ handleCoords-   │
│ Changed()       │
│                 │
│ this.state = {  │
│   latitude: x,  │
│   longitude: y  │
│ }               │
└────────┬────────┘
         │ @entangle($statePath)
         ▼
┌─────────────────┐     ┌─────────────────┐
│ Livewire State  │────▶│ ❌ BROKEN!      │
│                 │     │ dehydrated(false) │
│ location: {     │     │ impedisce invio   │
│   lat: x,       │     │ al server         │
│   lng: y        │     │                 │
│ }               │     │ Server riceve:  │
└─────────────────┘     │ location: null  │
                        └─────────────────┘
```

---

## 🔧 Fix Implementato

### Soluzione A (storica): Rimuovere `dehydrated(false)`

```php
// ❌ BEFORE (bug)
protected function setUp(): void
{
    parent::setUp();
    $this->dehydrated(false); // RIMUOVERE QUESTA LINEA
}

// ✅ AFTER (fix)
protected function setUp(): void
{
    parent::setUp();
    // Rimosso dehydrated(false) - i dati devono essere inviati al server
}
```

### Data Flow Corretto

```
┌─────────────────┐
│  User Clicks    │
│  sulla Mappa    │
└────────┬────────┘
         ▼
┌─────────────────┐
│ Lit Component   │
│ (event)         │
└────────┬────────┘
         │ coords-changed
         ▼
┌─────────────────┐
│ Alpine.js       │
│ aggiorna state  │
└────────┬────────┘
         │ @entangle
         ▼
┌─────────────────┐
│ Livewire        │
│ State Binding   │
└────────┬────────┘
         │ Dehydration
         ▼
┌─────────────────┐
│ ✅ Server       │
│ Riceve:         │
│ location: {     │
│   lat: x,       │
│   lng: y,       │
│   address: '...'│
│ }               │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│ Database        │
│ tickets.location│
│ (JSON)          │
└─────────────────┘
```

---

## 📝 Note Implementazione

### Formato Dati Location

Il componente deve salvare un oggetto JSON con:

```json
{
  "latitude": 45.123456,
  "longitude": 9.123456,
  "address": "Via Roma 1, Milano",
  "place_id": "osm:node:12345678"
}
```

### Cast nel Modello Ticket

```php
protected function casts(): array
{
    return [
        'location' => 'array', // o 'json'
    ];
}
```

---

## 🎓 Lezione Appresa

### Regola DRY/KISS

> **Mai usare `dehydrated(false)`** su campi che devono essere salvati.
> 
> `dehydrated(false)` è utile solo per:
> - Campi di sola visualizzazione
> - Campi temporanei (es. password confirmation)
> - Campi che non fanno parte del modello

### Pattern Correto

```php
// Per campi che generano dati complessi
CoordinatePicker::make('location')
    ->formatStateUsing(fn ($state) => is_string($state) ? json_decode($state, true) : $state)
    ->mutateDehydratedStateUsing(fn ($state) => json_encode($state));
```

---

## 🔗 Collegamenti

- [BMAD Story](./wizard-location-fix.story.md) - Tracciamento completo
- [Coordinate Picker Purpose](./coordinate-picker-purpose.md) - Architettura mappa
- [HasCoordinatePicker Trait](../app/Filament/Forms/Components/Traits/HasCoordinatePicker.php) - Codice sorgente

---

## ✅ Checklist Fix

- [x] Identificato root cause (`dehydrated(false)`)
- [x] Rimosse chiamate `dehydrated(false)`
- [x] Verificato data flow Livewire → Server
- [x] Aggiunto cast `array` nel modello Ticket
- [x] Testato salvataggio wizard
- [x] Documentato pattern corretto

---

**Data**: 2026-04-27
**Severity**: 🔴 Critical (blocca salvataggio ticket)
**Status**: ✅ Fixed & Documented
