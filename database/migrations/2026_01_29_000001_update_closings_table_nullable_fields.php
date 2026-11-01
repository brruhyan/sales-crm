<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::connection()->getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE "closings" ALTER COLUMN "probability" DROP NOT NULL');
            DB::statement('ALTER TABLE "closings" ALTER COLUMN "probability" TYPE varchar(255) USING "probability"::varchar');
            DB::statement('ALTER TABLE "closings" ALTER COLUMN "expected_close_date" DROP NOT NULL');
            DB::statement('ALTER TABLE "closings" ALTER COLUMN "expected_close_date" TYPE timestamp(0) without time zone USING "expected_close_date"::timestamp');
            DB::statement('ALTER TABLE "closings" ALTER COLUMN "actual_close_date" DROP NOT NULL');
            DB::statement('ALTER TABLE "closings" ALTER COLUMN "actual_close_date" TYPE timestamp(0) without time zone USING "actual_close_date"::timestamp');
            DB::statement('ALTER TABLE "closings" ALTER COLUMN "documents" DROP NOT NULL');
            DB::statement('ALTER TABLE "closings" ALTER COLUMN "notes" DROP NOT NULL');

            return;
        }

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
        if (DB::connection()->getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE "closings" ALTER COLUMN "probability" SET NOT NULL');
            DB::statement('ALTER TABLE "closings" ALTER COLUMN "expected_close_date" TYPE date USING "expected_close_date"::date');
            DB::statement('ALTER TABLE "closings" ALTER COLUMN "expected_close_date" SET NOT NULL');
            DB::statement('ALTER TABLE "closings" ALTER COLUMN "actual_close_date" TYPE date USING "actual_close_date"::date');
            DB::statement('ALTER TABLE "closings" ALTER COLUMN "actual_close_date" SET NOT NULL');
            DB::statement('ALTER TABLE "closings" ALTER COLUMN "documents" SET NOT NULL');
            DB::statement('ALTER TABLE "closings" ALTER COLUMN "notes" SET NOT NULL');

            return;
        }

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
