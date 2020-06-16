<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToSensorTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sensor_types', function (Blueprint $table) {
            $table->float('min_value',255,6)->nullable()->after('interval');
            $table->float('max_value',255,6)->nullable()->after('min_value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sensor_types', function (Blueprint $table) {
            $table->dropColumn('min_value','max_value');
        });
    }
}
