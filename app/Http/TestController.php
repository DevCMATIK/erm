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
        $check_points =   CheckPoint::with('last_report')->whereNotNull('work_code')
            ->where('dga_report',1)
            ->get();
        return $check_points->toJson();
        foreach($check_points as $check_point) {
            dd($check_point);
            dd(Carbon::parse($check_point->last_report->report_date)->hour,now()->hour);

        }
    }
}
