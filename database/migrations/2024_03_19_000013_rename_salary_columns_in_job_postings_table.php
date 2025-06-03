<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('job_postings', function (Blueprint $table) {
            $table->renameColumn('salary_min', 'min_salary');
            $table->renameColumn('salary_max', 'max_salary');
        });
    }

    public function down()
    {
        Schema::table('job_postings', function (Blueprint $table) {
            $table->renameColumn('min_salary', 'salary_min');
            $table->renameColumn('max_salary', 'salary_max');
        });
    }
}; 