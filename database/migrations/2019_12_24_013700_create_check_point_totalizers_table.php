<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckPointTotalizersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_point_totalizers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('check_point_id')->unsigned();
            $table->float('first_read',255,10);
            $table->float('last_read',255,10);
            $table->float('input',255,10);
            $table->float('totalizer_fix',255,10)->nullable();
            $table->date('date');
            $table->foreign('check_point_id')->references('id')->on('check_points')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('check_point_totalizers');
    }
}
