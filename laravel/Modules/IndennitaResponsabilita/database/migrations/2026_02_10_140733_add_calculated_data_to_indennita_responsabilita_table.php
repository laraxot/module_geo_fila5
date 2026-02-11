<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema; // Added
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Migration for adding extra_attributes to indennita_responsabilita table.
 * Uses Schemaless Attributes pattern for dynamic data storage.
 *
 * @see https://github.com/spatie/laravel-schemaless-attributes
 * @see /Modules/IndennitaResponsabilita/docs/schemaless-attributes.md
 */
class AddExtraAttributesToIndennitaResponsabilitaTable extends XotBaseMigration // Changed to named class
{
    /** @var string|null Model class targeted by this migration */
    protected ?string $model_class = IndennitaResponsabilita::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if (! $this->hasColumn('extra_attributes')) {
                    // ✅ CORRETTO: Usa schemalessAttributes invece di json()
                    // Questo permette di usare il pattern Schemaless Attributes di Spatie
                    // @phpstan-ignore-next-line method.notFound
                    $table->schemalessAttributes('extra_attributes');
                }
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('indennita_responsabilita', function (Blueprint $table): void {
            if (Schema::hasColumn('indennita_responsabilita', 'extra_attributes')) { // Use Schema::hasColumn for safety
                $table->dropColumn('extra_attributes');
            }
        });
    }
};
