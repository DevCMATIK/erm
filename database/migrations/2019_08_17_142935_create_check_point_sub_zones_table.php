<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckPointSubZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_point_sub_zones', function (Blueprint $table) {
            $table->integer('check_point_id')->unsigned();
            $table->integer('sub_zone_id')->unsigned();

            $table->primary(['sub_zone_id','check_point_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('check_point_sub_zones');
    }
}
