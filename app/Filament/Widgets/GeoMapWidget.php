<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Widgets;

use Modules\Geo\Actions\Maps\BuildGeoMapWidgetPayloadAction;
use Modules\Geo\Datas\Map\GeoMapWidgetData;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

final class GeoMapWidget extends XotBaseWidget
{
    protected string $view = 'geo::filament.widgets.geo-map-widget';

    protected static ?int $sort = 10;

    /**
     * @return array<int|string, \Filament\Schemas\Components\Component>
     */
    public function getFormSchema(): array
    {
        return [];
    }

    public function getPayload(): GeoMapWidgetData
    {
        return app(BuildGeoMapWidgetPayloadAction::class)->execute();
    }
}
