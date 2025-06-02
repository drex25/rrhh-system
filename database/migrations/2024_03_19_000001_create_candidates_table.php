<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_posting_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->enum('status', ['pending', 'reviewing', 'interviewed', 'offered', 'hired', 'rejected'])->default('pending');
            $table->string('current_position')->nullable();
            $table->string('current_company')->nullable();
            $table->integer('years_of_experience')->nullable();
            $table->string('education_level')->nullable();
            $table->decimal('expected_salary', 10, 2)->nullable();
            $table->string('resume_path')->nullable();
            $table->text('cover_letter')->nullable();
            $table->text('notes')->nullable();
            $table->string('source')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('candidates');
    }
}; 