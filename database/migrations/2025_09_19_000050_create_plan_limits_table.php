<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plan_limits', function (Blueprint $table) {
            $table->id();
            $table->string('plan'); // nombre del plan
            $table->string('key');  // employees, departments, storage_mb, etc.
            $table->unsignedBigInteger('limit')->nullable(); // null = ilimitado
            $table->string('period')->nullable(); // monthly, yearly, null
            $table->timestamps();
            $table->unique(['plan','key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_limits');
    }
};
