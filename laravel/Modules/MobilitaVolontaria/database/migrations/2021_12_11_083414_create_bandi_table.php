<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateBandiTable.
 */
class CreateBandiTable extends XotBaseMigration
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
                $table->string('comune', 50)->nullable();
                $table->string('cat_giu', 50)->nullable();
                $table->string('profilo_professionale', 250)->nullable();
                $table->string('titolo_richiesto', 250)->nullable();
                $table->string('area_impiego', 250)->nullable();
                $table->dateTime('scadenza')->nullable();
                $table->integer('n_interessati')->nullable();
                $table->string('handle', 50)->nullable();
                $table->dateTime('datemod')->nullable();
                $table->integer('last_stato')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('bandi');
    }
}
