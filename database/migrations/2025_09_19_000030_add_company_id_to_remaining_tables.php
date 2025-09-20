<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'positions',
            'payslips',
            'leave_types',
            'leave_requests',
            'employee_leave_balances',
            'overtimes',
            'performances',
            'trainings',
            'documents',
            'interviews',
            'job_postings',
            'candidates',
            'leads',
            'academic_histories',
            'attendances',
        ];

        Schema::disableForeignKeyConstraints();
        foreach ($tables as $tableName) {
            try {
                if (Schema::hasTable($tableName) && !Schema::hasColumn($tableName, 'company_id')) {
                    Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                        $table->unsignedBigInteger('company_id')->nullable()->after('id');
                    });
                    try {
                        Schema::table($tableName, function (Blueprint $table) {
                            $table->foreign('company_id')->references('id')->on('companies')->cascadeOnDelete();
                        });
                    } catch(\Throwable $e) {
                        // Silenciar si falló la creación de la FK (tabla temporal / motor)
                    }
                }
            } catch(\Throwable $e) {
                // Silenciar error por tabla no consistente en motor
            }
        }
        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        $tables = [
            'positions',
            'payslips',
            'leave_types',
            'leave_requests',
            'employee_leave_balances',
            'overtimes',
            'performances',
            'trainings',
            'documents',
            'interviews',
            'job_postings',
            'candidates',
            'leads',
            'academic_histories',
            'attendances',
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'company_id')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropConstrainedForeignId('company_id');
                });
            }
        }
    }
};
