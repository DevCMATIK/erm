<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckPointAuthorizedFlowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_point_authorized_flows', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('check_point_id')->unsigned();
            $table->float('authorized_flow',255,10);
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
        Schema::dropIfExists('check_point_authorized_flows');
    }
}
