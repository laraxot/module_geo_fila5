<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('indennita_responsabilita', function (Blueprint $table) {
            $table->json('calculated_data')->nullable()->after('updated_ip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('indennita_responsabilita', function (Blueprint $table) {
            $table->dropColumn('calculated_data');
        });
    }
};
