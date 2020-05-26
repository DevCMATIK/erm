<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElectricityConsumptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('electricity_consumptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sensor_id')->unsigned();
            $table->double('consumption',255,6);
            $table->double('first_read',255,6);
            $table->double('last_read',255,6);
            $table->date('date');

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
        Schema::dropIfExists('electricity_consumptions');
    }
}
