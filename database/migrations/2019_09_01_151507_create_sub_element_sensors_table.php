<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubElementSensorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_element_sensors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sub_element_id')->unsigned();
            $table->integer('sensor_id')->unsigned();
            $table->integer('position')->nullable();
            $table->boolean('show_in_dashboard')->nullable();
            $table->boolean('use_as_chart')->nullable();

            $table->foreign('sub_element_id')->references('id')->on('sub_zone_sub_elements')->onDelete('cascade');
            $table->foreign('sensor_id')->references('id')->on('sensors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_element_sensors');
    }
}
