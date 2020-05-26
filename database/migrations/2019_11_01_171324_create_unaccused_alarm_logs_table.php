<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnaccusedAlarmLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unaccused_alarm_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sensor_alarm_log_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->dateTime('date');

            $table->foreign('sensor_alarm_log_id')->references('id')->on('sensor_alarm_logs');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unaccused_alarm_logs');
    }
}
