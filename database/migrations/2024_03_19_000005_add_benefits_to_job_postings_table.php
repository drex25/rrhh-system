<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('job_postings', function (Blueprint $table) {
            $table->text('benefits')->nullable()->after('responsibilities');
        });
    }

    public function down()
    {
        Schema::table('job_postings', function (Blueprint $table) {
            $table->dropColumn('benefits');
        });
    }
}; 