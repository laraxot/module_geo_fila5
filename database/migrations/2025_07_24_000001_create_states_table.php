<?php

declare(strict_types=1);
<<<<<<< .merge_file_96bwFN

=======
<<<<<<< .merge_file_wAY6KW

=======
>>>>>>> .merge_file_xBVtGM
>>>>>>> .merge_file_yLh4BD
use Illuminate\Database\Schema\Blueprint;
use Modules\Geo\Models\State;
use Modules\Xot\Database\Migrations\XotBaseMigration;

<<<<<<< .merge_file_96bwFN
return new class extends XotBaseMigration {
=======
<<<<<<< .merge_file_wAY6KW
return new class() extends XotBaseMigration
{
=======
return new class extends XotBaseMigration {
>>>>>>> .merge_file_xBVtGM
>>>>>>> .merge_file_yLh4BD
    protected ?string $model_class = State::class;

    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->string('state')->comment('Nome dello stato/regione');
            $table->string('state_code', 10)->nullable()->index()->comment('Codice dello stato/regione');
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            // Non duplicare timestamps - updateTimestamps() gestisce timestamps e soft deletes
            $this->updateTimestamps($table, true);
        });
    }
};
