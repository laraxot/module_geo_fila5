<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\IPGeolocation;

uses(\Modules\Geo\Tests\LightTestCase::class);

use Modules\Geo\Actions\IPGeolocation\FetchIPLocationAction;
use Modules\Geo\Actions\IPGeolocation\GetLocationFromIPAction;
use Modules\Geo\Datas\IPLocationData;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

it('delegates to fetch action and returns result', function (): void {
    $fetchAction = new FetchIPLocationReturningStub(new IPLocationData(
        ip: '8.8.8.8',
        city: 'Ashburn',
        region: null,
        country: 'US',
        countryName: 'United States',
        latitude: null,
        longitude: null,
        timezone: null,
        isp: null,
    ));
    $action = new GetLocationFromIPAction($fetchAction);

    $result = $action->execute('8.8.8.8');

    Assert::assertInstanceOf(IPLocationData::class, $result);
    Assert::assertSame('8.8.8.8', $result->ip);
    Assert::assertSame('Ashburn', $result->city);
});

it('propagates exception when fetch action throws', function (): void {
    $fetchAction = new FetchIPLocationThrowingStub(new \RuntimeException('not found'));
    $action = new GetLocationFromIPAction($fetchAction);

    try {
        $action->execute('192.168.1.1');
        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('not found', $exception->getMessage());
    }
});

/**
 * @internal
 */
final class FetchIPLocationReturningStub extends FetchIPLocationAction
{
    public function __construct(
        private readonly IPLocationData $locationData,
    ) {
    }

    public function execute(string $ip): IPLocationData
    {
        return $this->locationData;
    }
}

/**
 * @internal
 */
final class FetchIPLocationThrowingStub extends FetchIPLocationAction
{
    public function __construct(
        private readonly \RuntimeException $exception,
    ) {
    }

    public function execute(string $ip): IPLocationData
    {
        throw $this->exception;
    }
}
