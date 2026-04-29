# Story: Geo Module — Filament Components Architecture

**Epic**: Phase 2 — Modular Architecture & DRY Compliance  
**Story ID**: 2.2-GEO-FILAMENT-COMPONENTS-ARCHITECTURE  
**Status**: Draft  
**Priority**: P0 (Architectural foundation)  
**Created**: 2026-04-13  

---

## User Story

Come sviluppatore di moduli Laraxot,
voglio che il modulo **Geo** fornisca un set completo di componenti Filament per la geolocalizzazione,
in modo che qualsiasi modulo (Fixcity, Transport, Events, etc.) possa comporre form con indirizzi, coordinate e mappe senza duplicare logica.

---

## Acceptance Criteria

### AC1: Componenti Esistenti Verificati
**Given** il modulo Geo  
**When** viene analizzato il codice esistente  
**Then** i seguenti componenti devono esistere e funzionare:
- `AddressInput` — Input singolo + geolocalizzazione browser
- `AddressesField` — Ripetitore per indirizzi multipli

### AC2: Nuovi Componenti Identificati
**Given** le best practices da Laravel/Livewire/Filament community  
**When** l'architettura viene progettata  
**Then** i seguenti componenti devono essere pianificati:
- `LatitudeLongitudeInput` — Lat/Lng con mappa interattiva
- `AddressSection` — Sezione strutturata (via, civico, città, CAP, provincia)
- `AddressColumn` — Colonna per tabelle Filament
- `CoordinatesField` — Campo puro lat/lng (senza indirizzo testuale)

### AC3: Geolocalizzazione Browser Funzionante
**Given** l'utente clicca "Usa la mia posizione"  
**When** il browser supporta `navigator.geolocation`  
**Then**:
- Le coordinate vengono acquisite
- L'indirizzo viene risolto via reverse geocoding (Nominatim)
- Il campo Filament viene aggiornato correttamente (`$this->set()` Livewire)

### AC4: Livewire State Binding Corretto
**Given** un campo custom Filament con JavaScript  
**When** il valore cambia da JavaScript  
**Then** Livewire riceve l'update senza errori `$_instance undefined`

---

## Dev Technical Guidance

### Filosofia Architetturale (The Zen)

**Il modulo Geo è il "Single Source of Truth" per:**
- Geolocalizzazione browser (`navigator.geolocation`)
- Indirizzi e luoghi (geocoding/reverse geocoding)
- Coordinate GPS (lat/lng)
- Mappe e visualizzazione spaziale
- Calcoli spaziali (distanza, bounds, etc.)

**Ogni altro modulo CONSUMA Geo, NON lo copia:**
- Fixcity usa `AddressInput` per "Dove è successo?"
- Transport usa `AddressesField` per le sedi
- Events usa `CoordinatesField` per i luoghi degli eventi
- Nessun modulo ha la propria implementazione di geolocalizzazione

**Pattern applicati:**
- **Dependency Inversion**: I moduli domain dipendono dall'astrazione Geo
- **Single Responsibility**: Geo gestisce SOLO geolocalizzazione
- **DRY**: Un solo componente per concetto
- **Open/Closed**: Geo è aperto all'estensione, chiuso alla modifica

### Research Findings (Community Best Practices)

#### 1. Browser Geolocation + Livewire
**Problem**: `navigator.geolocation.getCurrentPosition()` è asincrono e gira nel browser. Livewire non sa che il valore è cambiato.

**Solution** (da dev.to + StackOverflow):
```javascript
// Nel blade del componente Filament custom
function getLocation() {
    navigator.geolocation.getCurrentPosition(
        function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            // CORRECT: Use Livewire's set() method
            @this.set('latitude', lat);
            @this.set('longitude', lng);
        },
        function(error) {
            console.error('Geolocation error:', error);
        }
    );
}
```

**Key insight**: `@this` funziona SOLO se il componente è renderizzato dentro il contesto Livewire. `Blade::render()` crea un contesto isolato dove `$_instance` è undefined.

#### 2. Livewire Input Not Updating
**Problem** (da Laracasts): Livewire non aggiorna il valore dell'input quando JavaScript lo modifica.

**Solution**:
```javascript
// WRONG: $wire.latitude = lat; // Non triggera l'update
// RIGHT: @this.set('latitude', lat); // Triggera l'update + validation
```

Oppure con wire:model:
```html
<input wire:model.live="address" x-on:change="$wire.set('address', $event.target.value)">
```

#### 3. Filament Custom Fields
**Key concept** (da Filament docs):
```php
// Un campo custom Filament DEVE:
// 1. Estendere Field (o una sottoclasse)
// 2. Avere un view associato
// 3. Gestire lo state binding correttamente

class AddressInput extends Field
{
    protected string $view = 'geo::filament.forms.components.address-input';
    
    public function spritePath(string $path): static
    {
        $this->spritePath = $path;
        return $this;
    }
}
```

#### 4. Cheesegrits Google Maps Plugin
**Pattern osservato** (da filamentphp.com/plugins):
- Usa `x-data` di Alpine.js per la mappa
- Bindings bidirezionali con `wire:model`
- Reverse geocoding automatico quando la mappa viene spostata
- Supporto per filtri di ricerca (Places API)

**Lezione**: Il plugin esiste ma è a pagamento e usa Google Maps. La nostra implementazione usa OpenStreetMap/Nominatim (gratuito, no API key).

### Component Architecture

```
Modules/Geo/
├── app/
│   ├── Filament/
│   │   ├── Forms/Components/
│   │   │   ├── AddressInput.php          ← Input singolo + geolocalizzazione
│   │   │   ├── CoordinatesInput.php      ← Solo lat/lng (senza indirizzo testuale)
│   │   │   ├── AddressField.php          ← Sezione strutturata (via, città, CAP...)
│   │   │   ├── AddressesField.php        ← Ripetitore per indirizzi multipli
│   │   │   ├── MapInput.php              ← Mappa interattiva OpenStreetMap
│   │   │   └── AddressColumn.php         ← Colonna per tabelle Filament
│   │   └── ...
│   └── Actions/
│       ├── ReverseGeocodeAction.php      ← Lat/Lng → indirizzo testuale
│       └── GeocodeAction.php              ← Indirizzo → lat/lng
├── resources/views/
│   └── filament/
│       └── forms/components/
│           ├── address-input.blade.php
│           ├── coordinates-input.blade.php
│           ├── address-field.blade.php
│           ├── map-input.blade.php
│           └── address-column.blade.php
├── lang/
│   └── {locale}/
│       └── address.php                   ← geo::address.*
└── docs/
    ├── address-input-component.md
    ├── coordinates-input-component.md
    ├── address-field-component.md
    ├── map-input-component.md
    ├── address-column-component.md
    ├── actions.md
    └── INDEX.md
```

### Component Details

#### 1. AddressInput (ESISTENTE — da verificare/fixare)
**Scopo**: Input testuale singolo + pulsante "Usa la mia posizione"  
**Uso tipico**: "Dove è successo?" nelle segnalazioni  
**State**: Singolo campo stringa (`address`)  
**Geolocalizzazione**: `navigator.geolocation` → reverse geocoding Nominatim → popola il campo

```php
// Usage
AddressInput::make('address')
    ->label('Dove è successo?')
    ->required()
    ->placeholder('Inserisci l\'indirizzo o usa la tua posizione')
    ->spritePath('/themes/.../sprites.svg');
```

**Blade view**: Input text + button "Usa la mia posizione" + status message  
**Alpine.js**: Gestisce geolocation, reverse geocoding, loading states

#### 2. CoordinatesInput (NUOVO)
**Scopo**: Due campi numerici (lat/lng) + mappa statica  
**Uso tipico**: Salvataggio coordinate pure (senza indirizzo testuale)  
**State**: Due campi (`latitude`, `longitude`)

```php
// Usage
CoordinatesInput::make('coordinates')
    ->label('Coordinate GPS')
    ->defaultLatitude(41.9028)  // Roma
    ->defaultLongitude(12.4964)
    ->showMap(true);
```

**Blade view**: Due input number + mappa statica OpenStreetMap  
**Alpine.js**: Aggiorna la mappa quando lat/lng cambiano

#### 3. AddressField (NUOVO)
**Scopo**: Sezione strutturata con campi separati  
**Uso tipico**: Form di registrazione dove servono via, civico, città, CAP, provincia separati  
**State**: Sezione con sotto-campi (`street`, `civic`, `city`, `postal_code`, `province`, `country`)

```php
// Usage
AddressField::make('address')
    ->label('Indirizzo completo')
    ->columns(2)  // 2 colonne per i campi
    ->showCountry(false);
```

**Blade view**: Grid di input fields con label appropriate  
**Validazione**: Ogni campo ha le sue regole

#### 4. AddressesField (ESISTENTE — da verificare)
**Scopo**: Ripetitore per indirizzi multipli  
**Uso tipico**: "Sedi dell'azienda", "Punti di consegna multipli"  
**State**: Array di indirizzi

```php
// Usage
AddressesField::make('locations')
    ->label('Sedi')
    ->reorderable()
    ->collapsible();
```

**Composizione**: Usa `AddressField` internamente come schema del repeater

#### 5. MapInput (NUOVO)
**Scopo**: Mappa interattiva OpenStreetMap per selezione visuale  
**Uso tipico**: "Clicca sulla mappa per selezionare la posizione"  
**State**: `latitude`, `longitude`

```php
// Usage
MapInput::make('location')
    ->label('Seleziona sulla mappa')
    ->defaultCenter(41.9028, 12.4964)  // Roma
    ->defaultZoom(12)
    ->showCoordinates(true);
```

**Blade view**: Mappa Leaflet.js/OpenStreetMap interattiva  
**Alpine.js**: Gestisce click sulla mappa, drag del marker, zoom

#### 6. AddressColumn (NUOVO)
**Scopo**: Colonna per tabelle Filament che mostra indirizzo formattato  
**Uso tipico**: Lista ticket con colonna "Luogo"  
**State**: Legge dal record e formatta

```php
// Usage
AddressColumn::make('address')
    ->label('Luogo')
    ->sortable()
    ->showCity(true)
    ->showProvince(true);
```

**Blade view**: Indirizzo formattato con icone

### Action Classes

#### ReverseGeocodeAction
```php
// Lat/Lng → indirizzo testuale
$address = app(ReverseGeocodeAction::class)->handle(41.9028, 12.4964);
// → "Via dei Fori Imperiali, 00186 Roma RM, Italia"
```

#### GeocodeAction
```php
// Indirizzo → lat/lng
$coords = app(GeocodeAction::class)->handle('Colosseo, Roma');
// → ['latitude' => 41.8902, 'longitude' => 12.4922]
```

**API**: Nominatim (OpenStreetMap) — gratuito, no API key, rate limit 1 req/sec

### Livewire/Alpine.js Integration Pattern

**Il pattern corretto per componenti Filament custom con JavaScript:**

```blade
{{-- address-input.blade.php --}}
<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div x-data="{
        latitude: @entangle($applyStateBindingModifiers('state.latitude')),
        longitude: @entangle($applyStateBindingModifiers('state.longitude')),
        isLoading: false,
        
        async getLocation() {
            if (!navigator.geolocation) {
                alert('Geolocalizzazione non supportata');
                return;
            }
            
            this.isLoading = true;
            navigator.geolocation.getCurrentPosition(
                async (position) => {
                    this.latitude = position.coords.latitude;
                    this.longitude = position.coords.longitude;
                    
                    // Reverse geocoding via Nominatim
                    const response = await fetch(
                        `https://nominatim.openstreetmap.org/reverse?lat=${this.latitude}&lon=${this.longitude}&format=json`
                    );
                    const data = await response.json();
                    
                    if (data.display_name) {
                        // Update the address field via Livewire
                        $wire.set('state.address', data.display_name);
                    }
                    
                    this.isLoading = false;
                },
                (error) => {
                    console.error('Geolocation error:', error);
                    this.isLoading = false;
                    alert('Impossibile ottenere la posizione');
                },
                { enableHighAccuracy: true, timeout: 10000 }
            );
        }
    }">
        <div class="flex gap-2">
            <input
                type="text"
                x-model="state.address"
                {{ $applyStateBindingModifiers('wire:model') }}="state.address"
                class="fi-input block w-full"
            />
            <button
                type="button"
                x-on:click="getLocation()"
                x-bind:disabled="isLoading"
                class="fi-btn fi-btn-size-sm"
            >
                <svg class="icon">
                    <use href="{{ $sprite }}#it-position"></use>
                </svg>
                <span x-text="isLoading ? '...' : 'Usa la mia posizione'"></span>
            </button>
        </div>
    </div>
</x-dynamic-component>
```

**Key points**:
1. `@entangle()` per sync bidirezionale Alpine ↔ Livewire
2. `$wire.set()` per aggiornare altri campi da JavaScript
3. Nominatim per reverse geocoding (gratuito)
4. `enableHighAccuracy: true` per GPS preciso

---

## Tasks / Subtasks

### Task 1: Verify Existing Components
- [ ] Verificare `AddressInput` esistente — funziona correttamente?
- [ ] Verificare `AddressesField` esistente — funziona correttamente?
- [ ] Testare geolocalizzazione browser su entrambi

### Task 2: Create New Components
- [ ] `CoordinatesInput` — lat/lng con mappa statica
- [ ] `AddressField` — sezione strutturata
- [ ] `MapInput` — mappa interattiva OpenStreetMap/Leaflet
- [ ] `AddressColumn` — colonna per tabelle Filament

### Task 3: Create Actions
- [ ] `ReverseGeocodeAction` — lat/lng → indirizzo
- [ ] `GeocodeAction` — indirizzo → lat/lng

### Task 4: Documentation
- [ ] Creare docs per ogni componente in `Modules/Geo/docs/`
- [ ] Aggiornare `Modules/Geo/docs/INDEX.md`
- [ ] Aggiornare `MODULE-BOUNDARY-PHILOSOPHY.md` in Fixcity
- [ ] Creare esempio di utilizzo in ogni modulo consumer

---

## Dev Agent Record

### Agent Model Used
_Qwen Code_

### Research Sources Analyzed
- **Browser geolocation + Livewire**: dev.to/bradisrad83 — `navigator.geolocation` con `@this.set()`
- **Livewire input updates**: Laracasts — `$wire.set()` vs `wire:model.live`
- **Filament custom fields**: filamentphp.com/docs/5.x/forms/custom-fields
- **Cheesegrits Google Maps**: filamentphp.com/plugins/cheesegrits-google-maps — pattern di riferimento
- **Filament Livewire integration**: Various StackOverflow + Laracasts threads
- **OpenStreetMap/Nominatim**: API gratuita per geocoding (no API key)

### Architecture Decisions
- **Geocoding API**: Nominatim (OpenStreetMap) — gratuito, no API key, rate limit 1 req/sec
- **Maps**: Leaflet.js + OpenStreetMap — gratuito, leggero, open source
- **Alpine.js**: Per interattività lato client (geolocation, map click)
- **@entangle()**: Per sync bidirezionale Alpine ↔ Livewire
- **Actions**: Invokable classes per geocoding (queueable, testable)

### File List (Existing)
- `Modules/Geo/app/Filament/Forms/Components/AddressInput.php`
- `Modules/Geo/app/Filament/Forms/Components/AddressesField.php`
- `Modules/Geo/resources/views/filament/components/address-field.blade.php`
- `Modules/Geo/resources/views/components/geolocation/address-field.blade.php`
- `Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php` (consumer)
- `Modules/Fixcity/docs/MODULE-BOUNDARY-PHILOSOPHY.md`

### Change Log
| Date | Version | Description | Author |
|------|---------|-------------|--------|
| 2026-04-13 | 1.0 | Research + architecture design | Qwen |

---

## Status: Draft

**Ready for**: Dev agent implementation  
**Estimated Effort**: 12-16 ore (4 componenti nuovi + 2 actions + docs)  
**Dependencies**: Nessuna

---

## Notes

- Questa story definisce l'architettura COMPLETA dei componenti Geo
- I componenti esistenti (`AddressInput`, `AddressesField`) vanno verificati e fixati
- I nuovi componenti (`CoordinatesInput`, `AddressField`, `MapInput`, `AddressColumn`) vanno creati
- Ogni componente deve seguire il pattern Filament corretto (Field/Section/Column)
- La geolocalizzazione usa `navigator.geolocation` + Nominatim (gratuito)
- Le mappe usano Leaflet.js + OpenStreetMap (gratuito)
- Nessun modulo domain deve duplicare logica di geolocalizzazione