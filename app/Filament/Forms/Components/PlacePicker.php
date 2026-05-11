<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Modules\Geo\Filament\Forms\Components\Traits\HasCoordinatePicker;
use Modules\Xot\Filament\Forms\Components\XotBaseField;

/**
 * PlacePicker - Specialized for finding specific places or POIs.
 *
 * Zen: The guide to the specific and the significant.
 * Implementation: Separate Blade and Lit JS.
 */
class PlacePicker extends XotBaseField
{
    use HasCoordinatePicker;

<<<<<<< HEAD
=======
    protected string $view = 'geo::filament.forms.components.place-picker';

>>>>>>> c3b9b5924 (.)
    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpCoordinatePicker();
    }
}
