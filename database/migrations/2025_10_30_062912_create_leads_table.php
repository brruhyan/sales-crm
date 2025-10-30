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
            $table->timestamps();
            $table->string('name'); // Full name of the person or company contact
            $table->string('email')->unique(); // Contact email address
            $table->string('phone'); // Contact phone number
            $table->string('company')->nullable(); // Organization they represent (if applicable)
            $table->string('source')->nullable(); // How the lead found you
            $table->string('status')->default('New'); // Stage of the lead
            $table->softDeletes();
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
