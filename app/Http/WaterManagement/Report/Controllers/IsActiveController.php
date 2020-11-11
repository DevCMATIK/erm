<?php

namespace App\Http\WaterManagement\Report\Controllers;

use App\App\Controllers\Controller;
use App\Domain\WaterManagement\Report\MailReport;

class IsActiveController extends Controller
{
    public function index($report_id,$active)
    {
        $report = MailReport::find($report_id);
        $report->is_active = $active;
        $report->save();

        return redirect('/mail-reports');
    }
}
