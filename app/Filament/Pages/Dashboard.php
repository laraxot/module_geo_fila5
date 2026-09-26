<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Pages;

use Modules\Geo\Filament\Widgets\GeoMapWidget;
use Modules\Xot\Filament\Pages\XotBaseDashboard;

final class Dashboard extends XotBaseDashboard
{
    /**
<<<<<<< .merge_file_HOnDMj
     * @return array<class-string>
=======
     * @return array<string, mixed>
>>>>>>> .merge_file_nI9Tas
     */
    public function getWidgets(): array
    {
        return [
<<<<<<< .merge_file_HOnDMj
            GeoMapWidget::class,
=======
            'geo_map' => GeoMapWidget::class,
>>>>>>> .merge_file_nI9Tas
        ];
    }

    public function getColumns(): int
    {
        return 1;
    }
}
