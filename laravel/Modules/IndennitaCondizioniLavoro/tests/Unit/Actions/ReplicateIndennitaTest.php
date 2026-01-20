<?php

declare(strict_types=1);

use Filament\Notifications\Notification;
use Modules\IndennitaCondizioniLavoro\Actions\ReplicateIndennita;
use Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoro;

beforeEach(function () {
    // Set up test data if necessary
});

test('execute calculates previous quadrimestre and year correctly', function () {
    // Arrange
    $action = new ReplicateIndennita;

    // Test case 1: Same year, previous quadrimestre
    $data1 = [
        'anno/valutatore' => [
            'anno' => 2023,
            'quadrimestre' => 2,
            'valutatore_id' => 10,
        ],
    ];

    // Mock CondizioniLavoro::where->whereHas->get for first case
    $mockQuery1 = Mockery::mock('query');
    $mockQuery1->shouldReceive('whereHas')->with('indennitaTipoDettaglio')->andReturnSelf();
    $mockQuery1->shouldReceive('get')->andReturn(collect([]));

    CondizioniLavoro::shouldReceive('where')
        ->with(['anno' => 2023, 'quadrimestre' => 1])
        ->once()
        ->andReturn($mockQuery1);

    // Test case 2: Previous year, quadrimestre 3
    $data2 = [
        'anno/valutatore' => [
            'anno' => 2023,
            'quadrimestre' => 1,
            'valutatore_id' => 10,
        ],
    ];

    // Mock CondizioniLavoro::where->whereHas->get for second case
    $mockQuery2 = Mockery::mock('query');
    $mockQuery2->shouldReceive('whereHas')->with('indennitaTipoDettaglio')->andReturnSelf();
    $mockQuery2->shouldReceive('get')->andReturn(collect([]));

    CondizioniLavoro::shouldReceive('where')
        ->with(['anno' => 2022, 'quadrimestre' => 3])
        ->once()
        ->andReturn($mockQuery2);

    // Mock notification
    Notification::shouldReceive('make->title->success->send')->twice();

    // Act
    $action->execute($data1);
    $action->execute($data2);

    // Assert - verified through mock expectations
});

test('execute replicates indennita from previous to next quadrimestre', function () {
    // Arrange
    $action = new ReplicateIndennita;

    $data = [
        'anno/valutatore' => [
            'anno' => 2023,
            'quadrimestre' => 2,
            'valutatore_id' => 10,
        ],
    ];

    // Create mock objects for source and target CondizioniLavoro records
    $sourceRecord = Mockery::mock(CondizioniLavoro::class);
    $targetRecord = Mockery::mock(CondizioniLavoro::class);

    // Mock indennitaTipoDettaglio relationship for source
    $mockDetailIds = [101, 102, 103];
    $sourceRecord->shouldReceive('indennitaTipoDettaglio->modelKeys')
        ->andReturn($mockDetailIds);

    // Mock getNextQuadrimestre to return target record
    $sourceRecord->shouldReceive('getNextQuadrimestre')
        ->andReturn($targetRecord);

    // Mock empty collection for target's current indennitaTipoDettaglio
    $emptyCollection = Mockery::mock('collection');
    $emptyCollection->shouldReceive('count')->andReturn(0);
    $targetRecord->indennitaTipoDettaglio = $emptyCollection;

    // Mock the sync method for target's relationship
    $mockRelation = Mockery::mock('relation');
    $mockRelation->shouldReceive('sync')
        ->with($mockDetailIds)
        ->once();

    $targetRecord->shouldReceive('indennitaTipoDettaglio')
        ->andReturn($mockRelation);

    // Mock CondizioniLavoro query to return our source record
    $mockQuery = Mockery::mock('query');
    $mockQuery->shouldReceive('whereHas')->with('indennitaTipoDettaglio')->andReturnSelf();
    $mockQuery->shouldReceive('get')->andReturn(collect([$sourceRecord]));

    CondizioniLavoro::shouldReceive('where')
        ->with(['anno' => 2023, 'quadrimestre' => 1])
        ->once()
        ->andReturn($mockQuery);

    // Mock notification
    Notification::shouldReceive('make->title->success->send')->once();

    // Act
    $action->execute($data);

    // Assert - verified through mock expectations
});

test('execute skips records where next quadrimestre does not exist', function () {
    // Arrange
    $action = new ReplicateIndennita;

    $data = [
        'anno/valutatore' => [
            'anno' => 2023,
            'quadrimestre' => 3,
            'valutatore_id' => 10,
        ],
    ];

    // Create mock source record
    $sourceRecord = Mockery::mock(CondizioniLavoro::class);
    $sourceRecord->shouldReceive('indennitaTipoDettaglio->modelKeys')
        ->andReturn([101, 102]);

    // Mock getNextQuadrimestre to return null (no next record)
    $sourceRecord->shouldReceive('getNextQuadrimestre')
        ->andReturn(null);

    // We should NOT see any sync calls
    $sourceRecord->shouldNotReceive('indennitaTipoDettaglio');

    // Mock CondizioniLavoro query
    $mockQuery = Mockery::mock('query');
    $mockQuery->shouldReceive('whereHas')->with('indennitaTipoDettaglio')->andReturnSelf();
    $mockQuery->shouldReceive('get')->andReturn(collect([$sourceRecord]));

    CondizioniLavoro::shouldReceive('where')
        ->with(['anno' => 2023, 'quadrimestre' => 2])
        ->once()
        ->andReturn($mockQuery);

    // Mock notification
    Notification::shouldReceive('make->title->success->send')->once();

    // Act
    $action->execute($data);

    // Assert - verified through mock expectations
});

test('execute skips sync when next quadrimestre already has indennita', function () {
    // Arrange
    $action = new ReplicateIndennita;

    $data = [
        'anno/valutatore' => [
            'anno' => 2023,
            'quadrimestre' => 2,
            'valutatore_id' => 10,
        ],
    ];

    // Create mock objects
    $sourceRecord = Mockery::mock(CondizioniLavoro::class);
    $targetRecord = Mockery::mock(CondizioniLavoro::class);

    // Mock indennitaTipoDettaglio relationship for source
    $sourceRecord->shouldReceive('indennitaTipoDettaglio->modelKeys')
        ->andReturn([101, 102]);

    // Mock getNextQuadrimestre to return target
    $sourceRecord->shouldReceive('getNextQuadrimestre')
        ->andReturn($targetRecord);

    // Mock collection with items for target's indennitaTipoDettaglio
    $nonEmptyCollection = Mockery::mock('collection');
    $nonEmptyCollection->shouldReceive('count')->andReturn(2);
    $targetRecord->indennitaTipoDettaglio = $nonEmptyCollection;

    // We should NOT see any sync calls
    $targetRecord->shouldNotReceive('indennitaTipoDettaglio');

    // Mock CondizioniLavoro query
    $mockQuery = Mockery::mock('query');
    $mockQuery->shouldReceive('whereHas')->with('indennitaTipoDettaglio')->andReturnSelf();
    $mockQuery->shouldReceive('get')->andReturn(collect([$sourceRecord]));

    CondizioniLavoro::shouldReceive('where')
        ->with(['anno' => 2023, 'quadrimestre' => 1])
        ->once()
        ->andReturn($mockQuery);

    // Mock notification
    Notification::shouldReceive('make->title->success->send')->once();

    // Act
    $action->execute($data);

    // Assert - verified through mock expectations
});

// Clean up after tests
afterEach(function () {
    if (class_exists('Mockery')) {
        Mockery::close();
    }
});
