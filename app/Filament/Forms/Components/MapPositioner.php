<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

/**
 * MapPositioner - Senior Aligned.
 */
class MapPositioner extends CoordinatePicker
{
    protected string $view = 'geo::filament.forms.components.map-positioner';

    /** Aligned alias for legacy defaultLocation() */
    public function defaultLocation(float $latitude, float $longitude): static
    {
        return $this->center($latitude, $longitude);
    }
}
