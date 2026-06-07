# Integrazione con Filament

## Descrizione
Questo documento descrive come integrare i componenti geografici del modulo Geo con Filament, seguendo le best practices del progetto.

## Componenti

### 1. LocationForm
Form per la selezione della località che fornisce una selezione a cascata per:
- Regione
- Provincia
- Città
- CAP

#### Utilizzo
```php
use Modules\Geo\App\Filament\Forms\LocationForm;

class MyForm extends XotBaseForm
{
    public function getSchema(): array
    {
        return [
            ...LocationForm::getSchema(),
            // Altri campi del form
        ];
    }
}
```

#### Caratteristiche
- Selezione a cascata
- Ricerca nei campi
- Validazione automatica
- Cache gestita automaticamente
- Traduzioni integrate

### 2. LocationWidget
Widget Filament che fornisce un'interfaccia per la selezione della località.

#### Utilizzo
```php
use Modules\Geo\App\Filament\Widgets\LocationWidget;

class MyPage extends XotBasePage
{
    protected function getHeaderWidgets(): array
    {
        return [
            LocationWidget::class,
        ];
    }
}
```

#### Caratteristiche
- Form integrato
- Eventi Livewire
- Notifiche automatiche
- Traduzioni integrate

## Eventi

### 1. location-selected
Emitte quando viene selezionata una località:
```php
$this->dispatch('location-selected', [
    'region' => 'LO',
    'province' => 'MI',
    'city' => 'F205',
    'cap' => '20100'
]);
```

### 2. Gestione Eventi
```php
class MyComponent extends Component
{
    #[On('location-selected')]
    public function handleLocationSelected(array $data): void
    {
        // Gestione della selezione
    }
}
```

## Traduzioni

### 1. Campi
```php
// lang/it/fields.php
return [
    'region' => [
        'label' => 'Regione',
        'placeholder' => 'Seleziona una regione',
        'tooltip' => 'Seleziona la regione di appartenenza',
    ],
    // ...
];
```

### 2. Widget
```php
// lang/it/widgets.php
return [
    'location' => [
        'title' => 'Selezione Località',
        'submit' => 'Seleziona',
        'messages' => [
            'success' => 'Località selezionata con successo',
            'error' => 'Errore durante la selezione della località',
        ],
    ],
];
```

## Best Practices

### 1. Form
- Utilizzare sempre `LocationForm`
- Non creare form personalizzati
- Seguire le traduzioni fornite
- Gestire gli eventi correttamente

### 2. Widget
- Utilizzare sempre `LocationWidget`
- Non creare widget personalizzati
- Gestire gli eventi correttamente
- Seguire le traduzioni fornite

### 3. Cache
- Lasciare che il servizio gestisca la cache
- Non accedere direttamente al file JSON
- Pulire la cache quando necessario

## Esempi

### 1. Form Completo
```php
use Modules\Geo\App\Filament\Forms\LocationForm;

class AddressForm extends XotBaseForm
{
    public function getSchema(): array
    {
        return [
            ...LocationForm::getSchema(),
            TextInput::make('street')
                ->label('Indirizzo')
                ->required(),
            TextInput::make('number')
                ->label('Numero')
                ->required(),
        ];
    }
}
```

### 2. Widget con Eventi
```php
use Modules\Geo\App\Filament\Widgets\LocationWidget;

class AddressPage extends XotBasePage
{
    protected function getHeaderWidgets(): array
    {
        return [
            LocationWidget::class,
        ];
    }

    #[On('location-selected')]
    public function handleLocationSelected(array $data): void
    {
        $this->form->fill([
            'region' => $data['region'],
            'province' => $data['province'],
            'city' => $data['city'],
            'cap' => $data['cap'],
        ]);
    }
}
```

## Collegamenti
- [README del Modulo](../readme.md)
- [Documentazione JSON Database](json-database.md)
# filament

<!-- Contenuto migrato da _docs/filament.txt -->

-----------------------------------------------------------------------------------
https://github.com/cheesegrits/filament-google-maps
star:204
updated:4 months ago
----------------------------------------------------------------------------------
https://github.com/Traineratwot/filament-openstreetmap
star:14
updated: 2 weeks ago
----------------------------------------------------------------------------------
https://github.com/humaidem/filament-map-picker
star:32
updated: 8 months ago
----------------------------------------------------------------------------------
https://github.com/webbingbrasil/filament-maps
star:53
updated: 3 months ago
----------------------------------------------------------------------------------
https://github.com/dotswan/filament-map-picker
star:28
updated: 2 days ago
----------------------------------------------------------------------------------
https://github.com/arbermustafa/filament-locationpickr-field
star: 11
updated: 7 months ago
----------------------------------------------------------------------------------

https://packagist.org/packages/tanthammar/filament-extras

https://github.com/tanthammar/filament-extras/blob/main/src/Forms/AddressFields.php

https://github.com/Lecturize/Laravel-Addresses/blob/master/src/Models/Address.php

https://laraveldaily.com/code-examples/example/laravel-filament-filamentadmin-com/map

https://laraveldaily.com/post/laravel-get-latitude-longitude-from-address-geocoder

https://dev.to/bradisrad83/browser-location-with-laravel-livewire-54bd

<script>
 function getLocation() {
   if (navigator.geolocation) {
     navigator.geolocation.getCurrentPosition(showPosition);
   } else {
     console.log("Geolocation is not supported by this browser.");
   }
 }

function showPosition(position) {
  var Latitude = position.coords.latitude;
  var Longitude = position.coords.longitude;
}
</script>

https://polodev.github.io/tuts/2018/11/05/nearby-location-using-latitude-and-longitude-in-laravel-application-mysql-query-plus-vue-implementation/

https://github.com/geocoder-php/GeocoderLaravel
- [Best Practices Filament](../../../../docs/project/filament-best-practices.md)
- [Clean Code](../../../../docs/project/clean-code.md) 