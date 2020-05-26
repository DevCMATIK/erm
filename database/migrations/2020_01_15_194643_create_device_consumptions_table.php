<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeviceConsumptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_consumptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('check_point_id')->unsigned();
            $table->float('active_energy',255,6);
            $table->float('water_input',255,6);
            $table->float('hour_value',255,6);
            $table->float('hour_consumption',255,6);
            $table->dateTime('date');

            $table->foreign('check_point_id')->references('id')->on('check_points')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_consumptions');
    }
}
