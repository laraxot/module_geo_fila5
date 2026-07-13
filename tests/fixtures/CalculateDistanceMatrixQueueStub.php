<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Fixtures;

use Illuminate\Support\Collection;
use Modules\Geo\Actions\GoogleMaps\CalculateDistanceMatrixAction;
use Modules\Geo\Datas\LocationData;

/**
 * @internal
 */
final class CalculateDistanceMatrixQueueStub extends CalculateDistanceMatrixAction
{
    /**
<<<<<<< HEAD
     * @param  list<array<mixed>>  $responses
     */
    public function __construct(
        private array $responses = [],
    ) {}
=======
     * @param list<array<mixed>> $responses
     */
    public function __construct(
        private array $responses = [],
    ) {
    }
>>>>>>> laraxot/dev

    private int $callIndex = 0;

    /**
<<<<<<< HEAD
     * @param  Collection<int, LocationData>  $origins
     * @param  Collection<int, LocationData>  $destinations
=======
     * @param Collection<int, LocationData> $origins
     * @param Collection<int, LocationData> $destinations
     *
>>>>>>> laraxot/dev
     * @return array<mixed>
     */
    public function execute(Collection $origins, Collection $destinations): array
    {
        unset($origins, $destinations);

        $response = $this->responses[$this->callIndex] ?? [[]];
<<<<<<< HEAD
        $this->callIndex++;
=======
        ++$this->callIndex;
>>>>>>> laraxot/dev

        return $response;
    }
}
