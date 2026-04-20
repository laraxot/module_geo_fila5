<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Modules\Geo\Filament\Forms\Components\Traits\HasCoordinatePicker;
use Modules\Xot\Filament\Forms\Components\XotBaseField;

/**
 * MapPicker - Senior Aligned.
 */
class MapPicker extends XotBaseField
{
    use HasCoordinatePicker;

    protected string $view = 'geo::filament.forms.components.map-picker';

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpCoordinatePicker();
    }

    /** Aligned alias for legacy defaultLocation() */
    public function defaultLocation(float $latitude, float $longitude): static
    {
        return $this->center($latitude, $longitude);
    }
}
