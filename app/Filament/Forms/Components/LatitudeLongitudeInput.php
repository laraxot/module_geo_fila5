<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Modules\Geo\Filament\Forms\Components\Traits\HasCoordinatePicker;
use Modules\Xot\Filament\Forms\Components\XotBaseField;

/**
 * Latitude/Longitude coordinate input with validation and map display.
 *
 * Provides two text fields for coordinates with optional map widget:
 * - Range validation (-90 to 90 for lat, -180 to 180 for lng)
 * - Interactive map with draggable marker
 * - Current location button
 * - Real-time coordinate updates
 *
 * Owned by Geo module because coordinates are a cross-cutting geo-spatial concern.
 * Rule: Unified state {latitude, longitude}.
 */
class LatitudeLongitudeInput extends XotBaseField
{
    use HasCoordinatePicker;

    /**
     * Supported JS frameworks for rendering the map component.
     * - 'blade': Legacy Blade/Alpine implementation (default)
     * - 'lit': Lit Web Component implementation.
     */
    protected const FRAMEWORK_BLADE = 'blade';
    protected const FRAMEWORK_LIT = 'lit';

    protected string $view = 'geo::filament.forms.components.coordinate-picker';

    protected string $jsFramework = self::FRAMEWORK_BLADE;

    protected float $defaultLatitude = 41.9028;

    protected float $defaultLongitude = 12.4964;

    protected int $defaultZoom = 13;

    protected bool $showMap = true;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpCoordinatePicker();

        // Custom height for this specific input type
        $this->height('300px');
    }
}
