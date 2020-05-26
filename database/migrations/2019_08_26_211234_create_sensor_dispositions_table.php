<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSensorDispositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensor_dispositions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('sensor_id')->unsigned();
            $table->integer('scale_id')->unsigned();
            $table->integer('unit_id')->unsigned();
            $table->float('scale_min',255,10)->nullable();
            $table->float('scale_max',255,10)->nullable();
            $table->float('sensor_min',255,10);
            $table->float('sensor_max',255,10);
            $table->integer('precision')->nullable();


            $table->foreign('sensor_id')->references('id')->on('sensors')->onDelete('cascade');
            $table->foreign('scale_id')->references('id')->on('scales')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sensor_dispositions');
    }
}
