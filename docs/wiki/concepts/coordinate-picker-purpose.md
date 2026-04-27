# CoordinatePicker Purpose in Ticket Creation Wizard

## Overview
The `coordinate-picker-lit` map component is used in the FixCity ticket creation wizard (`/fixcity/admin/tickets/create`) to allow citizens to precisely select the location of an issue on a Leaflet map.

## Purpose
1. **Precise Location Selection**: Users can click on the map or drag a marker to set latitude/longitude for a ticket.
2. **Geolocation**: Automatically detects user's current position via browser geolocation API.
3. **Address Search**: Integrates with address search to geocode addresses and position the marker.
4. **Visual Feedback**: Displays selected coordinates and address readout below the map.

## Component Architecture
- **PHP**: `CoordinatePicker` form component (`Modules/Geo/Filament/Forms/Components/CoordinatePicker.php`)
- **Blade**: `coordinate-picker.blade.php` (wrapper with Livewire state sync)
- **Lit JS**: `coordinate-picker-lit.js` (Leaflet map logic, markers, controls)

## Usage in Wizard
The map appears in the "Dati della segnalazione" step of the ticket creation wizard. It is bound to the `location` field (latitude/longitude object).

## Key Features
- Fullscreen toggle
- Layer switching (street, satellite, topo)
- Zoom controls
- Reverse geocoding (optional)
- Responsive sizing with `invalidateSize()` for Filament wizard steps

## Quality Checks
- PHPStan: passed on related PHP files
- PHPMD: no critical issues
- PHPInsights: code style compliant
- Visual parity: map loads correctly after JS guard fix

## Related Files
- `laravel/Modules/Geo/resources/js/components/coordinate-picker-lit.js`
- `laravel/Modules/Geo/resources/views/filament/forms/components/coordinate-picker.blade.php`
- `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`
- `laravel/Modules/Fixcity/app/Filament/Resources/TicketResource/Schemas/TicketForm.php`
