<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Storage;
use Modules\IndennitaCondizioniLavoro\Actions\MakePdf;
use Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoro;
use Modules\IndennitaCondizioniLavoro\Models\StabiDirigente;
use Spipu\Html2Pdf\Html2Pdf;

beforeEach(function () {
    // Set up test data if necessary
});

test('execute fetches the correct records based on anno and valutatore', function () {
    // Arrange
    $action = Mockery::mock(MakePdf::class)->makePartial();

    $data = [
        'anno/valutatore' => [
            'anno' => 2023,
            'quadrimestre' => 2,
            'valutatore_id' => 10,
        ],
    ];

    // Mock records query
    $mockCollection = collect(['record1', 'record2']);
    $mockQuery = Mockery::mock('query');
    $mockQuery->shouldReceive('whereHas')->with('indennitaTipoDettaglio')->andReturnSelf();
    $mockQuery->shouldReceive('get')->andReturn($mockCollection);

    CondizioniLavoro::shouldReceive('where')
        ->with($data['anno/valutatore'])
        ->once()
        ->andReturn($mockQuery);

    // Mock StabiDirigente query
    $mockValutatore = new StabiDirigente;
    $mockValutatore->nome_diri = 'Test Director Name';

    $mockValutatoreQuery = Mockery::mock('query');
    $mockValutatoreQuery->shouldReceive('whereRaw')
        ->with('id=valutatore_id')
        ->andReturnSelf();
    $mockValutatoreQuery->shouldReceive('where')
        ->with('anno', 2023)
        ->andReturnSelf();
    $mockValutatoreQuery->shouldReceive('first')
        ->andReturn($mockValutatore);

    StabiDirigente::shouldReceive('where')
        ->with('valutatore_id', 10)
        ->andReturn($mockValutatoreQuery);

    // Mock view rendering
    $mockView = Mockery::mock('view');
    $mockView->shouldReceive('render')->andReturn('<html>PDF content</html>');

    // Mock view facade
    $viewParams = [
        'rows' => $mockCollection,
        'firma' => 'Test Director Name',
    ];

    $action->shouldReceive('view')
        ->with('indennitacondizionilavoro::actions.make-pdf', $viewParams)
        ->andReturn($mockView);

    // Mock Html2Pdf
    $mockHtml2Pdf = Mockery::mock('html2pdf');
    $mockHtml2Pdf->shouldReceive('writeHTML')->with('<html>PDF content</html>')->once();
    $mockHtml2Pdf->shouldReceive('output')->twice()->andReturn(true);

    $action->shouldReceive('new')->with(Html2Pdf::class, ['L', 'A4', 'it'])
        ->andReturn($mockHtml2Pdf);

    // Mock storage path
    $mockPath = '/tmp/cache/my_doc.pdf';
    Storage::shouldReceive('disk->path')
        ->with('my_doc.pdf')
        ->andReturn($mockPath);

    // Mock response
    $action->shouldReceive('response->download')
        ->with($mockPath, 'my_doc.pdf', ['Content-Type' => 'application/pdf'])
        ->once();

    // Act
    $action->execute($data);

    // Assert - verified through mock expectations
});

test('execute handles missing valutatore gracefully', function () {
    // Arrange
    $action = Mockery::mock(MakePdf::class)->makePartial();

    $data = [
        'anno/valutatore' => [
            'anno' => 2023,
            'quadrimestre' => 2,
            'valutatore_id' => 10,
        ],
    ];

    // Mock records query
    $mockCollection = collect(['record1', 'record2']);
    $mockQuery = Mockery::mock('query');
    $mockQuery->shouldReceive('whereHas')->with('indennitaTipoDettaglio')->andReturnSelf();
    $mockQuery->shouldReceive('get')->andReturn($mockCollection);

    CondizioniLavoro::shouldReceive('where')
        ->with($data['anno/valutatore'])
        ->once()
        ->andReturn($mockQuery);

    // Mock StabiDirigente query with null result
    $mockValutatoreQuery = Mockery::mock('query');
    $mockValutatoreQuery->shouldReceive('whereRaw')
        ->with('id=valutatore_id')
        ->andReturnSelf();
    $mockValutatoreQuery->shouldReceive('where')
        ->with('anno', 2023)
        ->andReturnSelf();
    $mockValutatoreQuery->shouldReceive('first')
        ->andReturn(null); // No valutatore found

    StabiDirigente::shouldReceive('where')
        ->with('valutatore_id', 10)
        ->andReturn($mockValutatoreQuery);

    // Mock view rendering
    $mockView = Mockery::mock('view');
    $mockView->shouldReceive('render')->andReturn('<html>PDF content</html>');

    // Expect view with null firma
    $viewParams = [
        'rows' => $mockCollection,
        'firma' => null,
    ];

    $action->shouldReceive('view')
        ->with('indennitacondizionilavoro::actions.make-pdf', $viewParams)
        ->andReturn($mockView);

    // Mock Html2Pdf
    $mockHtml2Pdf = Mockery::mock('html2pdf');
    $mockHtml2Pdf->shouldReceive('writeHTML')->with('<html>PDF content</html>')->once();
    $mockHtml2Pdf->shouldReceive('output')->twice()->andReturn(true);

    $action->shouldReceive('new')->with(Html2Pdf::class, ['L', 'A4', 'it'])
        ->andReturn($mockHtml2Pdf);

    // Mock storage path
    $mockPath = '/tmp/cache/my_doc.pdf';
    Storage::shouldReceive('disk->path')
        ->with('my_doc.pdf')
        ->andReturn($mockPath);

    // Mock response
    $action->shouldReceive('response->download')
        ->with($mockPath, 'my_doc.pdf', ['Content-Type' => 'application/pdf'])
        ->once();

    // Act
    $action->execute($data);

    // Assert - verified through mock expectations
});

test('execute generates proper pdf content and returns download response', function () {
    // This is more of an integration test that would require actual PDF generation
    // For unit testing, we'll mock most of the behavior

    $this->markTestIncomplete(
        'This test requires integration testing with actual PDF generation.'
    );
});

// Clean up after tests
afterEach(function () {
    if (class_exists('Mockery')) {
        Mockery::close();
    }
});
