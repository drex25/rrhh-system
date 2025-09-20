<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('employees', function (Blueprint $table) {
            if (!Schema::hasColumn('employees', 'cbu_attachment')) {
                $table->string('cbu_attachment')->nullable();
            }
        });
    }
    public function down(): void {
        Schema::table('employees', function (Blueprint $table) {
            if (Schema::hasColumn('employees', 'cbu_attachment')) {
                $table->dropColumn('cbu_attachment');
            }
        });
    }
};