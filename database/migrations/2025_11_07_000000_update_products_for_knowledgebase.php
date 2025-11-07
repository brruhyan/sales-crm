<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('company_name')->nullable()->after('product_name');
            $table->longText('features')->nullable()->after('description');
            $table->longText('benefits')->nullable()->after('features');
            $table->longText('use_cases')->nullable()->after('benefits');
            $table->string('link')->nullable()->after('use_cases');
            $table->foreignId('user_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['company_name', 'features', 'benefits', 'use_cases']);
            $table->string('link')->nullable(false)->change();
            $table->foreignId('user_id')->nullable(false)->change();
        });
    }
};
