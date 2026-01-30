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
        if (!Schema::hasTable('closings')) {
            Schema::create('closings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('deal_id')->constrained('deals')->cascadeOnDelete();
                $table->foreignId('contact_id')->nullable()->constrained('contacts')->nullOnDelete();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->string('title')->index();
                $table->text('description')->nullable();
                $table->string('status')->default('Open')->index();
                $table->date('expected_close_date')->nullable();
                $table->date('actual_close_date')->nullable();
                $table->decimal('amount', 15, 2)->nullable();
                $table->string('currency')->default('USD');
                $table->integer('probability')->default(0);
                $table->json('documents')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
                $table->index(['user_id', 'status']);
                $table->index(['deal_id', 'user_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('closings');
    }
};
