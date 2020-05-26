<?php

namespace App\Http\Client\CheckPoint\Report\Controllers;

use App\Domain\Client\CheckPoint\CheckPoint;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class CheckPointReportController extends Controller
{
    public function index()
    {
        return view('client.check-point.report.index');
    }

    public function log($id)
    {
        $check_point = CheckPoint::with('sub_zones')->find($id);
        return view('client.check-point.report.log',compact('check_point'));
    }
}
