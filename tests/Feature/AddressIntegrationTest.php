<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Feature;

use Modules\Geo\Enums\AddressTypeEnum;
use Modules\Geo\Tests\TestCase;
use Modules\Xot\Actions\Cast\SafeIntCastAction;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/**
 * In-memory Address tests (no factories / DB / container).
 * Keep business rules verifiable without touching app code.
 */

/**
<<<<<<< HEAD
* Build an in-memory address array with sane defaults.
=======
 * Build an in-memory address array with sane defaults.
>>>>>>> laraxot/dev
 *
 * @param  array<string, mixed>  $overrides
 * @return array<string, mixed>
 */
function makeAddress(array $overrides = []): array
{
    static $autoId = 0;
    $autoId = SafeIntCastAction::cast($autoId) + 1;

    $defaults = [
        'id' => $autoId,
        'model_type' => null,
        'model_id' => null,
        'route' => 'Via Roma',
        'street_number' => '1',
        'locality' => 'Milano',
        'administrative_area_level_2' => 'MI',
        'postal_code' => '20100',
        'country' => 'Italia',
        'is_primary' => false,
        'type' => AddressTypeEnum::HOME->value,
        'latitude' => null,
        'longitude' => null,
        'place_id' => null,
        'formatted_address' => null,
        'extra_data' => [],
        'deleted_at' => null,
    ];

<<<<<<< HEAD
   return array_replace($defaults, $overrides);
=======
    return array_replace($defaults, $overrides);
>>>>>>> laraxot/dev
}

/**
 * Compose a displayable full address from array parts.
 *
 * @param  array<string, mixed>  $address
 */
function formatFullAddress(array $address): string
{
    $parts = array_filter(
        [
            $address['route'] ?? null,
            $address['street_number'] ?? null,
            $address['locality'] ?? null,
            $address['postal_code'] ?? null,
            $address['country'] ?? null,
        ],
        static fn (mixed $value): bool => (SafeStringCastAction::cast($value)) !== '',
    );

    return implode(', ', array_map(static fn (mixed $part): string => SafeStringCastAction::cast($part), $parts));
}

describe('Address Integration', function () {
    it('can attach address to patient via polymorphic relationship', function () {
<<<<<<< HEAD
       $patient = ['id' => 1001, 'type' => 'patient'];
=======
        $patient = ['id' => 1001, 'type' => 'patient'];
>>>>>>> laraxot/dev

        $address = makeAddress([
            'model_type' => 'patient',
            'model_id' => $patient['id'],
            'route' => 'Via Roma',
            'street_number' => '123',
            'locality' => 'Milano',
            'postal_code' => '20100',
            'is_primary' => true,
        ]);

<<<<<<< HEAD
       Assert::assertSame('patient', $address['model_type']);
=======
        Assert::assertSame('patient', $address['model_type']);
>>>>>>> laraxot/dev
        Assert::assertSame($patient['id'], $address['model_id']);
        Assert::assertTrue($address['is_primary']);
    });

    it('generates proper full address from components', function () {
        $address = makeAddress([
            'route' => 'Via Giuseppe Verdi',
            'street_number' => '42',
            'locality' => 'Milano',
            'administrative_area_level_2' => 'MI',
            'postal_code' => '20121',
            'country' => 'Italia',
        ]);

        $fullAddress = formatFullAddress($address);

<<<<<<< HEAD
       Assert::assertStringContainsString('Via Giuseppe Verdi', $fullAddress);
=======
        Assert::assertStringContainsString('Via Giuseppe Verdi', $fullAddress);
>>>>>>> laraxot/dev
        Assert::assertStringContainsString('42', $fullAddress);
        Assert::assertStringContainsString('Milano', $fullAddress);
        Assert::assertStringContainsString('20121', $fullAddress);
    });

    it('handles geolocation data correctly', function () {
        $milan = makeAddress([
            'latitude' => 45.4642,
            'longitude' => 9.1900,
        ]);

<<<<<<< HEAD
       Assert::assertSame(45.4642, $milan['latitude']);
=======
        Assert::assertSame(45.4642, $milan['latitude']);
>>>>>>> laraxot/dev
        Assert::assertSame(9.1900, $milan['longitude']);
    });

    it('can store Google Places API data', function () {
        $address = makeAddress([
            'place_id' => 'ChIJu46S-ZZjhkcRLuFvLjVZ400',
            'formatted_address' => 'Piazza del Duomo, 20121 Milano MI, Italy',
            'extra_data' => [
                'google_types' => ['establishment', 'point_of_interest'],
                'rating' => 4.5,
                'business_status' => 'OPERATIONAL',
            ],
        ]);

<<<<<<< HEAD
       Assert::assertSame('ChIJu46S-ZZjhkcRLuFvLjVZ400', $address['place_id']);
=======
        Assert::assertSame('ChIJu46S-ZZjhkcRLuFvLjVZ400', $address['place_id']);
>>>>>>> laraxot/dev
        $extraData = $address['extra_data'];
        Assert::assertIsArray($extraData);
        Assert::assertIsArray($extraData['google_types'] ?? null);
        Assert::assertStringContainsString('Piazza del Duomo', SafeStringCastAction::cast($address['formatted_address']));
        Assert::assertContains('establishment', $extraData['google_types']);
        Assert::assertSame(4.5, $extraData['rating']);
    });

    it('supports multiple addresses per entity', function () {
        $patient = ['id' => 2001, 'type' => 'patient'];

        $homeAddress = makeAddress([
            'model_type' => 'patient',
            'model_id' => $patient['id'],
            'type' => AddressTypeEnum::HOME->value,
            'is_primary' => true,
        ]);

        $workAddress = makeAddress([
            'model_type' => 'patient',
<<<<<<< HEAD
           'model_id' => $patient['id'],
=======
            'model_id' => $patient['id'],
>>>>>>> laraxot/dev
            'type' => AddressTypeEnum::WORK->value,
            'is_primary' => false,
        ]);

        $patientAddresses = [$homeAddress, $workAddress];

<<<<<<< HEAD
       Assert::assertCount(2, $patientAddresses);
=======
        Assert::assertCount(2, $patientAddresses);
>>>>>>> laraxot/dev

        $primary = null;
        foreach ($patientAddresses as $addr) {
            if ($addr['is_primary'] === true) {
                $primary = $addr;
                break;
            }
        }
<<<<<<< HEAD
       Assert::assertNotNull($primary);
=======
        Assert::assertNotNull($primary);
>>>>>>> laraxot/dev
        Assert::assertSame($homeAddress['id'], $primary['id']);
    });

    it('handles soft deletion correctly', function () {
        $address = makeAddress();

<<<<<<< HEAD
       $address['deleted_at'] = date('c');
=======
        $address['deleted_at'] = date('c');
>>>>>>> laraxot/dev

        Assert::assertNotNull($address['deleted_at']);
    });
});
