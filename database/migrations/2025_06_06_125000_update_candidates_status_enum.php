<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Primero eliminamos el valor por defecto
        DB::statement('ALTER TABLE candidates ALTER COLUMN status DROP DEFAULT');
        
        // Modificamos el tipo ENUM
        DB::statement("ALTER TABLE candidates MODIFY COLUMN status ENUM('pending', 'reviewing', 'shortlisted', 'interview_scheduled', 'interviewed', 'technical_test', 'reference_check', 'offered', 'accepted', 'hired', 'rejected', 'withdrawn') NOT NULL DEFAULT 'pending'");
    }

    public function down()
    {
        // Revertimos a los valores originales
        DB::statement('ALTER TABLE candidates ALTER COLUMN status DROP DEFAULT');
        DB::statement("ALTER TABLE candidates MODIFY COLUMN status ENUM('pending', 'reviewing', 'interviewed', 'hired', 'rejected') NOT NULL DEFAULT 'pending'");
    }
}; 