<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('job_postings', function (Blueprint $table) {
            // Agregar columna faltante
            $table->integer('vacancies')->default(1)->after('closing_date');
        });
    }

    public function down()
    {
        Schema::table('job_postings', function (Blueprint $table) {
            // Eliminar columna agregada
            $table->dropColumn('vacancies');
        });
    }
}; 