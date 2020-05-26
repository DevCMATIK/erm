<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckPointGridsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_point_grids', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('check_point_id')->unsigned();
            $table->integer('sensor_id')->unsigned();
            $table->integer('column');
            $table->integer('row');

            $table->foreign('check_point_id')->references('id')->on('check_points');
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
        Schema::dropIfExists('check_point_grids');
    }
}
