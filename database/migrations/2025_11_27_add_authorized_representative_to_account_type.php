<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::connection()->getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE "users" DROP CONSTRAINT IF EXISTS "users_account_type_check"');
            DB::statement('ALTER TABLE "users" ALTER COLUMN "account_type" TYPE varchar(255) USING "account_type"::varchar');
            DB::statement('ALTER TABLE "users" ALTER COLUMN "account_type" SET DEFAULT \'individual\'');
            DB::statement('ALTER TABLE "users" ADD CONSTRAINT "users_account_type_check" CHECK ("account_type" IN (\'individual\', \'authorized_representative\', \'company\'))');

            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->enum('account_type', ['individual', 'authorized_representative', 'company'])->default('individual')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::connection()->getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE "users" DROP CONSTRAINT IF EXISTS "users_account_type_check"');
            DB::statement('ALTER TABLE "users" ADD CONSTRAINT "users_account_type_check" CHECK ("account_type" IN (\'individual\', \'company\'))');

            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->enum('account_type', ['individual', 'company'])->default('individual')->change();
        });
    }
};
