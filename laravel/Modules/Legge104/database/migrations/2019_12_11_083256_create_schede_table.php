<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateSchedeTable.
 */
class CreateSchedeTable extends XotBaseMigration
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
                $table->integer('ente')->nullable();
                $table->integer('matr')->nullable();
                $table->string('cognome', 250)->nullable();
                $table->string('nome', 250)->nullable();
                $table->integer('propro')->nullable();
                $table->integer('posfun')->nullable();
                $table->integer('clafun')->nullable();
                $table->integer('stabi')->nullable();
                $table->string('stabi_txt', 250)->nullable();
                $table->integer('repar')->nullable();
                $table->string('repar_txt', 250)->nullable();
                $table->string('indir', 250)->nullable();
                $table->integer('giorni_in_sede')->nullable();
                $table->integer('n_giorni_in_sede')->nullable();
                $table->integer('giorni_fuori_sede')->nullable();
                $table->integer('n_giorni_fuori_sede')->nullable();
                $table->integer('rep003')->nullable();
                $table->string('familiari', 250)->nullable();
                $table->string('l104', 250)->nullable();
                $table->integer('disci1')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('schede');
    }
}
