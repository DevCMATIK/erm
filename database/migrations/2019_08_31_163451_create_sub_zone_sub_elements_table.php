<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubZoneSubElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_zone_sub_elements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sub_zone_element_id')->unsigned();
            $table->integer('device_id')->unsigned();
            $table->integer('position');

            $table->foreign('sub_zone_element_id')->references('id')->on('sub_zone_elements')->onDelete('cascade');
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_zone_sub_elements');
    }
}
