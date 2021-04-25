<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnsInMapLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('map_lines', function (Blueprint $table) {
            $table->dropColumn('one_lng', 'one_lat', 'two_lat','two_lng');
            $table->text('points_between')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('map_lines', function (Blueprint $table) {
            //
        });
    }
}
