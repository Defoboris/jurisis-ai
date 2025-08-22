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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subscription_plan_id')->constrained()->cascadeOnDelete();

            $table->enum('status', ['active', 'past_due', 'canceled', 'expired'])->default('active');
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->timestamp('cencels_at')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('provider_ref')->nullable();

            $table->timestamps();
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
