# coordinate picker

## obiettivo

`CoordinatePicker` e un custom field Filament riutilizzabile per selezionare coordinate geografiche dentro Resource e Wizard, mantenendo:

- stato form composito: `coordinates = { latitude, longitude }`
- persistenza database reale: colonne separate `latitude` e `longitude`
- separazione netta tra layer PHP, Blade, Alpine bridge e Lit + Leaflet

## architettura

- **PHP field**: `Modules\Geo\Filament\Forms\Components\CoordinatePicker`
  - estende `Filament\Forms\Components\Field`
  - usa `dehydrated(false)` per non salvare JSON nel DB
  - espone configurazione fluente (`zoom()`, `center()`, `latitudeColumn()`, `longitudeColumn()`, `reverseGeocoding()`)
  - espone `reverseGeocode()` via `#[ExposedLivewireMethod]` + `#[Renderless]`
- **Blade field**: `geo::filament.forms.components.coordinate-picker`
  - wrapper Filament standard con `x-dynamic-component`
  - bridge Alpine minimale (`$wire.$watch`, evento `coords-changed`, `$wire.$set`)
- **web component**: `coordinate-picker-field.js`
  - Lit 3 + Leaflet
  - rendering mappa, marker draggable, click-to-set, layer switch
  - evento semantico `coords-changed`
  - nessuna conoscenza di Livewire/Filament

## contratto dati

### stato del field

```php
[
    'coordinates' => [
        'latitude' => 45.464211,
        'longitude' => 9.191383,
    ],
]
```

### mapping finale (submit)

```php
use Modules\Geo\Filament\Forms\Components\CoordinatePicker;

$data = CoordinatePicker::extractCoordinates(
    $data,
    fieldName: 'coordinates',
    latitudeColumn: 'latitude',
    longitudeColumn: 'longitude',
);
```

Output:

```php
[
    'latitude' => 45.464211,
    'longitude' => 9.191383,
]
```

## esempio d'uso in schema

```php
use Modules\Geo\Filament\Forms\Components\CoordinatePicker;

CoordinatePicker::make('coordinates')
    ->zoom(15)
    ->center(45.464211, 9.191383)
    ->latitudeColumn('latitude')
    ->longitudeColumn('longitude')
    ->reverseGeocoding(true);
```

## light dom: scelta intenzionale

Il web component usa `createRenderRoot() { return this; }` (Light DOM) per robustezza con Leaflet:

- Leaflet crea pane/controls dinamici e usa CSS globali propri
- in Light DOM i controlli e i layer sono piu prevedibili lato layout/event bubbling
- il CSS del componente e iniettato in modo idempotente (`injectStyles`) per evitare duplicazioni

Non e una scorciatoia: e una decisione tecnica per compatibilita operativa con Leaflet.

## limiti e possibili estensioni

- reverse geocoding opzionale e best-effort (Nominatim, ritorno `null` su errore/timeout)
- se `latitude` o `longitude` mancano, il runtime tratta la coppia come incompleta e tenta geolocalizzazione browser, valorizzando entrambe le coordinate correnti
- estensioni future possibili:
  - geocoding forward opzionale
  - modal map expand con Fullscreen API browser
  - integrazione con search provider dedicato

## riferimenti

- [map picker filament field](./wiki/concepts/map-picker-filament-field.md)
- [geo wiki index](./wiki/index.md)
