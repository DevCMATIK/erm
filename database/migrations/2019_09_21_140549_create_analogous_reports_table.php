<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnalogousReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analogous_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('device_id')->unsigned()->index();
            $table->string('register_type')->index();
            $table->integer('address')->index();
            $table->integer('sensor_id')->unsigned()->index();
            $table->integer('historical_type_id')->unsigned()->index()->nullable();
            $table->string('scale');
            $table->float('scale_min');
            $table->float('scale_max');
            $table->float('ing_min');
            $table->float('ing_max');
            $table->string('unit');
            $table->float('value');
            $table->float('result');
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
        Schema::dropIfExists('analogous_reports');
    }
}
