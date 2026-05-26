<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit;

use Modules\UI\Filament\Forms\Components\EnumSelect;
use PHPUnit\Framework\TestCase;

/*
 * @uses TestCase
 */
it('generates options from enum class', function () {
    $select = EnumSelect::make('enum');
    $select->enum(TestColorEnum::class);

    $options = $select->getOptions();

    expect($options)->toBeArray()
        ->toHaveCount(3)
        ->toHaveKeys(['red', 'green', 'blue']);
});

it('uses HasLabel interface when available', function () {
    $select = EnumSelect::make('enum');
    $select->enum(TestColorEnum::class);

    $options = $select->getOptions();

    expect($options['red'])->toContain('Rosso');
    expect($options['green'])->toContain('Verde');
});

it('falls back to case name when HasLabel not implemented', function () {
    $select = EnumSelect::make('enum');
    $select->enum(TestNoLabelEnum::class);

    $options = $select->getOptions();

    expect($options['alpha'])->toBe('ALPHA');
    expect($options['beta'])->toBe('BETA');
});

it('rejects plain (non-backed) enums when resolving options', function () {
    $select = EnumSelect::make('enum')->enum(TestPureUnitEnum::class);

    expect(fn () => $select->getOptions())
        ->toThrow(\InvalidArgumentException::class, 'must be a backed enum');
});

it('rejects classes that are not enums when resolving options', function () {
    $select = EnumSelect::make('enum')->enum(\stdClass::class);

    expect(fn () => $select->getOptions())
        ->toThrow(\InvalidArgumentException::class, 'does not exist');
});

it('converts value to enum case', function () {
    $select = EnumSelect::make('enum');
    $select->enum(TestColorEnum::class);

    $result = $select->convertToEnum('red');
    expect($result)->toBe(TestColorEnum::RED);

    $result = $select->convertToEnum('invalid');
    expect($result)->toBeNull();

    $result = $select->convertToEnum(null);
    expect($result)->toBeNull();
});

it('enables icons when requested', function () {
    $select = EnumSelect::make('enum');
    $select->enum(TestColorEnum::class);
    $select->icons();

    expect($select->hasIcons())->toBeTrue();
});

it('enables html labels when requested', function () {
    $select = EnumSelect::make('enum');
    $select->enum(TestColorEnum::class);
    $select->htmlLabels();

    expect($select->allowsHtml())->toBeTrue();
});

it('returns correct enum class', function () {
    $select = EnumSelect::make('enum');
    $select->enum(TestColorEnum::class);

    expect($select->getEnumClass())->toBe(TestColorEnum::class);
});

it('formats html labels with icons', function () {
    $select = EnumSelect::make('enum');
    $select->enum(TestColorEnum::class);
    $select->icons();
    $select->htmlLabels();

    $options = $select->getOptions();

    expect($options['red'])->toContain('heroicon-o-exclamation');
    expect($options['red'])->toContain('Rosso');
});
