<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // IMPORTANTE: Este paso asume que ya se pobló company_id en registros existentes antes de hacer los nuevos índices.

        // Departments: reemplazar unique(code) por composite (company_id, code)
        Schema::table('departments', function (Blueprint $table) {
            // Drop del índice único existente (nombre usual: departments_code_unique)
            try { DB::statement('ALTER TABLE departments DROP INDEX departments_code_unique'); } catch (\Throwable $e) {}
            $table->unique(['company_id', 'code']);
        });

        // Employees: varios uniques -> convertir a compuestos
        Schema::table('employees', function (Blueprint $table) {
            foreach (['file_number','dni','cuit','email'] as $col) {
                $indexName = 'employees_' . $col . '_unique';
                try { DB::statement("ALTER TABLE employees DROP INDEX {$indexName}"); } catch (\Throwable $e) {}
                $table->unique(['company_id', $col]);
            }
        });
    }

    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropUnique(['company_id', 'code']);
            $table->unique('code');
        });
        Schema::table('employees', function (Blueprint $table) {
            foreach (['file_number','dni','cuit','email'] as $col) {
                $table->dropUnique(['company_id', $col]);
                $table->unique($col);
            }
        });
    }
};
