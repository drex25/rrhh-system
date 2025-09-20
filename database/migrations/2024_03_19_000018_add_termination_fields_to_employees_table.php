<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Evitar error de rename/permiso en ciertos motores MySQL: no usar after() y verificar existencia
            if (!Schema::hasColumn('employees', 'termination_date')) {
                $table->date('termination_date')->nullable();
            }
            if (!Schema::hasColumn('employees', 'termination_reason')) {
                $table->string('termination_reason')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Dropear solo si existen para evitar fallos en entornos inconsistentes
            if (Schema::hasColumn('employees', 'termination_reason')) {
                $table->dropColumn('termination_reason');
            }
            if (Schema::hasColumn('employees', 'termination_date')) {
                $table->dropColumn('termination_date');
            }
        });
    }
};