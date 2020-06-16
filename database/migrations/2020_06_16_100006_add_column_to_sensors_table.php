<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToSensorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sensors', function (Blueprint $table) {
            $table->boolean('fix_values')->default(0)->after('fix_values_out_of_range');
            $table->float('fix_min_value',255,6)->nullable()->after('fix_values');
            $table->float('fix_max_value',255,6)->nullable()->after('fix_min_value');
            $table->float('last_value',255,6)->nullable()->after('fix_max_value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sensors', function (Blueprint $table) {
            $table->dropColumn('fix_values', 'fix_min_value', 'fix_max_value');
        });
    }
}
