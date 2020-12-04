<?php

namespace App\Http;

use App\App\Controllers\Controller;
use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\Client\Zone\Zone;
use App\Domain\WaterManagement\Device\Sensor\Electric\ElectricityConsumption;
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

        $consumptions = array();
        $zone = Zone::with('sub_zones')->find(11);

        foreach($zone->sub_zones as $sub_zone) {
            array_push($consumptions,[
                $sub_zone->name => [
                    'this-year' => $this->getThisYearTotal($sub_zone)->toArray()
                ]
            ]);
        }

        $time_end = microtime(true);

        $execution_time = ($time_end - $time_start);



        dd(
            $consumptions,
            $execution_time
        );
    }

    protected function getThisYearTotal($sub_zone)
    {
        return $this->getByYearTotal($sub_zone)->where('years',now()->year)->first();
    }

    protected function getByYearTotal($sub_zone)
    {
        return ElectricityConsumption::select(
            DB::raw('sum(consumption) as consumption'),
            DB::raw("DATE_FORMAT(date,'%Y') as years")
        )->where('sensor_type','ee-e-activa')
            ->where('sub_zone_id',$sub_zone->id)
            ->groupBy('years')
            ->get();
    }


}
