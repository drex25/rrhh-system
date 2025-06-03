<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_leave_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('leave_type_id')->constrained()->onDelete('cascade');
            $table->integer('total_days')->default(0); // Días totales asignados
            $table->integer('used_days')->default(0); // Días utilizados
            $table->integer('remaining_days')->default(0); // Días restantes
            $table->year('year'); // Año al que corresponde el saldo
            $table->timestamps();

            // Asegurar que un empleado solo tenga un registro por tipo de licencia por año
            $table->unique(['employee_id', 'leave_type_id', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_leave_balances');
    }
}; 