<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckPointIndicatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_point_indicators', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('check_point_id')->unsigned();
            $table->integer('sensor_id')->unsigned();
            $table->integer('to_compare_sensor')->unsigned()->nullable();
            $table->string('name');
            $table->string('type');
            $table->string('frame');
            $table->string('measurement');
            $table->string('group_name');
            $table->integer('group');
            $table->integer('position')->nullable();

            $table->foreign('check_point_id')->references('id')->on('check_points')->onDelete('cascade');
            $table->foreign('sensor_id')->references('id')->on('sensors')->onDelete('cascade');
            $table->foreign('to_compare_sensor')->references('id')->on('sensors')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('check_point_indicators');
    }
}
