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
        Schema::create('lawyers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('specialty')->nullable();
            $table->string('bar_id')->nullable();
            $table->string('firm_name')->nullable();
            $table->string('office_address')->nullable();

            // page to fields
            $table->string('slug')->unique();
            $table->string('headline')->nullable();
            $table->text('bio')->nullable();
            $table->string('vidio_url')->nullable();
            $table->boolean('is_published')->default(false);
            $table->enum('moderation_state', ['pending','approved','rejected'])->default('pending');
            $table->text('moderation_notes')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lawyers');
    }
};
