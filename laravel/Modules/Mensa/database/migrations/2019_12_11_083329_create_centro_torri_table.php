<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateCentroTorriTable.
 */
class CreateCentroTorriTable extends XotBaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->integer('id', true);
                $table->text('matricola')->nullable();
                $table->string('cognome', 100)->nullable();
                $table->text('nome')->nullable();
                $table->text('numero_di_badge')->nullable();
                $table->text('badge_intero')->nullable();
                $table->text('field')->nullable();
                $table->text('field1')->nullable();
                $table->text('field11')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('centro_torri');
    }
}
