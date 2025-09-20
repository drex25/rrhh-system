<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('job_posting_user') && !Schema::hasColumn('job_posting_user','company_id')) {
            Schema::table('job_posting_user', function (Blueprint $table) {
                $table->foreignId('company_id')->nullable()->after('user_id')->constrained('companies')->cascadeOnDelete();
                $table->index(['company_id','job_posting_id']);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('job_posting_user') && Schema::hasColumn('job_posting_user','company_id')) {
            Schema::table('job_posting_user', function (Blueprint $table) {
                $table->dropIndex(['company_id','job_posting_id']);
                $table->dropConstrainedForeignId('company_id');
            });
        }
    }
};
