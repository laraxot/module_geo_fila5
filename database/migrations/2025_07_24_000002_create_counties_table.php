<?php

declare(strict_types=1);
<<<<<<< .merge_file_nFbjXg

=======
<<<<<<< .merge_file_QaNRG2

=======
>>>>>>> .merge_file_P6AuCF
>>>>>>> .merge_file_z25mP4
use Illuminate\Database\Schema\Blueprint;
use Modules\Geo\Models\County;
use Modules\Xot\Database\Migrations\XotBaseMigration;

<<<<<<< .merge_file_nFbjXg
return new class extends XotBaseMigration {
=======
<<<<<<< .merge_file_QaNRG2
return new class() extends XotBaseMigration
{
=======
return new class extends XotBaseMigration {
>>>>>>> .merge_file_P6AuCF
>>>>>>> .merge_file_z25mP4
    protected ?string $model_class = County::class;

    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('state_id')->nullable()->index()->comment('Stato/regione di appartenenza');
            $table->string('county')->comment('Nome della suddivisione (county/provincia)');
            $table->string('county_code', 10)->nullable()->index()->comment('Codice della suddivisione');
            $table->unsignedInteger('state_index')->nullable()->comment('Indice progressivo entro lo stato');
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            // Non duplicare timestamps - updateTimestamps() gestisce timestamps e soft deletes
            $this->updateTimestamps($table, true);
        });
    }
};
