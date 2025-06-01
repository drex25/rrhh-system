<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->date('termination_date')->nullable()->after('is_active');
            $table->string('termination_reason')->nullable()->after('termination_date');
        });
    }
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['termination_date', 'termination_reason']);
        });
    }
}; 