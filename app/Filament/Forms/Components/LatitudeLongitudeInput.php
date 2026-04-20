<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Modules\Geo\Filament\Forms\Components\Traits\HasCoordinatePicker;
use Modules\Xot\Filament\Forms\Components\XotBaseField;

/**
 * LatitudeLongitudeInput - Senior Refactor.
 * Rule: MUST extend XotBaseField, NOT CoordinatePicker.
 * Rule: No "Default" prefixes.
 */
class LatitudeLongitudeInput extends XotBaseField
{
    use HasCoordinatePicker;

    protected string $view = 'geo::filament.forms.components.latitude-longitude-input';

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpCoordinatePicker();
    }

    public function shouldShowMap(): bool
    {
        return true;
    }

    /** Aligned alias for legacy center() */
    public function defaultCenter(float $latitude, float $longitude): static
    {
        return $this->center($latitude, $longitude);
    }

    /** Aligned alias for legacy zoom() */
    public function defaultZoom(int $zoom): static
    {
        return $this->zoom($zoom);
    }

    /** Aligned alias for legacy height() */
    public function mapHeight(string $height): static
    {
        return $this->height($height);
    }
}
