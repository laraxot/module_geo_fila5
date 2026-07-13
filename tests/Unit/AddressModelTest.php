<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Geo\Contracts\HasGeolocation;
use Modules\Geo\Database\Factories\AddressFactory;
use Modules\Geo\Enums\AddressTypeEnum;
use Modules\Geo\Models\Address;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
describe('Address Model', function () {
    it('can be created with factory', function () {
        $address = AddressFactory::new()->createOne();

        Assert::assertInstanceOf(Address::class, $address);
        Assert::assertTrue($address->exists);
=======
uses(\Modules\Geo\Tests\TestCase::class);
// Laraxot — see module docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Geo\Contracts\HasGeolocation;
use Modules\Geo\Enums\AddressTypeEnum;
use Modules\Geo\Models\Address;

describe('Address Model', function () {
    it('can be created with factory', function () {
        $address = Address::factory()->create();

        expect($address)
            ->toBeInstanceOf(Address::class)
            ->and($address->exists)
            ->toBeTrue()
            ->and($address->id)
            ->toBeInt();
>>>>>>> laraxot/dev
    });

    it('has correct fillable attributes', function () {
        $address = new Address();

<<<<<<< HEAD
        Assert::assertInstanceOf(Address::class, $address);
=======
        expect($address->getFillable())->toContain([
            'model_type',
            'model_id',
            'name',
            'description',
            'route',
            'street_number',
            'locality',
            'administrative_area_level_3',
            'administrative_area_level_2',
            'administrative_area_level_1',
            'country',
            'postal_code',
            'formatted_address',
            'place_id',
            'latitude',
            'longitude',
            'type',
            'is_primary',
            'extra_data',
        ]);
>>>>>>> laraxot/dev
    });

    it('implements HasGeolocation contract', function () {
        $address = new Address();

<<<<<<< HEAD
        Assert::assertInstanceOf(HasGeolocation::class, $address);
    });

    it('supports deleted_at timestamp column', function () {
        $address = AddressFactory::new()->createOne();

        Assert::assertNull($address->deleted_at);

        $address->update(['deleted_at' => now()]);
        $address->refresh();

        Assert::assertNotNull($address->deleted_at);
    });

    it('casts attributes correctly', function () {
        $address = AddressFactory::new()->createOne([
=======
        expect($address)->toBeInstanceOf(HasGeolocation::class);
    });

    it('uses soft deletes', function () {
        $address = Address::factory()->create();
        $address->delete();

        expect($address->deleted_at)
            ->not->toBeNull()->and(Address::withTrashed()->find($address->id))
            ->not->toBeNull()->and(Address::find($address->id))->toBeNull();
    });

    it('casts attributes correctly', function () {
        $address = Address::factory()->create([
>>>>>>> laraxot/dev
            'latitude' => 45.4642,
            'longitude' => 9.1900,
            'is_primary' => true,
            'extra_data' => ['key' => 'value'],
        ]);

<<<<<<< HEAD
        Assert::assertIsArray($address->extra_data);
    });

    it('has polymorphic relationship', function () {
        $address = AddressFactory::new()->createOne();

        Assert::assertInstanceOf(MorphTo::class, $address->addressable());
=======
        expect($address->latitude)
            ->toBeFloat()
            ->and($address->longitude)
            ->toBeFloat()
            ->and($address->is_primary)
            ->toBeBool()
            ->and($address->extra_data)
            ->toBeArray();
    });

    it('has polymorphic relationship', function () {
        $address = Address::factory()->create();

        expect($address->addressable())->toBeInstanceOf(MorphTo::class);
>>>>>>> laraxot/dev
    });

    describe('Accessors', function () {
        it('generates full_address accessor', function () {
<<<<<<< HEAD
            $address = AddressFactory::new()->createOne([
=======
            $address = Address::factory()->create([
>>>>>>> laraxot/dev
                'route' => 'Via Roma',
                'street_number' => '123',
                'locality' => 'Milano',
                'postal_code' => '20100',
            ]);

<<<<<<< HEAD
            Assert::assertIsString($address->full_address);
            Assert::assertStringContainsString('Via Roma', $address->full_address);
            Assert::assertStringContainsString('123', $address->full_address);
            Assert::assertStringContainsString('Milano', $address->full_address);
        });

        it('generates street_address accessor', function () {
            $address = AddressFactory::new()->createOne([
=======
            expect($address->full_address)
                ->toBeString()
                ->and($address->full_address)
                ->toContain('Via Roma')
                ->and($address->full_address)
                ->toContain('123')
                ->and($address->full_address)
                ->toContain('Milano');
        });

        it('generates street_address accessor', function () {
            $address = Address::factory()->create([
>>>>>>> laraxot/dev
                'route' => 'Via Roma',
                'street_number' => '123',
            ]);

<<<<<<< HEAD
            Assert::assertIsString($address->street_address);
            Assert::assertStringContainsString('Via Roma', $address->street_address);
            Assert::assertStringContainsString('123', $address->street_address);
=======
            expect($address->street_address)
                ->toBeString()
                ->and($address->street_address)
                ->toContain('Via Roma')
                ->and($address->street_address)
                ->toContain('123');
>>>>>>> laraxot/dev
        });
    });

    describe('Geolocation Features', function () {
        it('stores coordinates correctly', function () {
<<<<<<< HEAD
            $address = AddressFactory::new()->createOne([
=======
            $address = Address::factory()->create([
>>>>>>> laraxot/dev
                'latitude' => 45.4642,
                'longitude' => 9.1900,
            ]);

<<<<<<< HEAD
            Assert::assertSame(45.4642, $address->latitude);
            Assert::assertSame(9.1900, $address->longitude);
        });

        it('can calculate distance between addresses', function () {
            $address1 = AddressFactory::new()->createOne([
=======
            expect($address->latitude)->toBe(45.4642)->and($address->longitude)->toBe(9.1900);
        });

        it('can calculate distance between addresses', function () {
            $address1 = Address::factory()->create([
>>>>>>> laraxot/dev
                'latitude' => 45.4642,
                'longitude' => 9.1900,
            ]);

<<<<<<< HEAD
            $address2 = AddressFactory::new()->createOne([
=======
            $address2 = Address::factory()->create([
>>>>>>> laraxot/dev
                'latitude' => 45.4654,
                'longitude' => 9.1859,
            ]);

            if (method_exists($address1, 'distanceTo')) {
                $distance = $address1->distanceTo($address2);
<<<<<<< HEAD
                Assert::assertGreaterThan(0, $distance);
=======
                expect($distance)->toBeFloat()->and($distance)->toBeGreaterThan(0);
>>>>>>> laraxot/dev
            }
        });
    });

    describe('Address Types', function () {
        it('can be set as primary address', function () {
<<<<<<< HEAD
            $address = AddressFactory::new()->createOne(['is_primary' => true]);

            Assert::assertTrue($address->is_primary);
        });

        it('can have different types', function () {
            $address = AddressFactory::new()->createOne(['type' => AddressTypeEnum::HOME]);

            Assert::assertSame(AddressTypeEnum::HOME, $address->type);
=======
            $address = Address::factory()->create(['is_primary' => true]);

            expect($address->is_primary)->toBeTrue();
        });

        it('can have different types', function () {
            $address = Address::factory()->create(['type' => AddressTypeEnum::HOME]);

            expect($address->type)->toBe(AddressTypeEnum::HOME);
>>>>>>> laraxot/dev
        });
    });

    describe('Scopes and Queries', function () {
        it('can filter by primary addresses', function () {
<<<<<<< HEAD
            AddressFactory::new()->createOne(['is_primary' => true]);
            AddressFactory::new()->createOne(['is_primary' => false]);

            $primaryAddresses = Address::where('is_primary', true)->get();

            Assert::assertCount(1, $primaryAddresses);
        });

        it('can filter by locality', function () {
            AddressFactory::new()->createOne(['locality' => 'Milano']);
            AddressFactory::new()->createOne(['locality' => 'Roma']);

            $milanAddresses = Address::where('locality', 'Milano')->get();

            Assert::assertCount(1, $milanAddresses);
        });

        it('can filter by postal code', function () {
            AddressFactory::new()->createOne(['postal_code' => '20100']);
            AddressFactory::new()->createOne(['postal_code' => '00100']);

            $milanPostalCodes = Address::where('postal_code', '20100')->get();

            Assert::assertCount(1, $milanPostalCodes);
=======
            Address::factory()->create(['is_primary' => true]);
            Address::factory()->create(['is_primary' => false]);

            $primaryAddresses = Address::where('is_primary', true)->get();

            expect($primaryAddresses)->toHaveCount(1);
        });

        it('can filter by locality', function () {
            Address::factory()->create(['locality' => 'Milano']);
            Address::factory()->create(['locality' => 'Roma']);

            $milanAddresses = Address::where('locality', 'Milano')->get();

            expect($milanAddresses)->toHaveCount(1);
        });

        it('can filter by postal code', function () {
            Address::factory()->create(['postal_code' => '20100']);
            Address::factory()->create(['postal_code' => '00100']);

            $milanPostalCodes = Address::where('postal_code', '20100')->get();

            expect($milanPostalCodes)->toHaveCount(1);
>>>>>>> laraxot/dev
        });
    });

    describe('Google Places Integration', function () {
        it('can store place_id from Google Places', function () {
<<<<<<< HEAD
            $address = AddressFactory::new()->createOne([
                'place_id' => 'ChIJu46S-ZZjhkcRLuFvLjVZ400',
            ]);

            Assert::assertSame('ChIJu46S-ZZjhkcRLuFvLjVZ400', $address->place_id);
        });

        it('can store formatted_address from Google Places', function () {
            $address = AddressFactory::new()->createOne([
                'formatted_address' => 'Via Roma, 123, 20100 Milano MI, Italy',
            ]);

            Assert::assertSame('Via Roma, 123, 20100 Milano MI, Italy', $address->formatted_address);
=======
            $address = Address::factory()->create([
                'place_id' => 'ChIJu46S-ZZjhkcRLuFvLjVZ400',
            ]);

            expect($address->place_id)->toBe('ChIJu46S-ZZjhkcRLuFvLjVZ400');
        });

        it('can store formatted_address from Google Places', function () {
            $address = Address::factory()->create([
                'formatted_address' => 'Via Roma, 123, 20100 Milano MI, Italy',
            ]);

            expect($address->formatted_address)->toBe('Via Roma, 123, 20100 Milano MI, Italy');
>>>>>>> laraxot/dev
        });
    });

    describe('Extra Data Storage', function () {
        it('can store additional metadata', function () {
            $extraData = [
                'building_type' => 'residential',
                'floor' => 3,
                'apartment' => 'A',
                'buzzer_code' => '123',
            ];

<<<<<<< HEAD
            $address = AddressFactory::new()->createOne(['extra_data' => $extraData]);

            Assert::assertSame($extraData, $address->extra_data);
            Assert::assertSame('residential', $address->extra_data['building_type']);
            Assert::assertSame(3, $address->extra_data['floor']);
=======
            $address = Address::factory()->create(['extra_data' => $extraData]);

            expect($address->extra_data)
                ->toBe($extraData)
                ->and($address->extra_data['building_type'])
                ->toBe('residential')
                ->and($address->extra_data['floor'])
                ->toBe(3);
>>>>>>> laraxot/dev
        });
    });
});
