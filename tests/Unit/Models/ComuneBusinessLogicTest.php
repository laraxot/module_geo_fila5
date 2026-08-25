<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models;

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
    });

    test('comune has sushi to json trait', function () {
        $traits = class_uses(Comune::class);

<<<<<<< HEAD
       Assert::assertArrayHasKey(SushiToJson::class, $traits);
=======
        Assert::assertArrayHasKey(SushiToJson::class, $traits);
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
        Assert::assertEquals($expectedFillable, $comune->getFillable());
>>>>>>> laraxot/dev
    });

    test('comune has schema definition for structured geographic data', function () {
        $comune = new Comune();
<<<<<<< HEAD
       $reflection = new \ReflectionClass($comune);
=======
        $reflection = new \ReflectionClass($comune);
>>>>>>> laraxot/dev
        $schemaProperty = $reflection->getProperty('schema');

        Assert::assertTrue($schemaProperty->isProtected());

        $schema = $schemaProperty->getValue($comune);
        Assert::assertIsArray($schema);
        /* @var array<string, mixed> $schema */
        Assert::assertSame('json', $schema['zona']);
        Assert::assertSame('json', $schema['provincia']);
        Assert::assertSame('json', $schema['regione']);
        Assert::assertSame('json', $schema['cap']);
    });

    test('comune has json directory property for data source', function () {
        $comune = new Comune();

<<<<<<< HEAD
       Assert::assertObjectHasProperty('jsonDirectory', $comune);
=======
        Assert::assertObjectHasProperty('jsonDirectory', $comune);
>>>>>>> laraxot/dev
    });

    test('comune has translatable array configured', function () {
        $comune = new Comune();

<<<<<<< HEAD
       Assert::assertIsArray($comune->translatable);
=======
        Assert::assertIsArray($comune->translatable);
>>>>>>> laraxot/dev
    });

    test('comune model can be instantiated without errors', function () {
        $comune = new Comune();

<<<<<<< HEAD
       Assert::assertInstanceOf(Comune::class, $comune);
=======
        Assert::assertInstanceOf(Comune::class, $comune);
>>>>>>> laraxot/dev
        Assert::assertInstanceOf(BaseModel::class, $comune);
    });
});
