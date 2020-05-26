<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnalogousDispositionsReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analogous_dispositions_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('analogous_report_id')->unsigned()->index();
            $table->string('scale');
            $table->float('scale_min');
            $table->float('scale_max');
            $table->float('scale_min');
            $table->float('scale_max');
            $table->string('unit');
            $table->float('value');
            $table->float('result');

            $table->foreign('analogous_report_id')->references('id')->on('analogous_reports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('analogous_dispositions_reports');
    }
}
