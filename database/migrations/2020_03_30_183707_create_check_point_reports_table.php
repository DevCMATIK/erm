<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckPointReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_point_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('check_point_id')->unsigned();
            $table->integer('response');
            $table->string('response_text');
            $table->float('tote_reported',255,2);
            $table->float('flow_reported',255,2);
            $table->float('water_table_reported',255,2);
            $table->dateTime('report_date');

            $table->foreign('check_point_id')->references('id')->on('check_points');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('check_point_reports');
    }
}
