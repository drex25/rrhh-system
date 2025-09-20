<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            if (!Schema::hasColumn('companies', 'industry')) {
                $table->string('industry', 120)->nullable()->after('plan');
            }
            if (!Schema::hasColumn('companies', 'size')) {
                $table->string('size', 40)->nullable()->after('industry');
            }
            if (!Schema::hasColumn('companies', 'timezone')) {
                $table->string('timezone', 60)->nullable()->after('size');
            }
            if (!Schema::hasColumn('companies', 'currency')) {
                $table->char('currency', 3)->nullable()->after('timezone');
            }
            if (!Schema::hasColumn('companies', 'address')) {
                $table->string('address')->nullable()->after('currency');
            }
            if (!Schema::hasColumn('companies', 'phone')) {
                $table->string('phone', 40)->nullable()->after('address');
            }
            if (!Schema::hasColumn('companies', 'website')) {
                $table->string('website')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('companies', 'tax_id')) {
                $table->string('tax_id', 40)->nullable()->after('website');
            }
            if (!Schema::hasColumn('companies', 'business_type')) {
                $table->string('business_type', 80)->nullable()->after('tax_id');
            }
            if (!Schema::hasColumn('companies', 'settings')) {
                $table->json('settings')->nullable()->after('business_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            foreach (['industry','size','timezone','currency','address','phone','website','tax_id','business_type','settings'] as $col) {
                if (Schema::hasColumn('companies', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
