<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChronometerTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chronometer_trackings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('chronometer_id')->unsigned();
            $table->dateTime('start_date')->index();
            $table->dateTime('end_date')->index()->nullable();
            $table->integer('value');

            $table->foreign('chronometer_id')->references('id')->on('sensor_chronometers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chronometer_trackings');
    }
}
