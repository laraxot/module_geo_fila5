<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateMensileTable.
 */
class CreateMensileTable extends XotBaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->increments('id');
                $table->string('clafun', 250)->nullable();
                $table->string('smesli', 250)->nullable();
                $table->string('sannli', 250)->nullable();
                $table->string('cod', 250)->nullable();
                $table->string('cassa', 250)->nullable();
                $table->string('impoeu', 250)->nullable();
                $table->string('contributo', 250)->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('mensile');
    }
}
