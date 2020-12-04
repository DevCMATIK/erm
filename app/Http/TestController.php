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
        $zone = Zone::with('sub_zones.consumptions')->find(11);

        foreach($zone->sub_zones as $sub_zone) {
            $monthly = $this->getMonthlyTotal($sub_zone);
            array_push($consumptions,[
                $sub_zone->name => [
                    'this-year' => $this->getThisYearTotal($sub_zone)->toArray(),
                    'monthly' => $monthly->toArray(),
                    'this-month' => $monthly->where('month',now()->format('Y-m'))->first()->toArray(),
                    'yesterday' => $this->getYesterdayConsumption($sub_zone),
                    'today' => $this->getTodayConsumption($sub_zone)
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

    protected function getTodayConsumption($sub_zone)
    {

    }

    protected function getYesterdayConsumption($sub_zone)
    {
        return $sub_zone->consumptions->where('sensor_type','ee-e-activa')->where('date',now()->subDay()->toDateString())->first()->consumption;
      /* return ElectricityConsumption::where('sensor_type','ee-e-activa')
           ->where('sub_zone_id',$sub_zone->id)
           ->where('date',now()->subDay()->toDateString())->first()->consumption;*/
    }

    protected function getMonthlyTotal($sub_zone)
    {
        return ElectricityConsumption::select(
            DB::raw('sum(consumption) as consumption'),
            DB::raw("DATE_FORMAT(date,'%Y-%m') as month")
        )->where('sensor_type','ee-e-activa')
            ->where('sub_zone_id',$sub_zone->id)
            ->groupBy('month')
            ->get();
    }

    protected function getThisYearTotal($sub_zone)
    {
        return $this->getByYearTotal($sub_zone)->where('year',now()->year)->first();
    }

    protected function getByYearTotal($sub_zone)
    {
        return ElectricityConsumption::select(
            DB::raw('sum(consumption) as consumption'),
            DB::raw("DATE_FORMAT(date,'%Y') as year")
        )->where('sensor_type','ee-e-activa')
            ->where('sub_zone_id',$sub_zone->id)
            ->groupBy('year')
            ->get();
    }


}
