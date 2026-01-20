<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Migrazione per la tabella appuntamento.
 */
return new class extends XotBaseMigration
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
                $table->dateTime('giorno')->nullable();
                $table->integer('id_tipo')->nullable();
                $table->text('note')->nullable();
                $table->string('handle', 200)->nullable();
                $table->integer('last_stato')->nullable();
                $table->dateTime('datemod')->nullable();
                $table->timestamps();
                $table->string('deleted_by', 50)->nullable();
                $table->softDeletes();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('appuntamento');
    }
};
