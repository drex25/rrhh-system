<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('subscriptions', function(Blueprint $table){
            if(!Schema::hasColumn('subscriptions','billing_interval')){
                $table->string('billing_interval',20)->default('monthly')->after('plan_code');
                $table->timestamp('renews_at')->nullable()->change(); // already exists in create, ensure position ok
            }
        });
    }
    public function down(): void
    {
        Schema::table('subscriptions', function(Blueprint $table){
            if(Schema::hasColumn('subscriptions','billing_interval')){
                $table->dropColumn('billing_interval');
            }
        });
    }
};
