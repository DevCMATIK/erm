<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSensorAlarmLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensor_alarm_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sensor_alarm_id')->unsigned();
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->dateTime('last_update')->nullable();
            $table->float('first_value_readed',255,6);
            $table->float('last_value_readed',255,6);
            $table->integer('min_or_max');
            $table->integer('entries_counted');
            $table->boolean('accused');
            $table->integer('accused_by')->unsigned()->nullable();
            $table->foreign('sensor_alarm_id')->references('id')->on('sensor_alarms');
            $table->foreign('accused_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sensor_alarm_logs');
    }
}
