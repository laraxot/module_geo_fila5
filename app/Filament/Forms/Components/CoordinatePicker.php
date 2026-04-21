<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Modules\Geo\Filament\Forms\Components\Traits\HasCoordinatePicker;
use Modules\Xot\Filament\Forms\Components\XotBaseField;

/**
 * CoordinatePicker - Senior Architectural Core for geographic selection.
 *
 * Rule: Extends XotBaseField.
 * Rule: No "Default" prefixes.
 * Rule: Unified state.
 */
class CoordinatePicker extends XotBaseField
{
    use HasCoordinatePicker;

    protected string $view = 'geo::filament.forms.components.coordinate-picker';

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpCoordinatePicker();
    }

    /**
     * Static utility to map form data back to individual DB columns.
     */
    public static function extractCoordinates(array $data, string $fieldName = 'coordinates', string $latCol = 'latitude', string $longCol = 'longitude'): array
    {
        $coords = $data[$fieldName] ?? null;
        if (! is_array($coords)) {
            return $data;
        }

        $data[$latCol] = isset($coords['latitude']) ? (float) $coords['latitude'] : null;
        $data[$longCol] = isset($coords['longitude']) ? (float) $coords['longitude'] : null;

        unset($data[$fieldName]);

        return $data;
    }
}
