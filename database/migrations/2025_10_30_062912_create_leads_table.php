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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('lead_title');
            $table->string('lead_type')->nullable();
            $table->string('product');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('contact_id')->nullable()->constrained('contacts')->onDelete('set null');
            $table->timestamps();
            $table->string('name'); 
            $table->string('email');
            $table->string('phone'); 
            $table->string('company')->nullable();
            $table->string('source')->nullable(); 
            $table->string('status')->default('New'); 
            $table->softDeletes();
            $table->json('documents')->nullable(); 
            $table->json('qualified_documents')->nullable();
            $table->text('dispute_reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
