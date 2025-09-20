<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('positions', function (Blueprint $table) {
            // Primero soltamos la FK existente para volver a crearla con cascade
            $table->dropForeign(['department_id']);
            $table->foreign('department_id')
                ->references('id')->on('departments')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('positions', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->foreign('department_id')
                ->references('id')->on('departments'); // comport. por defecto (restrict)
        });
    }
};
