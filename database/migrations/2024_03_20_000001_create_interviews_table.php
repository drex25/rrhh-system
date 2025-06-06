<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained()->onDelete('cascade');
            $table->foreignId('job_posting_id')->constrained()->onDelete('cascade');
            $table->foreignId('interviewer_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('type'); // phone, video, in_person
            $table->string('status')->default('scheduled'); // scheduled, completed, cancelled, rescheduled
            $table->dateTime('scheduled_at');
            $table->dateTime('completed_at')->nullable();
            $table->string('location')->nullable(); // Para entrevistas presenciales
            $table->string('meeting_link')->nullable(); // Para entrevistas virtuales
            $table->text('notes')->nullable();
            $table->text('feedback')->nullable();
            $table->integer('rating')->nullable(); // 1-5
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('interviews');
    }
}; 