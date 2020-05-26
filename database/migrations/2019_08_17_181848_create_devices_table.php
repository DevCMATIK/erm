<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('internal_id')->index();
            $table->integer('device_type_id')->unsigned();
            $table->integer('check_point_id')->unsigned();
            $table->string('name');
            $table->softDeletes();
            $table->foreign('device_type_id')->references('id')->on('device_types');
            $table->foreign('check_point_id')->references('id')->on('check_points');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
}
