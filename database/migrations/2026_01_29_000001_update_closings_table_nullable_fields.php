<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('closings', function (Blueprint $table) {
            // Make optional fields nullable
            $table->string('probability')->nullable()->change();
            $table->dateTime('expected_close_date')->nullable()->change();
            $table->dateTime('actual_close_date')->nullable()->change();
            $table->json('documents')->nullable()->change();
            $table->text('notes')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('closings', function (Blueprint $table) {
            // Revert changes
            $table->string('probability')->nullable(false)->change();
            $table->dateTime('expected_close_date')->nullable(false)->change();
            $table->dateTime('actual_close_date')->nullable(false)->change();
            $table->json('documents')->nullable(false)->change();
            $table->text('notes')->nullable(false)->change();
        });
    }
};
