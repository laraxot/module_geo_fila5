<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

/**
 * MapLocationInput – a thin wrapper around LeafletMarkerMapInput.
 *
 * Purpose: expose a Filament field that shows a Leaflet map with a draggable marker
 * and automatically writes the selected latitude and longitude into sibling fields.
 *
 * Philosophy (Geo module): "Geolocation belongs to the Geo domain, not to the
 * business modules.  This component centralises map handling and keeps the UI
 * consistent across the application."
 */
class MapLocationInput extends LeafletMarkerMapInput
{
    // No extra logic required – we inherit all behaviour from LeafletMarkerMapInput.
    // The class exists for semantic clarity and for future customisations.
}
