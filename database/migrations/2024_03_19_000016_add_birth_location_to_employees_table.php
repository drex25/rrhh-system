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
        Schema::table('employees', function (Blueprint $table) {
            if (!Schema::hasColumn('employees', 'birth_country')) {
                $table->string('birth_country')->nullable();
            }
            if (!Schema::hasColumn('employees', 'birth_province')) {
                $table->string('birth_province')->nullable();
            }
            if (!Schema::hasColumn('employees', 'birth_city')) {
                $table->string('birth_city')->nullable();
            }
            if (!Schema::hasColumn('employees', 'nationality')) {
                $table->string('nationality')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            foreach (['nationality','birth_city','birth_province','birth_country'] as $col) {
                if (Schema::hasColumn('employees', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
}; 