<?php

namespace App\Http;

use App\App\Controllers\Controller;
use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\CheckPoint\DGA\CheckPointReport;
use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\Client\Zone\Zone;
use App\Domain\System\User\User;
use App\Domain\WaterManagement\Device\Device;
use App\Domain\WaterManagement\Device\Sensor\Electric\ElectricityConsumption;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Sentinel;


class TestController extends Controller
{
    use HasAnalogousData;

    public function __invoke()
    {
        $time_start = microtime(true);

        $checkPoints = CheckPoint::with('last_report')->whereNotNull('work_code')->where('dga_report',1)->get();



        $time_end = microtime(true);

        $execution_time = ($time_end - $time_start);

        dd($execution_time,$checkPoints);

    }



}
