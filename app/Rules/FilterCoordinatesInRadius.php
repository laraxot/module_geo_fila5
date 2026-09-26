<?php

declare(strict_types=1);

namespace Modules\Geo\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
<<<<<<< .merge_file_APJSjl
use Illuminate\Translation\PotentiallyTranslatedString;
=======
>>>>>>> .merge_file_gQolSJ
use Modules\Geo\Actions\FilterCoordinatesInRadiusAction;

/**
 * Regola di validazione per filtrare le coordinate all'interno di un raggio.
 */
class FilterCoordinatesInRadius implements ValidationRule
{
<<<<<<< .merge_file_APJSjl
=======
    private string $message = '';

>>>>>>> .merge_file_gQolSJ
    public function __construct(
        private readonly FilterCoordinatesInRadiusAction $filterAction,
        private readonly float $centerLatitude,
        private readonly float $centerLongitude,
        private readonly int $radius,
<<<<<<< .merge_file_APJSjl
    ) {
=======
    ) {}

    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if (! $this->passes($attribute, $value)) {
            $fail($this->message());
        }
>>>>>>> .merge_file_gQolSJ
    }

    /**
     * Determina se le coordinate passate sono all'interno del raggio specificato.
     *
<<<<<<< .merge_file_APJSjl
     * @param string                                                  $attribute Nome dell'attributo
     * @param mixed                                                   $value     Valore da validare
     * @param \Closure(string, ?string=): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if (! \is_array($value)) {
            $fail('Il valore deve essere un array di coordinate');

            return;
        }

        /** @var array<array{latitude: string, longitude: string}> $coordinates */
        $coordinates = array_map(static function (mixed $coordinate): array {
=======
     * @param  mixed  $_attribute  Nome dell'attributo
     * @param  mixed  $value  Valore da validare
     */
    public function passes(mixed $_attribute, mixed $value): bool
    {
        if (! \is_array($value)) {
            $this->message = 'Il valore deve essere un array di coordinate';

            return false;
        }

        /** @var array<array{latitude: string, longitude: string}> $coordinates */
        $coordinates = array_map(static function ($coordinate): array {
>>>>>>> .merge_file_gQolSJ
            if (! \is_array($coordinate)) {
                return ['latitude' => '', 'longitude' => ''];
            }

            $latitude = $coordinate['latitude'] ?? null;
            $longitude = $coordinate['longitude'] ?? null;

            return [
                'latitude' => \is_scalar($latitude) ? ((string) $latitude) : '',
                'longitude' => \is_scalar($longitude) ? ((string) $longitude) : '',
            ];
        }, $value);

        $filteredCoordinates = $this->filterAction->execute(
            $this->centerLatitude,
            $this->centerLongitude,
            $coordinates,
            $this->radius,
        );

<<<<<<< .merge_file_APJSjl
        if ([] === $filteredCoordinates) {
            $fail($this->message());
        }
=======
        return \count($filteredCoordinates) > 0;
>>>>>>> .merge_file_gQolSJ
    }

    /**
     * Ottiene il messaggio di errore per la validazione fallita.
     */
    public function message(): string
    {
<<<<<<< .merge_file_APJSjl
        return 'Nessuna coordinata trovata nel raggio specificato';
=======
        return $this->message ?: 'Nessuna coordinata trovata nel raggio specificato';
>>>>>>> .merge_file_gQolSJ
    }
}
