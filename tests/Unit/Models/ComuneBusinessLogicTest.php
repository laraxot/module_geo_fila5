<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models;

<<<<<<< HEAD
use Modules\Geo\Database\Factories\ComuneFactory;
use Modules\Geo\Models\BaseModel;
use Modules\Geo\Models\Comune;
use Modules\Tenant\Models\Traits\SushiToJson;
use PHPUnit\Framework\Assert;

use function Safe\class_uses;

uses(\Modules\Geo\Tests\TestCase::class);
describe('Comune Business Logic', function () {
    test('comune extends base model', function () {
        Assert::assertInstanceOf(BaseModel::class, new Comune());
    });

    test('comune can be created via factory', function () {
        $comune = ComuneFactory::new()->createOne();

        Assert::assertInstanceOf(Comune::class, $comune);
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Geo\Models\BaseModel;
use Modules\Geo\Models\Comune;
use Modules\Tenant\Models\Traits\SushiToJson;

describe('Comune Business Logic', function () {
    test('comune extends base model', function () {
        expect(Comune::class)->toBeSubclassOf(BaseModel::class);
    });

    test('comune has factory trait for testing', function () {
        $traits = class_uses(Comune::class);

        expect($traits)->toHaveKey(HasFactory::class);
>>>>>>> laraxot/dev
    });

    test('comune has sushi to json trait', function () {
        $traits = class_uses(Comune::class);

<<<<<<< HEAD
        Assert::assertArrayHasKey(SushiToJson::class, $traits);
=======
        expect($traits)->toHaveKey(SushiToJson::class);
>>>>>>> laraxot/dev
    });

    test('comune has expected fillable fields for italian municipalities', function () {
        $comune = new Comune();
        $expectedFillable = [
            'id',
            'codice',
            'nome',
            'regione',
            'provincia',
            'sigla_provincia',
            'cap',
            'codice_catastale',
            'popolazione',
            'zona_altimetrica',
            'altitudine',
            'superficie',
            'lat',
            'lng',
        ];

<<<<<<< HEAD
        Assert::assertEquals($expectedFillable, $comune->getFillable());
=======
        expect($comune->getFillable())->toEqual($expectedFillable);
>>>>>>> laraxot/dev
    });

    test('comune has schema definition for structured geographic data', function () {
        $comune = new Comune();
<<<<<<< HEAD
        $reflection = new \ReflectionClass($comune);
        $schemaProperty = $reflection->getProperty('schema');

        Assert::assertTrue($schemaProperty->isProtected());

        $schema = $schemaProperty->getValue($comune);
        Assert::assertIsArray($schema);
        /* @var array<string, mixed> $schema */
        Assert::assertSame('json', $schema['zona']);
        Assert::assertSame('json', $schema['provincia']);
        Assert::assertSame('json', $schema['regione']);
        Assert::assertSame('json', $schema['cap']);
=======

        expect($comune)->toHaveProperty('schema');
        expect($comune->schema['zona'])->toBe('json');
        expect($comune->schema['provincia'])->toBe('json');
        expect($comune->schema['regione'])->toBe('json');
        expect($comune->schema['cap'])->toBe('json');
>>>>>>> laraxot/dev
    });

    test('comune has json directory property for data source', function () {
        $comune = new Comune();

<<<<<<< HEAD
        Assert::assertObjectHasProperty('jsonDirectory', $comune);
=======
        expect($comune)->toHaveProperty('jsonDirectory');
        expect($comune->jsonDirectory)->toBeString();
>>>>>>> laraxot/dev
    });

    test('comune has translatable array configured', function () {
        $comune = new Comune();

<<<<<<< HEAD
        Assert::assertIsArray($comune->translatable);
=======
        expect($comune->translatable)->toBeArray();
>>>>>>> laraxot/dev
    });

    test('comune model can be instantiated without errors', function () {
        $comune = new Comune();

<<<<<<< HEAD
        Assert::assertInstanceOf(Comune::class, $comune);
        Assert::assertInstanceOf(BaseModel::class, $comune);
=======
        expect($comune)->toBeInstanceOf(Comune::class);
        expect($comune)->toBeInstanceOf(BaseModel::class);
>>>>>>> laraxot/dev
    });
});
