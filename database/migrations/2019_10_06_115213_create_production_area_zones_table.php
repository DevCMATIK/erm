<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductionAreaZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_area_zones', function (Blueprint $table) {
            $table->integer('production_area_id')->unsigned();
            $table->integer('zone_id')->unsigned();
            $table->primary(['production_area_id','zone_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('production_area_zones');
    }
}
