<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Builder;
use Modules\Geo\Enums\AddressTypeEnum;
use Modules\Geo\Models\Address;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
describe('Address Business Logic', function () {
    test('address extends base model', function () {
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

use Illuminate\Database\Eloquent\Builder;
use Modules\Geo\Enums\AddressTypeEnum;
use Modules\Geo\Models\Address;
use Modules\Geo\Models\BaseModel;

describe('Address Business Logic', function () {
    test('address extends base model', function () {
        expect(Address::class)->toBeSubclassOf(BaseModel::class);
>>>>>>> laraxot/dev
    });

    test('address has expected fillable fields for postal address', function () {
        $address = new Address();
        $expectedFillable = [
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
        ];

<<<<<<< HEAD
        Assert::assertEquals($expectedFillable, $address->getFillable());
=======
        expect($address->getFillable())->toEqual($expectedFillable);
>>>>>>> laraxot/dev
    });

    test('address has correct casts for geolocation and structured data', function () {
        $address = new Address();
        $casts = $address->getCasts();

<<<<<<< HEAD
        Assert::assertSame('float', $casts['latitude']);
        Assert::assertSame('float', $casts['longitude']);
        Assert::assertSame('boolean', $casts['is_primary']);
        Assert::assertSame('array', $casts['extra_data']);
        Assert::assertSame(AddressTypeEnum::class, $casts['type']);
=======
        expect($casts['latitude'])->toBe('float');
        expect($casts['longitude'])->toBe('float');
        expect($casts['is_primary'])->toBe('boolean');
        expect($casts['extra_data'])->toBe('array');
        expect($casts['type'])->toBe(AddressTypeEnum::class);
>>>>>>> laraxot/dev
    });

    test('address has polymorphic model relationship', function () {
        $address = new Address();
<<<<<<< HEAD
=======

        expect(method_exists($address, 'model'))->toBeTrue();
        expect(method_exists($address, 'addressable'))->toBeTrue();
>>>>>>> laraxot/dev
    });

    test('address can get region data from comune', function () {
        $address = new Address();
<<<<<<< HEAD
=======

        expect(method_exists($address, 'getRegione'))->toBeTrue();
>>>>>>> laraxot/dev
    });

    test('address can get province data from comune', function () {
        $address = new Address();
<<<<<<< HEAD
=======

        expect(method_exists($address, 'getProvincia'))->toBeTrue();
>>>>>>> laraxot/dev
    });

    test('address can get locality data from comune', function () {
        $address = new Address();
<<<<<<< HEAD
=======

        expect(method_exists($address, 'getLocality'))->toBeTrue();
>>>>>>> laraxot/dev
    });

    test('address can format full address attribute', function () {
        $address = new Address();
        $address->route = 'Via Roma';
        $address->street_number = '123';
        $address->locality = 'Milano';

<<<<<<< HEAD
        Assert::assertStringContainsString('Via Roma 123', $address->full_address);
        Assert::assertStringContainsString('Milano', $address->full_address);
=======
        expect($address->full_address)->toContain('Via Roma 123');
        expect($address->full_address)->toContain('Milano');
>>>>>>> laraxot/dev
    });

    test('address can format street address attribute', function () {
        $address = new Address();
        $address->route = 'Via Roma';
        $address->street_number = '123';

<<<<<<< HEAD
        Assert::assertSame('Via Roma 123', $address->street_address);
=======
        expect($address->street_address)->toBe('Via Roma 123');
>>>>>>> laraxot/dev
    });

    test('address can get geolocation coordinates', function () {
        $address = new Address();
        $address->latitude = 45.4642;
        $address->longitude = 9.1900;

<<<<<<< HEAD
        Assert::assertSame(45.4642, $address->getLatitude());
        Assert::assertSame(9.1900, $address->getLongitude());
=======
        expect($address->getLatitude())->toBe(45.4642);
        expect($address->getLongitude())->toBe(9.1900);
>>>>>>> laraxot/dev
    });

    test('address can export to schema org format', function () {
        $address = new Address();
        $address->name = 'Test Address';
        $address->route = 'Via Roma';
        $address->street_number = '123';

        $schemaOrg = $address->toSchemaOrg();

<<<<<<< HEAD
        Assert::assertArrayHasKey('@context', $schemaOrg);
        Assert::assertArrayHasKey('@type', $schemaOrg);
        Assert::assertSame('https://schema.org', $schemaOrg['@context']);
        Assert::assertSame('PostalAddress', $schemaOrg['@type']);
=======
        expect($schemaOrg)->toHaveKey('@context');
        expect($schemaOrg)->toHaveKey('@type');
        expect($schemaOrg['@context'])->toBe('https://schema.org');
        expect($schemaOrg['@type'])->toBe('PostalAddress');
>>>>>>> laraxot/dev
    });

    test('address scope can query nearby addresses', function () {
        $query = Address::nearby(45.4642, 9.1900, 10);

<<<<<<< HEAD
        Assert::assertInstanceOf(Builder::class, $query);
=======
        expect($query)->toBeInstanceOf(Builder::class);
>>>>>>> laraxot/dev
    });

    test('address scope can query primary addresses', function () {
        $query = Address::primary();

<<<<<<< HEAD
        Assert::assertInstanceOf(Builder::class, $query);
=======
        expect($query)->toBeInstanceOf(Builder::class);
>>>>>>> laraxot/dev
    });

    test('address scope can query by type', function () {
        $query = Address::ofType(AddressTypeEnum::BILLING);

<<<<<<< HEAD
        Assert::assertInstanceOf(Builder::class, $query);
=======
        expect($query)->toBeInstanceOf(Builder::class);
>>>>>>> laraxot/dev
    });
});
