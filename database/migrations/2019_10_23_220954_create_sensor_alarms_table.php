<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSensorAlarmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensor_alarms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('sensor_id')->unsigned();
            $table->float('range_min',255,6)->nullable();
            $table->float('range_max',255,6)->nullable();
            $table->boolean('is_active');
            $table->boolean('send_email');
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('sensor_id')->references('id')->on('sensors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sensor_alarms');
    }
}
