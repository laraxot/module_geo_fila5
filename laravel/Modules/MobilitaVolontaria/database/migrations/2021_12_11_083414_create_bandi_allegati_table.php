<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateBandiAllegatiTable.
 */
class CreateBandiAllegatiTable extends XotBaseMigration
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
                $table->integer('id_bandi')->nullable();
                $table->string('nome', 250)->nullable();
                $table->string('filename', 250)->nullable();
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
        Schema::drop('bandi_allegati');
    }
}
