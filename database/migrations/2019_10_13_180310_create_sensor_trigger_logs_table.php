<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSensorTriggerLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensor_trigger_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sensor_trigger_id')->unsigned();
            $table->dateTime('last_execution');

            $table->foreign('sensor_trigger_id')->references('id')->on('sensor_triggers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sensor_trigger_logs');
    }
}
