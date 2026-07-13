<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Geo\Database\Factories\AddressFactory;
use Modules\Geo\Enums\AddressTypeEnum;
use Modules\Geo\Models\Address;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('address can be created', function (): void {
    $address = AddressFactory::new()->createOne();

    Assert::assertInstanceOf(Address::class, $address);
});

test('address has fillable attributes', function (): void {
    $address = new Address();
    $fillable = $address->getFillable();

    Assert::assertContains('route', $fillable);
    Assert::assertContains('street_number', $fillable);
    Assert::assertContains('postal_code', $fillable);
    Assert::assertContains('locality', $fillable);
});

test('address has casts defined', function (): void {
    $address = new Address();
    $casts = $address->getCasts();

    Assert::assertArrayHasKey('latitude', $casts);
    Assert::assertArrayHasKey('longitude', $casts);
    Assert::assertArrayHasKey('is_primary', $casts);
    Assert::assertSame(AddressTypeEnum::class, $casts['type']);
});

test('address has proper table name', function (): void {
    $address = new Address();

    Assert::assertSame('addresses', $address->getTable());
});

test('address morphs to parent model', function (): void {
    $address = new Address();

    Assert::assertInstanceOf(MorphTo::class, $address->model());
    Assert::assertInstanceOf(MorphTo::class, $address->addressable());
});

test('address can build full address string', function (): void {
    $address = AddressFactory::new()->createOne([
        'route' => 'Via Roma',
        'street_number' => '123',
        'postal_code' => '00100',
        'locality' => 'Roma',
    ]);

    $fullAddress = $address->getFullAddressAttribute();

    Assert::assertStringContainsString('Via Roma', $fullAddress);
    Assert::assertStringContainsString('00100', $fullAddress);
    Assert::assertStringContainsString('Roma', $fullAddress);
});

test('address can be queried by locality', function (): void {
    $address = AddressFactory::new()->createOne(['locality' => 'Milano-Test-Unique']);

    $results = Address::query()->where('locality', 'Milano-Test-Unique')->get();

    Assert::assertCount(1, $results);
    Assert::assertSame($address->id, $results->first()?->id);
});

test('address can be filtered by postal code', function (): void {
    $address = AddressFactory::new()->createOne(['postal_code' => '99999-Test']);

    $results = Address::query()->where('postal_code', '99999-Test')->get();

    Assert::assertCount(1, $results);
    Assert::assertSame($address->id, $results->first()?->id);
});

test('address exposes latitude and longitude getters', function (): void {
    $address = AddressFactory::new()->createOne([
        'latitude' => 41.9028,
        'longitude' => 12.4964,
    ]);

    Assert::assertSame(41.9028, $address->getLatitude());
    Assert::assertSame(12.4964, $address->getLongitude());
});

test('address primary scope filters primary records', function (): void {
    AddressFactory::new()->createOne(['is_primary' => false]);
    $primary = AddressFactory::new()->createOne(['is_primary' => true]);

    $results = Address::query()->primary()->get();

    Assert::assertTrue($results->contains('id', $primary->id));
=======
uses(\Modules\Geo\Tests\TestCase::class);
// Laraxot — see module docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Geo\Models\Address;
use Modules\Geo\Models\Comune;
use Modules\Geo\Models\Province;

beforeEach(function () {
    $this->address = Address::factory()->create();
});

test('address can be created', function () {
    expect($this->address)->toBeInstanceOf(Address::class);
});

test('address has fillable attributes', function () {
    $fillable = $this->address->getFillable();

    expect($fillable)->toContain('street');
    expect($fillable)->toContain('number');
    expect($fillable)->toContain('postal_code');
    expect($fillable)->toContain('city');
});

test('address has casts defined', function () {
    $casts = $this->address->getCasts();

    expect($casts)->toHaveKey('created_at');
    expect($casts)->toHaveKey('updated_at');
    expect($casts)->toHaveKey('coordinates');
});

test('address has proper table name', function () {
    expect($this->address->getTable())->toBe('addresses');
});

test('address belongs to comune', function () {
    $comune = Comune::factory()->create();
    $this->address->update(['comune_id' => $comune->id]);

    expect($this->address->fresh()->comune)->toBeInstanceOf(Comune::class);
    expect($this->address->fresh()->comune->id)->toBe($comune->id);
});

test('address belongs to province', function () {
    $province = Province::factory()->create();
    $this->address->update(['province_id' => $province->id]);

    expect($this->address->fresh()->province)->toBeInstanceOf(Province::class);
    expect($this->address->fresh()->province->id)->toBe($province->id);
});

test('address can get full address', function () {
    $this->address->update([
        'street' => 'Via Roma',
        'number' => '123',
        'postal_code' => '00100',
        'city' => 'Roma',
    ]);

    $fullAddress = $this->address->getFullAddressAttribute();

    expect($fullAddress)->toBe('Via Roma, 123 - 00100 Roma');
});

test('address can be searched by street', function () {
    $searchResult = Address::search('test')->get();

    expect($searchResult)->toHaveCount(1);
    expect($searchResult->first()->id)->toBe($this->address->id);
});

test('address can be filtered by city', function () {
    $cityAddresses = Address::byCity('test')->get();

    expect($cityAddresses)->toHaveCount(1);
    expect($cityAddresses->first()->id)->toBe($this->address->id);
});

test('address can be filtered by postal code', function () {
    $postalCodeAddresses = Address::byPostalCode('test')->get();

    expect($postalCodeAddresses)->toHaveCount(1);
    expect($postalCodeAddresses->first()->id)->toBe($this->address->id);
});

test('address has proper relationships', function () {
    expect($this->address->comune())->toBeInstanceOf(BelongsTo::class);
    expect($this->address->province())->toBeInstanceOf(BelongsTo::class);
});

test('address can validate coordinates', function () {
    $this->address->update(['coordinates' => ['lat' => 41.9028, 'lng' => 12.4964]]);

    expect($this->address->fresh()->hasValidCoordinates())->toBeTrue();

    $this->address->update(['coordinates' => null]);

    expect($this->address->fresh()->hasValidCoordinates())->toBeFalse();
>>>>>>> laraxot/dev
});
