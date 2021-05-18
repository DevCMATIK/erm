<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToElectricityConsumptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('electricity_consumptions', function (Blueprint $table) {
            $table->float('high_consumption',100,1)->nullable()->after('last_read');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('electricity_consumptions', function (Blueprint $table) {
            //
        });
    }
}
