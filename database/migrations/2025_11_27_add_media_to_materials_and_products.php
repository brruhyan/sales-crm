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
        Schema::table('materials', function (Blueprint $table) {
            $table->string('media')->nullable()->after('learn_more');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('media')->nullable()->after('link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn('media');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('media');
        });
    }
};
