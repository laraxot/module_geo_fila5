<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Fixtures;

use Illuminate\Support\Collection;
use Modules\Geo\Actions\GoogleMaps\CalculateDistanceMatrixAction;
use Modules\Geo\Datas\LocationData;

/**
 * @internal
 */
final class CalculateDistanceMatrixActionStub extends CalculateDistanceMatrixAction
{
    /**
<<<<<<< HEAD
     * @param  array<array<array{distance: array{text: string, value: int}, duration: array{text: string, value: int}, status: string}>>  $response
=======
     * @param array<array<array{distance: array{text: string, value: int}, duration: array{text: string, value: int}, status: string}>> $response
>>>>>>> laraxot/dev
     */
    public function __construct(
        private array $response = [],
        private ?\Throwable $exception = null,
<<<<<<< HEAD
    ) {}

    /**
     * @param  Collection<int, LocationData>  $origins
     * @param  Collection<int, LocationData>  $destinations
=======
    ) {
    }

    /**
     * @param Collection<int, LocationData> $origins
     * @param Collection<int, LocationData> $destinations
     *
>>>>>>> laraxot/dev
     * @return array<array<array{distance: array{text: string, value: int}, duration: array{text: string, value: int}, status: string}>>
     */
    public function execute(Collection $origins, Collection $destinations): array
    {
<<<<<<< HEAD
        if ($this->exception !== null) {
=======
        if (null !== $this->exception) {
>>>>>>> laraxot/dev
            throw $this->exception;
        }

        return $this->response;
    }
}
