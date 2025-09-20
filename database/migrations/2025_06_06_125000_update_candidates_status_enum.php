<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        $driver = DB::getDriverName();
        if ($driver === 'mysql') {
            // Ajuste MySQL real
            DB::statement("ALTER TABLE candidates MODIFY COLUMN status ENUM('pending', 'reviewing', 'shortlisted', 'interview_scheduled', 'interviewed', 'technical_test', 'reference_check', 'offered', 'accepted', 'hired', 'rejected', 'withdrawn') NOT NULL DEFAULT 'pending'");
        } else {
            // SQLite / otros: simplemente asegurar que la columna existe; no soporta ENUM real.
            // Podemos dejarla como TEXT y validar por aplicación; si ya existe, ignoramos.
            if (Schema::hasTable('candidates') && Schema::hasColumn('candidates', 'status')) {
                // Nada: evitar fallar.
            }
        }
    }

    public function down()
    {
        $driver = DB::getDriverName();
        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE candidates MODIFY COLUMN status ENUM('pending', 'reviewing', 'interviewed', 'hired', 'rejected') NOT NULL DEFAULT 'pending'");
        }
    }
};