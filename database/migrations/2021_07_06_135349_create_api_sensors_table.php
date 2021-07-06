<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiSensorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_sensors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('api_key_id')->unsigned();
            $table->integer('sensor_id')->unsigned();

            $table->foreign('api_key_id')->references('id')->on('api_keys');
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
        Schema::dropIfExists('api_sensors');
    }
}
