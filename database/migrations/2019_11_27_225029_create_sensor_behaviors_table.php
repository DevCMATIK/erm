<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSensorBehaviorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensor_behaviors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sensor_id')->unsigned();
            $table->double('static_level',30,6)->nullable();
            $table->double('dynamic_level',30,6)->nullable();
            $table->double('current_average',30,6);
            $table->dateTime('date');

            $table->foreign('sensor_id')
                ->references('id')
                ->on('sensors')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sensor_behaviors');
    }
}
