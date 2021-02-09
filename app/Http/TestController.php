<?php

namespace App\Http;

use App\App\Controllers\Soap\SoapController;
use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\CheckPoint\DGA\CheckPointReport;
use Illuminate\Support\Facades\DB;
use Sentinel;


class TestController extends SoapController
{

    public $current_date = '2020-12-01';

    public function __invoke()
    {
        $check_points =   CheckPoint::whereNotNull('work_code')
            ->where('dga_report',1)
            ->get();

        foreach($check_points as $check_point) {
            $reports = CheckPointReport::where('check_point_id',$check_point->id)
                ->groupBy('date')
                ->orderBy('date', 'DESC')
                ->get(array(
                    DB::raw('Date(report_date) as date'),
                    DB::raw('COUNT(*) as "reports"')
                ));

           return $reports->toJson();
        }
    }
}
