<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('link')->nullable();
        });

        if (DB::connection()->getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE "products" ALTER COLUMN "user_id" DROP NOT NULL');
        } else {
            Schema::table('products', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        if (DB::connection()->getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE "products" ALTER COLUMN "link" SET NOT NULL');
            DB::statement('ALTER TABLE "products" ALTER COLUMN "user_id" SET NOT NULL');
        } else {
            Schema::table('products', function (Blueprint $table) {
                $table->string('link')->nullable(false)->change();
                $table->foreignId('user_id')->nullable(false)->change();
            });
        }
    }
};
