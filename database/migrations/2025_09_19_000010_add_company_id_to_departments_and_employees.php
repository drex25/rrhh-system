<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Departments
        Schema::table('departments', function (Blueprint $table) {
            if (!Schema::hasColumn('departments', 'company_id')) {
                $table->foreignId('company_id')->after('id')->nullable()->constrained('companies')->cascadeOnDelete();
            }
            // Ajustar unique existente 'code' a compuesto
        });

        // Employees
        Schema::table('employees', function (Blueprint $table) {
            if (!Schema::hasColumn('employees', 'company_id')) {
                $table->foreignId('company_id')->after('id')->nullable()->constrained('companies')->cascadeOnDelete();
            }
        });

        // Ajuste de índices únicos: lo haremos en migración separada para ser más seguro
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            if (Schema::hasColumn('employees', 'company_id')) {
                $table->dropConstrainedForeignId('company_id');
            }
        });

        Schema::table('departments', function (Blueprint $table) {
            if (Schema::hasColumn('departments', 'company_id')) {
                $table->dropConstrainedForeignId('company_id');
            }
        });
    }
};
