<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToSubElementSensorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sub_element_sensors', function (Blueprint $table) {
            $table->tinyInteger('is_not_an_output')->nullable()->after('use_as_digital_chart');
            $table->tinyInteger('no_chart_needed')->nullable()->after('use_as_digital_chart');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sub_element_sensors', function (Blueprint $table) {
            $table->dropColumn('is_not_an_output');
            $table->dropColumn('no_chart_needed');
        });
    }
}
