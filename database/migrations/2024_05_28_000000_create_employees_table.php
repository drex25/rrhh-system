<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('file_number')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('dni')->unique();
            $table->string('cuit')->unique();
            $table->date('birth_date');
            $table->string('gender')->nullable(); // masculino, femenino, sin género
            $table->string('address');
            $table->string('phone');
            $table->string('email')->unique();
            $table->foreignId('department_id')->constrained();
            $table->foreignId('position_id')->constrained();
            $table->date('hire_date');
            $table->string('employment_type'); // full-time, part-time, contract
            $table->string('work_schedule_from');
            $table->string('work_schedule_to');
            $table->string('social_security_number')->nullable();
            $table->string('health_insurance')->nullable();
            $table->string('union')->nullable();
            $table->decimal('base_salary', 10, 2);
            $table->string('bank_account')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->string('profile_photo')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('mother_name')->nullable();
            $table->string('father_name')->nullable();
            $table->string('spouse_name')->nullable();
            $table->string('children')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
