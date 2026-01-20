<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Filament\Schemas\Components\Section;
use Modules\Geo\Filament\Resources\AddressResource;

// use Squire\Models\Country;

class AddressSection extends Section
{
    // protected string $view = 'filament-forms::components.group';

    protected bool $disableLiveUpdates = false;

    protected function setUp(): void
    {
        parent::setUp();
        $this->columns(2);
    }

    protected function getFormSchema(): array
    {
        $res = AddressResource::getFormSchema();
        unset($res['name'], $res['is_primary']);

        return $res;
    }

    /*
    public function saveRelationships(): void
    {

        $state = $this->getState();
        $record = $this->getRecord();
        $relationship = $record->{$this->getRelationship()}();

        if (null === $relationship) {
            return;
        }
        if ($address = $relationship->first()) {
            $address->update($state);
        } else {
            $relationship->updateOrCreate($state);
        }

        $record->touch();
    }
    */
}
