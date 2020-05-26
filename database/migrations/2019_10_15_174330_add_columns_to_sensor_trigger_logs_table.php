<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToSensorTriggerLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sensor_trigger_logs', function (Blueprint $table) {
            $table->float('value_readed',255,4)->nullable();
            $table->integer('command_executed')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sensor_trigger_logs', function (Blueprint $table) {
            $table->dropColumn('value_readed');
            $table->dropColumn('command_executed');
        });
    }
}
