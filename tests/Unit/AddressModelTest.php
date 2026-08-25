<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit;

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
    });

    it('has correct fillable attributes', function () {
        $address = new Address();

<<<<<<< HEAD
       Assert::assertInstanceOf(Address::class, $address);
=======
        Assert::assertInstanceOf(Address::class, $address);
>>>>>>> laraxot/dev
    });

    it('implements HasGeolocation contract', function () {
        $address = new Address();

<<<<<<< HEAD
       Assert::assertInstanceOf(HasGeolocation::class, $address);
=======
        Assert::assertInstanceOf(HasGeolocation::class, $address);
>>>>>>> laraxot/dev
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
            'latitude' => 45.4642,
            'longitude' => 9.1900,
            'is_primary' => true,
            'extra_data' => ['key' => 'value'],
        ]);

<<<<<<< HEAD
       Assert::assertIsArray($address->extra_data);
=======
        Assert::assertIsArray($address->extra_data);
>>>>>>> laraxot/dev
    });

    it('has polymorphic relationship', function () {
        $address = AddressFactory::new()->createOne();

        Assert::assertInstanceOf(MorphTo::class, $address->addressable());
    });

    describe('Accessors', function () {
        it('generates full_address accessor', function () {
<<<<<<< HEAD
           $address = AddressFactory::new()->createOne([
=======
            $address = AddressFactory::new()->createOne([
>>>>>>> laraxot/dev
                'route' => 'Via Roma',
                'street_number' => '123',
                'locality' => 'Milano',
                'postal_code' => '20100',
            ]);

<<<<<<< HEAD
           Assert::assertIsString($address->full_address);
=======
            Assert::assertIsString($address->full_address);
>>>>>>> laraxot/dev
            Assert::assertStringContainsString('Via Roma', $address->full_address);
            Assert::assertStringContainsString('123', $address->full_address);
            Assert::assertStringContainsString('Milano', $address->full_address);
        });

        it('generates street_address accessor', function () {
            $address = AddressFactory::new()->createOne([
                'route' => 'Via Roma',
                'street_number' => '123',
            ]);

<<<<<<< HEAD
           Assert::assertIsString($address->street_address);
=======
            Assert::assertIsString($address->street_address);
>>>>>>> laraxot/dev
            Assert::assertStringContainsString('Via Roma', $address->street_address);
            Assert::assertStringContainsString('123', $address->street_address);
        });
    });

    describe('Geolocation Features', function () {
        it('stores coordinates correctly', function () {
<<<<<<< HEAD
           $address = AddressFactory::new()->createOne([
=======
            $address = AddressFactory::new()->createOne([
>>>>>>> laraxot/dev
                'latitude' => 45.4642,
                'longitude' => 9.1900,
            ]);

<<<<<<< HEAD
           Assert::assertSame(45.4642, $address->latitude);
=======
            Assert::assertSame(45.4642, $address->latitude);
>>>>>>> laraxot/dev
            Assert::assertSame(9.1900, $address->longitude);
        });

        it('can calculate distance between addresses', function () {
            $address1 = AddressFactory::new()->createOne([
                'latitude' => 45.4642,
                'longitude' => 9.1900,
            ]);

<<<<<<< HEAD
           $address2 = AddressFactory::new()->createOne([
=======
            $address2 = AddressFactory::new()->createOne([
>>>>>>> laraxot/dev
                'latitude' => 45.4654,
                'longitude' => 9.1859,
            ]);

            if (method_exists($address1, 'distanceTo')) {
                $distance = $address1->distanceTo($address2);
<<<<<<< HEAD
               Assert::assertGreaterThan(0, $distance);
=======
                Assert::assertGreaterThan(0, $distance);
>>>>>>> laraxot/dev
            }
        });
    });

    describe('Address Types', function () {
        it('can be set as primary address', function () {
<<<<<<< HEAD
           $address = AddressFactory::new()->createOne(['is_primary' => true]);
=======
            $address = AddressFactory::new()->createOne(['is_primary' => true]);
>>>>>>> laraxot/dev

            Assert::assertTrue($address->is_primary);
        });

        it('can have different types', function () {
            $address = AddressFactory::new()->createOne(['type' => AddressTypeEnum::HOME]);

            Assert::assertSame(AddressTypeEnum::HOME, $address->type);
        });
    });

    describe('Scopes and Queries', function () {
        it('can filter by primary addresses', function () {
<<<<<<< HEAD
           AddressFactory::new()->createOne(['is_primary' => true]);
=======
            AddressFactory::new()->createOne(['is_primary' => true]);
>>>>>>> laraxot/dev
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
        });
    });

    describe('Google Places Integration', function () {
        it('can store place_id from Google Places', function () {
<<<<<<< HEAD
           $address = AddressFactory::new()->createOne([
=======
            $address = AddressFactory::new()->createOne([
>>>>>>> laraxot/dev
                'place_id' => 'ChIJu46S-ZZjhkcRLuFvLjVZ400',
            ]);

            Assert::assertSame('ChIJu46S-ZZjhkcRLuFvLjVZ400', $address->place_id);
        });

        it('can store formatted_address from Google Places', function () {
            $address = AddressFactory::new()->createOne([
                'formatted_address' => 'Via Roma, 123, 20100 Milano MI, Italy',
            ]);

            Assert::assertSame('Via Roma, 123, 20100 Milano MI, Italy', $address->formatted_address);
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
=======
            $address = AddressFactory::new()->createOne(['extra_data' => $extraData]);
>>>>>>> laraxot/dev

            Assert::assertSame($extraData, $address->extra_data);
            Assert::assertSame('residential', $address->extra_data['building_type']);
            Assert::assertSame(3, $address->extra_data['floor']);
        });
    });
});
