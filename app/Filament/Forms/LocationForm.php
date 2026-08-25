<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms;

use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Support\Collection;
use Modules\Geo\Models\ComuneJson;

/**
 * Form per la selezione della località.
 *
 * Questo form fornisce una selezione a cascata per regione, provincia, città e CAP.
 *
 * @see \Modules\Geo\docs\json-database.md
 * @see Modules\Geo\Filament\Forms\LocationForm
 */
class LocationForm
{
    /**
     * Costruttore.
     */
    public function __construct()
    {
        // No initialization needed as we're using static methods
    }

    /**
     * Ottiene lo schema del form.
     *
     * @return array<int, Select>
     */
    public function getSchema(): array
    {
        return [
            Select::make('region')
                ->label('geo::fields.region.label')
                ->placeholder('geo::fields.region.placeholder')
                ->options(ComuneJson::allRegions()->toArray(...))
                ->searchable()
                ->required()
                ->live()
                ->afterStateUpdated(fn () => ComuneJson::clearCache(false)),
            Select::make('province')
                ->label('geo::fields.province.label')
                ->placeholder('geo::fields.province.placeholder')
<<<<<<< HEAD
               ->options(function (Get $get): array {
=======
                ->options(function (Get $get): array {
>>>>>>> laraxot/dev
                    $region = $get('region');
                    if (! is_string($region) || ! filled($region)) {
                        return [];
                    }

                    return ComuneJson::getProvincesByRegion($region)->toArray();
                })
                ->searchable()
                ->required()
                ->live()
                ->afterStateUpdated(fn () => ComuneJson::clearCache(false))
                ->visible(fn (Get $get) => filled($get('region'))),
            Select::make('city')
                ->label('geo::fields.city.label')
                ->placeholder('geo::fields.city.placeholder')
                ->options(function (Get $get): array {
<<<<<<< HEAD
                   $province = $get('province');
=======
                    $province = $get('province');
>>>>>>> laraxot/dev
                    if (! is_string($province) || ! filled($province)) {
                        return [];
                    }

                    /** @var Collection<int, array{cap: array<int, string>, nome: string}> $cities */
<<<<<<< HEAD
                   $cities = ComuneJson::byProvince($province);
=======
                    $cities = ComuneJson::byProvince($province);
>>>>>>> laraxot/dev

                    return $cities->pluck('nome', 'nome')->toArray();
                })
                ->searchable()
                ->required()
                ->live()
                ->afterStateUpdated(fn () => ComuneJson::clearCache(false))
                ->visible(fn (Get $get) => filled($get('province'))),
            Select::make('cap')
                ->label('geo::fields.cap.label')
                ->placeholder('geo::fields.cap.placeholder')
                ->options(function (Get $get): array {
<<<<<<< HEAD
                   $province = $get('province');
=======
                    $province = $get('province');
>>>>>>> laraxot/dev
                    $city = $get('city');
                    if (! is_string($province) || ! filled($province) || ! is_string($city) || ! filled($city)) {
                        return [];
                    }

                    /** @var Collection<int, array{cap: array<int, string>, nome: string}> $cities */
<<<<<<< HEAD
                   $cities = ComuneJson::byProvince($province)->where('nome', $city);
=======
                    $cities = ComuneJson::byProvince($province)->where('nome', $city);
>>>>>>> laraxot/dev

                    if ($cities->isEmpty()) {
                        return [];
                    }

                    $caps = $cities->first()['cap'];

                    return array_combine($caps, $caps);
                })
                ->required()
                ->visible(fn (Get $get) => filled($get('city'))),
        ];
    }
}
