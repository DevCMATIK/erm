<?php

namespace App\Http\WaterManagement\Dashboard\Kpi;

use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\WaterManagement\Main\Historical;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class LastUpdateController extends Controller
{
    public function __invoke()
    {
         return AnalogousReport::orderBy('date','desc')->first()->date;
    }
}
