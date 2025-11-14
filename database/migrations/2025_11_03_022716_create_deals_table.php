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
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->nullable()->constrained('leads')->onDelete('set null');
            $table->string('title'); 
            $table->text('description')->nullable();
            $table->decimal('amount', 15, 2)->default(0); 
            $table->string('currency')->default('USD'); 
            $table->integer('probability')->default(0); 
            $table->string('status')->default('Prospecting'); 
            $table->json('documents')->nullable();
            $table->string('source')->nullable(); 
            $table->json('won_documents')->nullable();
            $table->date('expected_close_date')->nullable(); 
            $table->date('actual_close_date')->nullable(); 
            $table->text('dispute_reason')->nullable();
            
            $table->foreignId('contact_id')->nullable()->constrained('contacts')->onDelete('set null'); 
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            
            
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('deals');
        Schema::enableForeignKeyConstraints();
    }
};
