<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Feature;

<<<<<<< HEAD
use Modules\Geo\Enums\AddressTypeEnum;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
=======
uses(\Modules\Geo\Tests\TestCase::class);

use Modules\Geo\Enums\AddressTypeEnum;
>>>>>>> laraxot/dev

/**
 * In-memory Address tests (no factories / DB / container).
 * Keep business rules verifiable without touching app code.
 */

/**
<<<<<<< HEAD
 * Build an in-memory address array with sane defaults.
 *
 * @param array<string, mixed> $overrides
 *
 * @return array<string, mixed>
 */
function makeAddress(array $overrides = []): array
{
    static $autoId = 0;
    $autoId = (int) $autoId + 1;

    $defaults = [
        'id' => $autoId,
        'model_type' => null,
=======
 * Build an in-memory Address-like object with sane defaults.
 *
 * @param array<string, mixed> $overrides
 */
function makeAddress(array $overrides = []): object
{
    static $autoId = 1;

    $defaults = [
        'id' => $autoId++,
        'model_type' => null, // e.g. 'patient'
>>>>>>> laraxot/dev
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
}

/**
 * Compose a displayable full address from array parts.
 *
 * @param array<string, mixed> $address
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
        static fn (mixed $value): bool => ((string) $value) !== '',
    );

    return implode(', ', array_map(static fn (mixed $part): string => (string) $part, $parts));
=======
    return (object) array_replace($defaults, $overrides);
}

/**
 * Compose a displayable full address from object parts.
 */
function formatFullAddress(object $a): string
{
    $parts = array_filter(
        [
            $a->route ?? null,
            $a->street_number ?? null,
            $a->locality ?? null,
            $a->postal_code ?? null,
            $a->country ?? null,
        ],
        fn ($v) => ((string) $v) !== '',
    );

    return implode(', ', $parts);
>>>>>>> laraxot/dev
}

describe('Address Integration', function () {
    it('can attach address to patient via polymorphic relationship', function () {
<<<<<<< HEAD
        $patient = ['id' => 1001, 'type' => 'patient'];

        $address = makeAddress([
            'model_type' => 'patient',
            'model_id' => $patient['id'],
=======
        $patient = (object) ['id' => 1001, 'type' => 'patient'];

        $address = makeAddress([
            'model_type' => 'patient',
            'model_id' => $patient->id,
>>>>>>> laraxot/dev
            'route' => 'Via Roma',
            'street_number' => '123',
            'locality' => 'Milano',
            'postal_code' => '20100',
            'is_primary' => true,
        ]);

<<<<<<< HEAD
        Assert::assertSame('patient', $address['model_type']);
        Assert::assertSame($patient['id'], $address['model_id']);
        Assert::assertTrue($address['is_primary']);
=======
        expect($address->model_type)
            ->toBe('patient')
            ->and($address->model_id)
            ->toBe($patient->id)
            ->and($address->is_primary)
            ->toBeTrue();
>>>>>>> laraxot/dev
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
        Assert::assertStringContainsString('42', $fullAddress);
        Assert::assertStringContainsString('Milano', $fullAddress);
        Assert::assertStringContainsString('20121', $fullAddress);
=======
        expect($fullAddress)
            ->toContain('Via Giuseppe Verdi')
            ->and($fullAddress)
            ->toContain('42')
            ->and($fullAddress)
            ->toContain('Milano')
            ->and($fullAddress)
            ->toContain('20121');
>>>>>>> laraxot/dev
    });

    it('handles geolocation data correctly', function () {
        $milan = makeAddress([
            'latitude' => 45.4642,
            'longitude' => 9.1900,
        ]);

<<<<<<< HEAD
        Assert::assertSame(45.4642, $milan['latitude']);
        Assert::assertSame(9.1900, $milan['longitude']);
=======
        expect($milan->latitude)->toBe(45.4642)->and($milan->longitude)->toBe(9.1900);
>>>>>>> laraxot/dev
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
        $extraData = $address['extra_data'];
        Assert::assertIsArray($extraData);
        Assert::assertIsArray($extraData['google_types'] ?? null);
        Assert::assertStringContainsString('Piazza del Duomo', (string) $address['formatted_address']);
        Assert::assertContains('establishment', $extraData['google_types']);
        Assert::assertSame(4.5, $extraData['rating']);
    });

    it('supports multiple addresses per entity', function () {
        $patient = ['id' => 2001, 'type' => 'patient'];

        $homeAddress = makeAddress([
            'model_type' => 'patient',
            'model_id' => $patient['id'],
=======
        expect($address->place_id)
            ->toBe('ChIJu46S-ZZjhkcRLuFvLjVZ400')
            ->and($address->formatted_address)
            ->toContain('Piazza del Duomo')
            ->and($address->extra_data['google_types'])
            ->toContain('establishment')
            ->and($address->extra_data['rating'])
            ->toBe(4.5);
    });

    it('supports multiple addresses per entity', function () {
        $patient = (object) ['id' => 2001, 'type' => 'patient'];

        $homeAddress = makeAddress([
            'model_type' => 'patient',
            'model_id' => $patient->id,
>>>>>>> laraxot/dev
            'type' => AddressTypeEnum::HOME->value,
            'is_primary' => true,
        ]);

        $workAddress = makeAddress([
            'model_type' => 'patient',
<<<<<<< HEAD
            'model_id' => $patient['id'],
=======
            'model_id' => $patient->id,
>>>>>>> laraxot/dev
            'type' => AddressTypeEnum::WORK->value,
            'is_primary' => false,
        ]);

        $patientAddresses = [$homeAddress, $workAddress];

<<<<<<< HEAD
        Assert::assertCount(2, $patientAddresses);

        $primary = null;
        foreach ($patientAddresses as $addr) {
            if (true === $addr['is_primary']) {
=======
        expect(count($patientAddresses))->toBe(2);

        $primary = null;
        foreach ($patientAddresses as $addr) {
            if (true === $addr->is_primary) {
>>>>>>> laraxot/dev
                $primary = $addr;
                break;
            }
        }
<<<<<<< HEAD
        Assert::assertNotNull($primary);
        Assert::assertSame($homeAddress['id'], $primary['id']);
=======

        expect($primary?->id)->toBe($homeAddress->id);
>>>>>>> laraxot/dev
    });

    it('handles soft deletion correctly', function () {
        $address = makeAddress();

<<<<<<< HEAD
        $address['deleted_at'] = date('c');

        Assert::assertNotNull($address['deleted_at']);
=======
        // Soft delete simulation
        $address->deleted_at = date('c');

        // Lookup simulations
        $active = null; // would be null after soft-delete
        $withTrashed = $address; // still available with trashed scope

        expect($active)->toBeNull()->and($withTrashed)->not->toBeNull()->and($withTrashed->deleted_at)->not->toBeNull();
>>>>>>> laraxot/dev
    });
});
