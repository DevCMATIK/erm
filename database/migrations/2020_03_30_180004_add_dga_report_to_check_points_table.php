<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDgaReportToCheckPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('check_points', function (Blueprint $table) {
            $table->integer('dga_report')->nullable();
            $table->string('work_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('check_points', function (Blueprint $table) {
            $table->dropColumn('dga_report');
            $table->dropColumn('work_code');
        });
    }
}
