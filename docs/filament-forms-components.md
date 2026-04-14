# Geo Module — Filament Forms Components

## Overview

Il modulo Geo fornisce **componenti Filament form** per tutte le esigenze di geolocalizzazione. Ogni componente si integra nativamente con il sistema di form di Filament, Livewire state, e validazione.

## Componenti Disponibili

### 1. AddressInput

**Tipo**: Filament Field (`extends Field`)
**Path**: `app/Filament/Forms/Components/AddressInput.php`
**View**: `resources/views/filament/forms/components/address-input.blade.php`

Campo indirizzo singolo con pulsante "Usa la tua posizione" che usa il browser geolocation API.

**Usage**:
```php
use Modules\Geo\Filament\Forms\Components\AddressInput;

AddressInput::make('address')
    ->label('Indirizzo')
    ->placeholder('Via Roma 1, Milano')
    ->required()
    ->maxLength(255)
    ->spritePath('/themes/Sixteen/design-comuni/assets/bootstrap-italia/dist/svg/sprites.svg'),
```

**Features**:
- ✅ Browser geolocation (`navigator.geolocation.getCurrentPosition()`)
- ✅ Reverse geocoding via Nominatim (OSM, gratuito, no API key)
- ✅ Livewire state binding nativo (`$statePath`)
- ✅ Loading state durante geolocalizzazione
- ✅ Error handling (permission denied, not supported)
- ✅ Validazione Filament standard

### 2. AddressSection

**Tipo**: Filament Section (`extends Section`)
**Path**: `app/Filament/Forms/Components/AddressSection.php`

Sezione con campi indirizzo separati: via, numero civico, città, CAP, provincia, paese.

**Usage**:
```php
use Modules\Geo\Filament\Forms\Components\AddressSection;

AddressSection::make('address')
    ->label('Indirizzo')
    ->columns(2)
    ->schema([
        // Campi personalizzati se necessario
    ]),
```

**Fields inclusi**:
- `street` — Via/piazza
- `number` — Numero civico
- `city` — Città
- `postal_code` — CAP
- `province` — Provincia
- `country` — Paese
- `notes` — Note aggiuntive

### 3. LatitudeLongitudeInput

**Tipo**: Filament Field
**Path**: `app/Filament/Forms/Components/LatitudeLongitudeInput.php`
**View**: `resources/views/filament/forms/components/latitude-longitude-input.blade.php`

Coppia di input numerici annidati nello stato del field (schema interno `latitude` / `longitude`). Non include ancora mappa interattiva; per picker visivo usare **LeafletMarkerMapInput** + campi sibling.

### 4. LeafletMarkerMapInput

**Tipo**: Filament Field
**Path**: `app/Filament/Forms/Components/LeafletMarkerMapInput.php`
**View**: `resources/views/filament/forms/components/leaflet-marker-map-input.blade.php`

Mappa Leaflet (tile OpenStreetMap, pattern ispirato a mappe civiche tipo [farmshops.eu](https://github.com/CodeforKarlsruhe/farmshops.eu): OSM, UX chiara, niente lock-in) con marker trascinabile e pulsante «posizione corrente». Il campo mappa è `dehydrated(false)`; invece di persistere direttamente nello stato del form, aggiorna automaticamente due campi sibling configurati (di default `latitude` e `longitude`) nello stesso scope dello schema.

**Usage Approaches**:

#### Approach 1: Automatic Sibling Field Binding (Recommended)
Il componente aggiorna automaticamente i campi sibling `latitude` e `longitude` quando l'utente interagisce con la mappa:
```php
use Modules\Geo\Filament\Forms\Components\LeafletMarkerMapInput;

LeafletMarkerMapInput::make('location')
    ->label(__('fixcity::segnalazione.fields.place.section.label'))
    ->defaultCenter(41.9028, 12.4964) // Roma di default
    ->defaultZoom(13)
    ->mapHeight('340px')
    ->showMap(true),
// Aggiungi i campi sibling nascosti nello stesso schema:
TextInput::make('latitude')->numeric()->hidden(),
TextInput::make('longitude')->numeric()->hidden(),
```

#### Approach 2: Custom Field Names
Per utilizzare nomi di campo diversi dalla predefinita `latitude`/`longitude`:
```php
use Filament\Forms\Components\TextInput;
use Modules\Geo\Filament\Forms\Components\LeafletMarkerMapInput;

LeafletMarkerMapInput::make('location_map')
    ->defaultCenter(45.4642, 9.1900)
    ->defaultZoom(13)
    ->mapHeight('400px')
    ->bindLatitudeField('lat')    // Nome campo personalizzato per latitudine
    ->bindLongitudeField('lng'),  // Nome campo personalizzato per longitudine
TextInput::make('lat')->numeric()->hidden(),
TextInput::make('lng')->numeric()->hidden(),
```

**Features**:
- ✅ Leaflet 1.9 da CDN (tile OSM)
- ✅ Marker trascinabile e click sulla mappa
- ✅ Pulsante geolocalizzazione browser
- ✅ Campo mappa non persistito (`dehydrated(false)`); persistenza su campi sibling lat/lng
- ✅ Aggiornamento automatico dei campi sibling configurati via Livewire
- ✅ Traduzioni `geo::leaflet_map.*` e riuso messaggi `geo::address.geolocation.*`
- ✅ Supporto per nomi di campo personalizzati tramite `bindLatitudeField()` e `bindLongitudeField()`

### 5. Composizione indirizzo + mappa

Non esiste un unico field composito nel repo; combinare **`AddressInput`** (testo + reverse geocoding opzionale) e/o **`LeafletMarkerMapInput`** (coordinate) secondo il flusso dominio.

## Zen: Perché Componenti Filament (non Blade::render)

| Approccio | Problema | Soluzione |
|---|---|---|
| `Blade::render('view')` | Non ha accesso a `$wire`, stato Livewire | ✅ Estendere `Field` |
| `wire:ignore` | Livewire non aggiorna il valore | ✅ Usare `$statePath` correttamente |
| JS globale `$wire` | Fragile, non funziona in Blade::render | ✅ Passare statePath alla funzione JS |
| `wire:model.defer` | JS non aggiorna il valore | ✅ Usare `wire:model.live` |

**Filament Way**:
```php
class AddressInput extends Field
{
    protected string $view = 'geo::filament.forms.components.address-input';
    
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->afterStateHydrated(function (AddressInput $component, mixed $state): void {
            if (! is_string($state)) {
                $component->state('');
            }
        });
    }
}
```

**Blade View** (con stato Livewire corretto):
```blade
@php
    $statePath = $getStatePath();
@endphp

<input
    type="text"
    wire:model.live="{{ $statePath }}"
    id="address-{{ $statePath }}"
>

<button x-on:click="useMyLocation('{{ $statePath }}')">
    Usa la tua posizione
</button>

<script>
function useMyLocation(statePath) {
    navigator.geolocation.getCurrentPosition(function(pos) {
        // Reverse geocode...
        const address = data.display_name;
        // Update Livewire state via $wire
        $wire.$set(statePath, address);
    });
}
</script>
```

## Troubleshooting

### Problema: Livewire non aggiorna il valore dell'input

**Causa**: `wire:model.defer` invece di `wire:model.live`
**Soluzione**: Usare `wire:model.live` per aggiornamenti da JS

### Problema: Errore "Livewire property cannot be found"

**Causa**: statePath non definito nel componente
**Soluzione**: Assicurarsi che `$statePath` sia passato correttamente dal campo Filament

### Problema: Entangle error

**Causa**: Tentativo di usare `@entangle` su stato non esistente
**Soluzione**: Non usare `@entangle` in custom fields, usare `$wire.$set()`

### Problema: Geolocalizzazione non funziona

**Causa**: Browser non supporta geolocalizzazione o permesso negato
**Soluzione**: 
1. Verificare `navigator.geolocation` esiste
2. Controllare permesso browser
3. HTTPS richiesto (geolocalizzazione non funziona su HTTP)

## Translations

Namespace: `geo::address.*`

| Chiave | IT | EN |
|---|---|---|
| `fields.address.label` | Indirizzo | Address |
| `fields.address.placeholder` | Cerca un indirizzo... | Search for an address... |
| `fields.use_my_location.label` | Usa la tua posizione | Use your current location |
| `geolocation.not_supported` | Geolocalizzazione non supportata | Geolocation not supported |
| `geolocation.address_not_found` | Indirizzo non trovato | Address not found |
| `geolocation.error` | Errore durante la geolocalizzazione | Error during geolocation |
| `geolocation.permission_denied` | Permesso di geolocalizzazione negato | Geolocation permission denied |

## Testing

Ogni componente deve avere:
- Unit test per state handling
- Integration test: render in form schema
- Browser test: geolocation button (se browser supporta)
- Map test: marker drag aggiorna coordinate
- Validation test: lat/lng invalidi rifiutati

## Riferimenti

- [Filament Custom Fields](https://filamentphp.com/docs/5.x/forms/custom-fields)
- [Filament Forms Overview](https://filamentphp.com/docs/5.x/forms/overview)
- [Filament Wizards](https://filamentphp.com/docs/5.x/schemas/wizards)
- [Livewire + Geolocation](https://dev.to/bradisrad83/browser-location-with-laravel-livewire-54bd)
- [CheeseGrits Google Maps Plugin](https://filamentphp.com/plugins/cheesegrits-google-maps)
