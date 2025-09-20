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
        Schema::table('positions', function (Blueprint $table) {
            // Eliminar la restricción unique actual en code
            $table->dropUnique(['code']);
            
            // Crear una restricción unique compuesta: code debe ser único por empresa
            $table->unique(['company_id', 'code'], 'positions_company_code_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('positions', function (Blueprint $table) {
            // Eliminar la restricción unique compuesta
            $table->dropUnique('positions_company_code_unique');
            
            // Restaurar la restricción unique original (aunque problemática)
            $table->unique('code');
        });
    }
};
