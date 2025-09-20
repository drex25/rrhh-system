<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            // Evitar duplicados si migraciones anteriores ya agregaron campos similares
            if (!Schema::hasColumn('companies', 'logo')) {
                $table->string('logo')->nullable()->after('slug');
            }
            if (!Schema::hasColumn('companies', 'timezone')) {
                $table->string('timezone')->default('America/Argentina/Buenos_Aires')->after('logo');
            }
            if (!Schema::hasColumn('companies', 'currency')) {
                $table->string('currency')->default('ARS')->after('timezone');
            }
            if (!Schema::hasColumn('companies', 'address')) {
                $table->text('address')->nullable()->after('currency');
            }
            if (!Schema::hasColumn('companies', 'phone')) {
                $table->string('phone')->nullable()->after('address');
            }
            if (!Schema::hasColumn('companies', 'website')) {
                $table->string('website')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('companies', 'tax_id')) {
                $table->string('tax_id')->nullable()->after('website');
            }
            if (!Schema::hasColumn('companies', 'business_type')) {
                $table->string('business_type')->nullable()->after('tax_id');
            }
            if (!Schema::hasColumn('companies', 'settings')) {
                $table->json('settings')->nullable()->after('business_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn([
                'logo',
                'timezone', 
                'currency',
                'address',
                'phone',
                'website',
                'tax_id',
                'business_type',
                'settings'
            ]);
        });
    }
};
