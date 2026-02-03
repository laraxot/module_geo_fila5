<?php

declare(strict_types=1);

namespace Modules\Ptv\Tests\Feature;

use Modules\Ptv\Database\Factories\CondizioniLavoroFactory;
use Modules\Ptv\Database\Factories\ValutatoreFactory;
use Modules\Ptv\Filament\Tables\Columns\ValutatoreColumn;
use Modules\Ptv\Models\CondizioniLavoro;
use Modules\Ptv\Tests\TestCase;

use function PHPUnit\Framework\assertTrue;

/**
 * @covers \Modules\Ptv\Filament\Tables\Columns\ValutatoreColumn
 */
class ValutatoreColumnTest extends TestCase
{
    public function test_valutatore_column_displays_nome_diri(): void
    {
        // Arrange: Create a valutatore with nome_diri
        $valutatore = ValutatoreFactory::new()->create([
            'nome_diri' => 'Mario Rossi',
        ]);

        // Create a condizioni lavoro linked to valutatore
        $condizioniLavoro = CondizioniLavoroFactory::new()->create([
            'valutatore_id' => $valutatore->id,
        ]);

        // Act: Create the column and get its state
        $column = ValutatoreColumn::make('valutatore');
        $fields = $column->getFields();

        // Assert: Check that the valutatore.nome_diri field is present
        assertTrue(count($fields) >= 1);
        
        // Test the relationship access works
        $nomeDiriField = $fields[0];
        assertTrue($nomeDiriField->getName() === 'valutatore.nome_diri');
    }

    public function test_valutatore_column_with_empty_relationship(): void
    {
        // Arrange: Create a condizioni lavoro without valutatore
        $condizioniLavoro = CondizioniLavoroFactory::new()->create([
            'valutatore_id' => null,
        ]);

        // Act & Assert: Should handle null relationship gracefully
        $column = ValutatoreColumn::make('valutatore');
        $fields = $column->getFields();
        
        // Should still have the fields configured
        assertTrue(count($fields) >= 1);
    }
}