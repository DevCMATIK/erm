<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_points', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sub_zone_id')->unsigned();
            $table->integer('type_id')->unsigned()->nullable();
            $table->string('slug')->unique();
            $table->string('name');

            $table->foreign('sub_zone_id')
                ->references('id')
                ->on('sub_zones')
                ->onDelete('cascade');
            $table->foreign('type_id')
                ->references('id')
                ->on('check_point_types')
                ->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('check_points');
    }
}
