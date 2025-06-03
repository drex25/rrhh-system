<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('job_postings', function (Blueprint $table) {
            if (!Schema::hasColumn('job_postings', 'department_id')) {
                $table->foreignId('department_id')->after('closing_date')->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('job_postings', 'position_id')) {
                $table->foreignId('position_id')->after('department_id')->constrained()->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('job_postings', function (Blueprint $table) {
            if (Schema::hasColumn('job_postings', 'department_id')) {
                $table->dropForeign(['department_id']);
                $table->dropColumn('department_id');
            }
            if (Schema::hasColumn('job_postings', 'position_id')) {
                $table->dropForeign(['position_id']);
                $table->dropColumn('position_id');
            }
        });
    }
}; 