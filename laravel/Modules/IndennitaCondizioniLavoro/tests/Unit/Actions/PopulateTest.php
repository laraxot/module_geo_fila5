<?php

declare(strict_types=1);

use Carbon\Carbon;
use Modules\IndennitaCondizioniLavoro\Actions\Populate;
use Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoro;
use Modules\Sigma\Models\Rep00f;

beforeEach(function () {
    // Set up test data if necessary
});

test('execute does nothing when anno is 0', function () {
    // Arrange
    $action = new Populate;
    $data = [
        'anno' => 0,
        'quadrimestre' => 1,
    ];

    // We don't expect any database interaction
    Rep00f::shouldNotReceive('ofRangeDate');
    CondizioniLavoro::shouldNotReceive('firstOrCreate');

    // Act
    $result = $action->execute($data);

    // Assert - no assertions needed as we're just verifying nothing happened
    expect(true)->toBeTrue();
});

test('execute does nothing when quadrimestre is 0', function () {
    // Arrange
    $action = new Populate;
    $data = [
        'anno' => 2023,
        'quadrimestre' => 0,
    ];

    // We don't expect any database interaction
    Rep00f::shouldNotReceive('ofRangeDate');
    CondizioniLavoro::shouldNotReceive('firstOrCreate');

    // Act
    $result = $action->execute($data);

    // Assert - no assertions needed as we're just verifying nothing happened
    expect(true)->toBeTrue();
});

test('execute calculates date range correctly for quadrimestre 1', function () {
    // Arrange
    $action = new Populate;
    $data = [
        'anno' => 2023,
        'quadrimestre' => 1,
    ];

    // Expected date range for quadrimestre 1 of 2023
    $expectedDal = Carbon::createFromDate(2023, 1, 1);
    $expectedAl = Carbon::createFromDate(2023, 4, 30)->subDay(); // April 29, 2023

    // Mock CondizioniLavoro::where->where->get
    $mockCollection = collect();
    $mockQuery = Mockery::mock('query');
    $mockQuery->shouldReceive('where')->with('anno', 2023)->andReturnSelf();
    $mockQuery->shouldReceive('get')->andReturn($mockCollection);

    CondizioniLavoro::shouldReceive('where')
        ->with('quadrimestre', 1)
        ->andReturn($mockQuery);

    // Mock Rep00f::ofRangeDate->where->get
    Rep00f::shouldReceive('ofRangeDate')
        ->with((int) $expectedDal->format('Ymd'), (int) $expectedAl->format('Ymd'))
        ->andReturnSelf();
    Rep00f::shouldReceive('where')
        ->with('ente', 90)
        ->andReturnSelf();
    Rep00f::shouldReceive('get')
        ->andReturn(collect([]));

    // Act
    $action->execute($data);

    // Assert - The assertions are mainly in the mocks' expectations
    // We're verifying the correct date range was used
});

test('execute creates new CondizioniLavoro records for new Rep00f entries', function () {
    // Arrange
    $action = new Populate;
    $data = [
        'anno' => 2023,
        'quadrimestre' => 2,
    ];

    // Mock existing CondizioniLavoro records
    $existingRecords = collect([
        (object) ['matr' => 1001],
        (object) ['matr' => 1002],
    ]);

    $mockQuery = Mockery::mock('query');
    $mockQuery->shouldReceive('where')->with('anno', 2023)->andReturnSelf();
    $mockQuery->shouldReceive('get')->andReturn($existingRecords);

    CondizioniLavoro::shouldReceive('where')
        ->with('quadrimestre', 2)
        ->andReturn($mockQuery);

    // Mock new Rep00f records that need to be created
    $newRep00fRecord = (object) [
        'ente' => 90,
        'matr' => 1003, // New matriculation not in existing records
        'repst1' => 5,
        'repre1' => 10,
    ];

    // Mock the date range query
    $dal = Carbon::createFromDate(2023, 5, 1);
    $al = Carbon::createFromDate(2023, 8, 31);

    Rep00f::shouldReceive('ofRangeDate')
        ->andReturnSelf();
    Rep00f::shouldReceive('where')
        ->with('ente', 90)
        ->andReturnSelf();
    Rep00f::shouldReceive('get')
        ->andReturn(collect([$newRep00fRecord]));

    // Expect the firstOrCreate call for the new record
    CondizioniLavoro::shouldReceive('firstOrCreate')
        ->with(
            [
                'ente' => 90,
                'matr' => 1003,
                'stabi' => 5,
                'repar' => 10,
                'quadrimestre' => 2,
                'anno' => 2023,
            ],
            [
                'dal' => Mockery::type(Carbon::class),
                'al' => Mockery::type(Carbon::class),
            ]
        )
        ->once();

    // Act
    $action->execute($data);

    // Assert via mock expectations
});

// Clean up after tests
afterEach(function () {
    if (class_exists('Mockery')) {
        Mockery::close();
    }
});
