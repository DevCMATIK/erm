<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSensorBackupChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensor_backup_checks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('device_id')->unsigned();
            $table->integer('sensor_id')->unsigned();
            $table->datetime('start')->nullable();
            $table->datetime('end')->nullable();
            $table->integer('entries')->nullable();
            $table->foreign('device_id')->references('id')->on('devices');
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
        Schema::dropIfExists('sensor_backup_checks');
    }
}
