<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDigitalReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('digital_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('device_id')->unsigned()->index();
            $table->string('register_type')->index();
            $table->integer('address')->index();
            $table->integer('sensor_id')->unsigned()->index();
            $table->integer('historical_type_id')->unsigned()->index()->nullable();
            $table->string('name');
            $table->string('on_label');
            $table->string('off_label');
            $table->float('value');
            $table->string('label');
            $table->dateTime('date');

            $table->foreign('device_id')->references('id')->on('devices');
            $table->foreign('sensor_id')->references('id')->on('sensors');
            $table->foreign('historical_type_id')->references('id')->on('historical_types');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('digital_reports');
    }
}
