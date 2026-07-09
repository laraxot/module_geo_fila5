<?php

declare(strict_types=1);

namespace Modules\Geo\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Modules\Geo\Datas\AddressData;
use Spatie\QueueableAction\QueueableAction;

/**
 * Action per aggiornare le coordinate geografiche di un modello basandosi sul suo indirizzo.
 */
class UpdateCoordinatesFromAddressAction
{
    use QueueableAction;

    /**
     * @var Collection<int, string>
     */
    private Collection $errors;

    public function __construct(
        private readonly GetAddressDataFromFullAddressAction $getAddressDataAction,
    ) {
        $this->errors = $this->newErrorCollection();
    }

    public function execute(Model $model): bool
    {
        $this->errors = $this->newErrorCollection();

        $fullAddress = $this->getFullAddressFromModel($model);

        if (empty($fullAddress)) {
            $this->errors->push(__('geo::actions.update_coordinates.errors.empty_address'));

            return false;
        }

        $addressData = $this->getAddressDataAction->execute($fullAddress);

        if (null === $addressData) {
            $this->recordGeocodingFailure($this->getAddressDataAction->getErrors());

            return false;
        }

        return $this->updateModelCoordinates($model, $addressData);
    }

    /**
     * @param Collection<int, string> $geocodingErrors
     */
    private function recordGeocodingFailure(Collection $geocodingErrors): void
    {
        if ($geocodingErrors->isEmpty()) {
            $this->errors->push(__('geo::actions.update_coordinates.errors.geocoding_failed'));

            return;
        }

        foreach ($geocodingErrors as $error) {
            if (\is_string($error)) {
                $this->errors->push($error);
            }
        }
    }

    /**
     * @return Collection<int, string>
     */
    private function newErrorCollection(): Collection
    {
        /** @var Collection<int, string> $errors */
        $errors = new Collection();

        return $errors;
    }

    /**
     * @return Collection<int, string>
     */
    public function getErrors(): Collection
    {
        return $this->errors;
    }

    private function getFullAddressFromModel(Model $model): string
    {
        /** @var string|int|float|bool|null $fullAddressRaw */
        $fullAddressRaw = $model->getAttribute('full_address');

        if (method_exists($model, 'getFullAddressAttribute')) {
            $fullAddress = $model->getFullAddressAttribute($fullAddressRaw);

            return is_string($fullAddress) ? $fullAddress : '';
        }

        return is_string($fullAddressRaw) ? $fullAddressRaw : '';
    }

    private function updateModelCoordinates(Model $model, AddressData $addressData): bool
    {
        try {
            $model->update([
                'latitude' => $addressData->latitude,
                'longitude' => $addressData->longitude,
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Errore aggiornamento coordinate', [
                'model' => $model::class,
                'model_id' => $model->getKey(),
                'error' => $e->getMessage(),
            ]);

            $this->errors->push($e->getMessage());

            return false;
        }
    }
}
