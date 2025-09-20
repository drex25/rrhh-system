<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('plan_code'); // references plans.code (no FK to allow soft evolution)
            $table->string('provider')->default('internal'); // stripe, internal
            $table->string('provider_subscription_id')->nullable();
            $table->string('status')->default('active'); // active, past_due, canceled, trialing, incomplete
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamp('renews_at')->nullable();
            $table->integer('quantity')->default(1);
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->index(['company_id','status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
