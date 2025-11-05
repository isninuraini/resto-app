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
        if (!Schema::hasColumn('mejas', 'status')) {
            Schema::table('mejas', function (Blueprint $table) {
                $table->enum('status', ['tersedia', 'tidak_tersedia'])->default('tersedia')->after('kapasitas');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mejas', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
