<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Modules\Geo\Filament\Forms\Components\Contracts\CoordinatePickerArrayShapes;
use Modules\Geo\Filament\Forms\Components\Traits\HasCoordinatePicker;
use Modules\Xot\Filament\Forms\Components\XotBaseField;

/**
 * MapPicker - Specialized for visual selection on a map.
 *
 * Zen: The primary interface for visual discovery.
 * Implementation: Separate Blade and Lit JS.
 *
 * CoordinatePickerArrayShapes: PHPStan trattiene gli array shape sul consumatore
 * (il trait HasCoordinatePicker li perde «in context of class»).
 */
class MapPicker extends XotBaseField implements CoordinatePickerArrayShapes
{
    use HasCoordinatePicker;

    protected string $view = 'geo::filament.forms.components.map-picker';

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpCoordinatePicker();
        $this->dehydrated(false);
    }
}
