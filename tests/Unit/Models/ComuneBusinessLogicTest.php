<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Geo\Models\BaseModel;
use Modules\Geo\Models\Comune;
use Modules\Tenant\Models\Traits\SushiToJson;
use PHPUnit\Framework\Assert;

/**
 * Behaviour under test: contratto di dominio del modello Geo\Comune
 * (fillable comuni IT, schema JSON via getSchema(), trait SushiToJson/HasFactory).
 * Existing: questo file (Unit/Models); nessun altro test dedicato schema Comune.
 * User instruction: "esegui cd laravel && ./vendor/bin/phpstan analyse Modules e sistema tutte le segnalazioni..."
 * Assertion PHPUnit: evita crash pest-plugin-phpstan HigherOrderExpectationTypeExtension.
 */
describe('Comune Business Logic', function () {
    test('comune extends base model', function () {
        Assert::assertSame(BaseModel::class, get_parent_class(Comune::class));
    });

    test('comune has factory trait for testing', function () {
        Assert::assertContains(HasFactory::class, class_uses_recursive(Comune::class));
    });

    test('comune has sushi to json trait', function () {
        Assert::assertContains(SushiToJson::class, class_uses_recursive(Comune::class));
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

        Assert::assertSame($expectedFillable, $comune->getFillable());
    });

    test('comune has schema definition for structured geographic data', function () {
<<<<<<< .merge_file_fuiqrI
        $schema = (new Comune)->getSchema();
=======
        $comune = new Comune();
>>>>>>> .merge_file_fmLNvW

        Assert::assertSame('json', $schema['zona'] ?? null);
        Assert::assertSame('json', $schema['provincia'] ?? null);
        Assert::assertSame('json', $schema['regione'] ?? null);
        Assert::assertSame('json', $schema['cap'] ?? null);
    });

    test('comune has json directory property for data source', function () {
<<<<<<< .merge_file_fuiqrI
        Assert::assertSame('', (new Comune)->jsonDirectory);
    });

    test('comune has translatable array configured', function () {
        Assert::assertSame([], (new Comune)->translatable);
=======
        $comune = new Comune();

        expect($comune)->toHaveProperty('jsonDirectory');
        expect($comune->jsonDirectory)->toBeString();
    });

    test('comune has translatable array configured', function () {
        $comune = new Comune();

        expect($comune->translatable)->toBeArray();
>>>>>>> .merge_file_fmLNvW
    });

    test('comune model can be instantiated without errors', function () {
        $comune = new Comune();

        Assert::assertInstanceOf(Comune::class, $comune);
        Assert::assertInstanceOf(BaseModel::class, $comune);
    });
});
