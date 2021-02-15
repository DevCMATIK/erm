<?php

namespace App\Http;

use App\App\Controllers\Soap\SoapController;
use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\CheckPoint\DGA\CheckPointReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Sentinel;


class TestController extends SoapController
{

    public $current_date = '2020-12-01';

    public function __invoke()
    {
        $record =  CheckPoint::with(['type','sub_zones'])->withCount(['dga_reports','this_month_failed_reports','reports_to_date'])->whereNotNull('work_code')->find(27);
        dd($record);
    }
}
