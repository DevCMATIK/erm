<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubZoneElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_zone_elements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sub_zone_id')->unsigned();
            $table->string('name')->nullable();
            $table->integer('column');

            $table->foreign('sub_zone_id')->references('id')->on('sub_zones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_zone_elements');
    }
}
