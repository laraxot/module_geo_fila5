<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Filament\Forms\Components\Field;

/**
 * Address input with browser geolocation button.
 *
 * Renders a Design Comuni-compliant address field with a "Use my location"
 * button that calls the browser Geolocation API + Nominatim reverse geocoding.
 *
 * Owned by Geo module because geolocation is a cross-cutting geo-spatial concern.
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/API/Geolocation_API
 * @see https://nominatim.org/release-docs/develop/api/Reverse/
 */
class AddressInput extends Field
{
    protected string $view = 'geo::filament.forms.components.address-input';

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('geo::address.fields.address.label'));
        $this->required();
        $this->rule('max:255');
        $this->default('');
        $this->viewData(['placeholder' => __('geo::address.fields.address.placeholder')]);
        $this->live(onBlur: false);
    }

    /**
     * Set the SVG sprite path for icons.
     */
    public function sprite(string $path): static
    {
        $this->viewData(['sprite' => $path]);

        return $this;
    }

    public function spritePath(string $path): static
    {
        return $this->sprite($path);
    }

}
