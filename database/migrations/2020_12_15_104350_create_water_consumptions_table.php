<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWaterConsumptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('water_consumptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sensor_id')->unsigned();
            $table->integer('sub_zone_id')->unsigned()->nullable();
            $table->string('sensor_type')->nullable();
            $table->double('consumption',255,6);
            $table->double('first_read',255,6);
            $table->double('last_read',255,6);
            $table->date('date');

            $table->foreign('sensor_id')
                ->references('id')
                ->on('sensors')
                ->onDelete('cascade');

            $table->foreign('sub_zone_id')
                ->references('id')
                ->on('sub_zones')
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
        Schema::dropIfExists('water_consumptions');
    }
}
