<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCheckPointIdToSubZoneSubElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sub_zone_sub_elements', function (Blueprint $table) {
            $table->integer('check_point_id')->unsigned()->nullable();
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
        Schema::table('sub_zone_sub_elements', function (Blueprint $table) {
            $$table->dropForeign('sub_zone_sub_elements_check_point_id_foreign');
            $table->dropColumn('check_point_id');
        });
    }
}
