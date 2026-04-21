<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Closure;
use Modules\Xot\Filament\Forms\Components\XotBaseField;
use Webmozart\Assert\Assert;

class MapPicker extends XotBaseField
{
    protected string $view = 'geo::filament.forms.components.map-picker';

    protected string|Closure|null $latitudeField = null;

    protected string|Closure|null $longitudeField = null;

    protected bool|Closure $reverseGeocoding = true;

    protected bool|Closure $geolocateWhenEmpty = true;

    protected int|Closure $zoom = 15;

    protected function setUp(): void
    {
        parent::setUp();

        $this->dehydrated(false);
    }

    public function latitude(string|Closure $path): static
    {
        $this->latitudeField = $path;

        return $this;
    }

    public function longitude(string|Closure $path): static
    {
        $this->longitudeField = $path;

        return $this;
    }

    public function reverseGeocoding(bool|Closure $condition = true): static
    {
        $this->reverseGeocoding = $condition;

        return $this;
    }

    public function geolocateWhenEmpty(bool|Closure $condition = true): static
    {
        $this->geolocateWhenEmpty = $condition;

        return $this;
    }

    public function zoom(int|Closure $zoom): static
    {
        $this->zoom = $zoom;

        return $this;
    }

    public function getLatitudeField(): string
    {
        Assert::string($field = $this->evaluate($this->latitudeField) ?? 'latitude');

        return $field;
    }

    public function getLongitudeField(): string
    {
        Assert::string($field = $this->evaluate($this->longitudeField) ?? 'longitude');

        return $field;
    }

    public function shouldReverseGeocode(): bool
    {
        $res = $this->evaluate($this->reverseGeocoding);
        Assert::boolean($res);

        return $res;
    }

    public function shouldGeolocateWhenEmpty(): bool
    {
        $res = $this->evaluate($this->geolocateWhenEmpty);
        Assert::boolean($res);

        return $res;
    }

    public function getZoom(): int
    {
        $res = $this->evaluate($this->zoom);
        Assert::integer($res);

        return $res;
    }

    public function getLatitudeStatePath(): string
    {
        return $this->resolveSiblingStatePath($this->getLatitudeField());
    }

    public function getLongitudeStatePath(): string
    {
        return $this->resolveSiblingStatePath($this->getLongitudeField());
    }

    protected function resolveSiblingStatePath(string $path): string
    {
        if (str_contains($path, '.')) {
            return $path;
        }

        $statePath = $this->resolveCurrentStatePath();

        if ($statePath === null || ! str_contains($statePath, '.')) {
            return $path;
        }

        $parentStatePath = (string) str($statePath)->beforeLast('.');

        if ($parentStatePath === '') {
            return $path;
        }

        return $parentStatePath.'.'.$path;
    }

    protected function resolveCurrentStatePath(): ?string
    {
        try {
            return $this->getStatePath();
        } catch (\Error) {
            return $this->statePath;
        }
    }
}
