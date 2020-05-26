<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDispositionLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disposition_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sensor_disposition_id')->unsigned();
            $table->string('chart');
            $table->string('color');
            $table->float('value',255,10);
            $table->string('text');

            $table->foreign('sensor_disposition_id')->references('id')->on('sensor_dispositions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disposition_lines');
    }
}
