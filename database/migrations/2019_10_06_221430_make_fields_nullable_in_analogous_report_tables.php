<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class MakeFieldsNullableInAnalogousReportTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE analogous_reports MODIFY scale_min FLOAT(8,6) NULL;');
        DB::statement('ALTER TABLE analogous_reports MODIFY scale_max FLOAT(8,6) NULL;');
        DB::statement('ALTER TABLE analogous_dispositions_reports MODIFY scale_min FLOAT(8,6) NULL;');
        DB::statement('ALTER TABLE analogous_dispositions_reports MODIFY scale_max FLOAT(8,6) NULL;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE analogous_reports MODIFY scale_min FLOAT(8,2) NOT NULL;');
        DB::statement('ALTER TABLE analogous_reports MODIFY scale_max FLOAT(8,2) NOT NULL;');
        DB::statement('ALTER TABLE analogous_dispositions_reports MODIFY scale_min FLOAT(8,2) NOT NULL;');
        DB::statement('ALTER TABLE analogous_dispositions_reports MODIFY scale_max FLOAT(8,2) NOT NULL;');
    }
}
