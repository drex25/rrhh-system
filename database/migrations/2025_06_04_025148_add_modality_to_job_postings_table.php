<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('job_postings', function (Blueprint $table) {
            $table->string('modality', 20)->default('presencial')->after('work_schedule');
        });
        
        // Agregar constraint después para simular enum
        DB::statement("ALTER TABLE job_postings ADD CONSTRAINT job_postings_modality_check CHECK (modality IN ('remoto', 'hibrido', 'presencial'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_postings', function (Blueprint $table) {
            $table->dropColumn('modality');
        });
    }
};
