<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Activity\Models\Activity::class;

    /**
     * Run the migrations.
     * 
     * Questa migration aggiunge le colonne mancanti batch_uuid ed event
     * alla tabella activity_log sul database REMOTO (10.100.200.53)
     */
    public function up(): void
    {
        $this->tableUpdate(function (Blueprint $table): void {
            // Add batch_uuid column if not exists
            if (! $this->hasColumn('batch_uuid')) {
                $table->uuid('batch_uuid')->nullable()->after('properties');
            }

            // Add event column if not exists
            if (! $this->hasColumn('event')) {
                $table->string('event')->nullable()->after('batch_uuid');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->tableUpdate(function (Blueprint $table): void {
            if ($this->hasColumn('batch_uuid')) {
                $table->dropColumn('batch_uuid');
            }

            if ($this->hasColumn('event')) {
                $table->dropColumn('event');
            }
        });
    }
};
