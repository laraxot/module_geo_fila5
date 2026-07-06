<?php

declare(strict_types=1);

use Filament\Support\RawJs;
use Modules\Xot\Actions\Arr\DiffAssocRecursiveAction as ArrDiffAssocRecursiveAction;
use Modules\Xot\Actions\Arr\RangeIntersectAction as ArrRangeIntersectAction;
use Modules\Xot\Actions\Arr\SaveArrayAction as ArrSaveArrayAction;
use Modules\Xot\Actions\Arr\SaveJsonArrayAction as ArrSaveJsonArrayAction;
use Modules\Xot\Actions\Arr\SavePhpArrayAction as ArrSavePhpArrayAction;
use Modules\Xot\Actions\Array\ArrayToRawJsAction;
use Modules\Xot\Actions\Array\DiffAssocRecursiveAction as ArrayDiffAssocRecursiveAction;
use Modules\Xot\Actions\Array\RangeIntersectAction as ArrayRangeIntersectAction;
use Modules\Xot\Actions\Array\SaveJsonArrayAction as ArraySaveJsonArrayAction;
use Modules\Xot\Actions\Array\SavePhpArrayAction as ArraySavePhpArrayAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;
use function Safe\mkdir;

uses(TestCase::class);

it('normalizes nested numeric strings in diff fixType for Arr namespace', function (): void {
    $input = ['items' => [
        ['a' => '1', 'b' => 'x'],
        ['c' => '2.5'],
    ]];

    $normalized = ArrDiffAssocRecursiveAction::fixType($input);

    Assert::assertSame([
        ['a' => 1, 'b' => 'x'],
        ['c' => 2.5],
    ], $normalized['items']);
});

it('throws when fixType receives a non-array item for Arr namespace', function (): void {
    try {
        ArrDiffAssocRecursiveAction::fixType(['items' => ['a' => '1'], 'invalid' => 'string']);
        Assert::fail('Expected exception not thrown');
    } catch (Exception) {
        // Expected
    }
});

it('returns recursive diff in Arr namespace', function (): void {
    $action = new ArrDiffAssocRecursiveAction();
    $left = ['items' => [
        ['id' => '1', 'name' => 'a'],
        ['id' => '2', 'name' => 'b'],
    ]];
    $right = ['items' => [
        ['id' => 2, 'name' => 'b'],
    ]];

    Assert::assertSame([
        ['id' => 1, 'name' => 'a'],
    ], $action->execute($left, $right)['items']);
});

it('normalizes nested numeric strings in diff fixType for Array namespace', function (): void {
    $input = ['items' => [
        ['a' => '10', 'b' => 'x'],
    ]];

    $normalized = ArrayDiffAssocRecursiveAction::fixType($input);

    Assert::assertSame([
        ['a' => 10, 'b' => 'x'],
    ], $normalized['items']);
});

it('throws when fixType receives a non-array item for Array namespace', function (): void {
    try {
        ArrayDiffAssocRecursiveAction::fixType(['items' => 123]);
        Assert::fail('Expected exception not thrown');
    } catch (Exception) {
        // Expected
    }
});

it('returns recursive diff in Array namespace', function (): void {
    $action = new ArrayDiffAssocRecursiveAction();
    $left = ['items' => [
        ['id' => '1', 'name' => 'alpha'],
        ['id' => '2', 'name' => 'beta'],
    ]];
    $right = ['items' => [
        ['id' => 1, 'name' => 'alpha'],
    ]];

    Assert::assertSame([
        1 => ['id' => 2, 'name' => 'beta'],
    ], $action->execute($left, $right)['items']);
});

it('covers all branches of range intersect in Arr namespace', function (): void {
    $action = new ArrRangeIntersectAction();

    Assert::assertSame([2, 5], $action->execute(2, 5, 1, 7));
    Assert::assertSame([2, 5], $action->execute(1, 7, 2, 5));
    Assert::assertFalse($action->execute(1, 2, 3, 4));
    Assert::assertFalse($action->execute(10, 11, 1, 5));
    Assert::assertFalse($action->execute(7, 6, 5, 8));
    Assert::assertSame([4, 4], $action->execute(4, 10, 2, 4));
    Assert::assertFalse($action->execute(1, 5, 2, 7));
});

it('covers all branches of range intersect in Array namespace', function (): void {
    $action = new ArrayRangeIntersectAction();

    Assert::assertSame([2, 5], $action->execute(2, 5, 1, 7));
    Assert::assertSame([2, 5], $action->execute(1, 7, 2, 5));
    Assert::assertFalse($action->execute(1, 2, 3, 4));
    Assert::assertFalse($action->execute(10, 11, 1, 5));
    Assert::assertFalse($action->execute(7, 6, 5, 8));
    Assert::assertSame([4, 4], $action->execute(4, 10, 2, 4));
    Assert::assertFalse($action->execute(1, 5, 2, 7));
});

it('writes JSON and PHP arrays via Arr actions', function (): void {
    $tmpDir = sys_get_temp_dir().'/xot-arr-actions-'.uniqid('', true);
    mkdir($tmpDir, 0777, true);

    $jsonFile = $tmpDir.'/data.json';
    $phpFile = $tmpDir.'/data.php';

    $jsonAction = new ArrSaveJsonArrayAction();
    $phpAction = new ArrSavePhpArrayAction();

    Assert::assertTrue($phpAction->execute(['b' => 2], $phpFile));
    Assert::assertFileExists($phpFile);
    Assert::assertStringContainsString('return', file_get_contents($phpFile));
    Assert::assertTrue($jsonAction->execute(['a' => 1], $jsonFile));
    Assert::assertFileExists($jsonFile);
    Assert::assertStringContainsString('"a"', file_get_contents($jsonFile));
});

it('writes JSON and PHP arrays via Array actions', function (): void {
    $tmpDir = sys_get_temp_dir().'/xot-array-actions-'.uniqid('', true);
    mkdir($tmpDir, 0777, true);

    $jsonFile = $tmpDir.'/data.json';
    $phpFile = $tmpDir.'/data.php';

    $jsonAction = new ArraySaveJsonArrayAction();
    $phpAction = new ArraySavePhpArrayAction();

    Assert::assertTrue($phpAction->execute(['b' => 2], $phpFile));
    Assert::assertFileExists($phpFile);
    Assert::assertStringContainsString('return', file_get_contents($phpFile));
    Assert::assertTrue($jsonAction->execute(['a' => 1], $jsonFile));
    Assert::assertFileExists($jsonFile);
    Assert::assertStringContainsString('"a"', file_get_contents($jsonFile));
});

it('dispatches save strategy by format in SaveArrayAction', function (): void {
    $tmpDir = sys_get_temp_dir().'/xot-save-array-action-'.uniqid('', true);
    mkdir($tmpDir, 0777, true);

    $action = new ArrSaveArrayAction();
    $jsonFile = $tmpDir.'/one.json';
    $phpFile = $tmpDir.'/one.php';

    Assert::assertTrue($action->execute(['x' => 1], $jsonFile, 'json'));
    Assert::assertTrue($action->execute(['y' => 2], $phpFile, 'php'));
});

it('throws on unsupported save format in SaveArrayAction', function (): void {
    try {
        $action = new ArrSaveArrayAction();
        $action->execute(['x' => 1], '/tmp/unused', 'xml');
        Assert::fail('Expected exception not thrown');
    } catch (InvalidArgumentException) {
        // Expected
    }
});

it('converts mixed PHP arrays to RawJs correctly', function (): void {
    $action = new ArrayToRawJsAction();

    $raw = $action->execute([
        'validKey' => true,
        'string key' => "O'Reilly",
        'number' => 12.5,
        'none' => null,
        'nested' => [
            'inner' => 1,
            'formatter' => RawJs::make('value => value * 2'),
        ],
    ]);

    Assert::assertInstanceOf(RawJs::class, $raw);
    $js = $raw->toHtml();
    Assert::assertStringContainsString('validKey: true', $js);
    Assert::assertStringContainsString("'string key': 'O\\'Reilly'", $js);
    Assert::assertStringContainsString('number: 12.5', $js);
    Assert::assertStringContainsString('none: null', $js);
    Assert::assertStringContainsString('formatter: value => value * 2', $js);
});
