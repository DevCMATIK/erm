<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddScaleColumnToAnalogousReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('analogous_reports', function (Blueprint $table) {
            $table->string('scale_color')->nullable()->after('result');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('analogous_reports', function (Blueprint $table) {
            $table->dropColumn('scale_color');
        });
    }
}
