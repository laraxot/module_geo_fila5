<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateDichiarazioneTable.
 */
class CreateDichiarazioneTable extends XotBaseMigration
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
                $table->string('cognome_nome', 250)->nullable();
                $table->string('codice_fiscale', 50)->nullable();
                $table->string('data_nascita', 50)->nullable();
                $table->string('comune', 50)->nullable();
                $table->string('provincia', 50)->nullable();
                $table->string('stato_civ', 50)->nullable();
                $table->string('num_figli', 50)->nullable();
                $table->string('num_figli_under3years', 50)->nullable();
                $table->string('lista_date_nascita', 50)->nullable();
                $table->string('num_fam_a_carico', 50)->nullable();
                $table->string('titolare_fam_monoreddito', 50)->nullable();
                $table->string('l21_104', 50)->nullable();
                $table->string('l33_104', 50)->nullable();
                $table->string('titolo_studio', 50)->nullable();
                $table->string('titolo_studio_spec', 50)->nullable();
                $table->string('datainizio', 50)->nullable();
                $table->string('settoreservizio', 50)->nullable();
                $table->text('note')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('dichiarazione');
    }
}
