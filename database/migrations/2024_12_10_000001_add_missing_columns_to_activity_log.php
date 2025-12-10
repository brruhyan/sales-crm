<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('activity_log', function (Blueprint $table) {
            // Check if columns don't exist before adding
            $columns = Schema::getColumns('activity_log');
            $columnNames = array_column($columns, 'name');

            if (!in_array('batch_uuid', $columnNames)) {
                $table->uuid('batch_uuid')->nullable();
            }

            if (!in_array('event', $columnNames)) {
                $table->string('event')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('activity_log', function (Blueprint $table) {
            if (Schema::hasColumn('activity_log', 'batch_uuid')) {
                $table->dropColumn('batch_uuid');
            }
            if (Schema::hasColumn('activity_log', 'event')) {
                $table->dropColumn('event');
            }
        });
    }
};
