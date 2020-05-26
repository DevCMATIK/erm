<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToSensorTriggersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE `sensor_triggers` MODIFY `when_one` INTEGER NULL;');
        Schema::table('sensor_triggers', function (Blueprint $table) {
            $table->float('range_min',255,6)->nullable();
            $table->float('range_max',255,6)->nullable();
            $table->integer('in_range')->nullable();
            $table->dateTime('last_execution')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE `sensor_triggers` MODIFY `when_one` INTEGER NOT NULL;');
        Schema::table('sensor_triggers', function (Blueprint $table) {
            $table->dropColumn('range_min');
            $table->dropColumn('range_max');
            $table->dropColumn('in_range');
            $table->dropColumn('last_execution');
        });
    }
}
