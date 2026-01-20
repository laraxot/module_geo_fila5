<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateBandiUtentiTable.
 */
class CreateBandiUtentiTable extends XotBaseMigration
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
                $table->integer('ente')->nullable();
                $table->integer('matr')->nullable();
                $table->string('nome', 100)->nullable();
                $table->text('note')->nullable();
                $table->string('valore', 50)->nullable();
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
        Schema::drop('bandi_utenti');
    }
}
