<?php

namespace App\Http\Client\CheckPoint\Report\Controllers;

use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\CheckPoint\DGA\CheckPointReport;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ReportStatisticsController extends Controller
{
    public function index($check_point_id)
    {
        $reports = CheckPointReport::where('check_point_id',$check_point_id)
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get(array(
                DB::raw('Date(report_date) as date'),
                DB::raw('COUNT(*) as "reports"')
            ));
        $check_point = CheckPoint::find($check_point_id);
        return view('client.check-point.report.statistic',compact('reports','check_point'));
    }
}
