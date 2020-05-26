<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInterpreterColumnToAnalogousReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('analogous_reports', function (Blueprint $table) {
            $table->string('interpreter')->nullable();
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
            $table->dropColumn('interpreter');
        });
    }
}
