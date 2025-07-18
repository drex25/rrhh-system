<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('interviews', function (Blueprint $table) {
            $table->dateTime('cancelled_at')->nullable()->after('completed_at');
        });
    }

    public function down()
    {
        Schema::table('interviews', function (Blueprint $table) {
            $table->dropColumn('cancelled_at');
        });
    }
}; 