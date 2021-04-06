<?php

namespace App\Http;

use App\App\Controllers\Soap\SoapController;
use App\App\Jobs\SendToDGA;
use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\CheckPoint\DGA\CheckPointReport;
use App\Domain\Client\Zone\Zone;
use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\Data\Digital\DigitalReport;
use App\Domain\WaterManagement\Device\Sensor\Electric\ElectricityConsumption;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Http\ERM\Jobs\Restore;
use App\Http\ERM\Jobs\RestoreAlarmLog;
use App\Http\ERM\Jobs\RestoreAnalogousReport;
use App\Http\ERM\Jobs\RestoreCommandLog;
use App\Http\ERM\Jobs\RestoreDigitalReport;
use App\Http\ERM\Jobs\RestoreSensorTriggerLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Sentinel;


class TestController extends SoapController
{
    use HasAnalogousData;

    public $current_date = '2020-12-01';


    public function __invoke()
    {
        /*$zone = Zone::with('sub_zones.consumptions')->find(11);
        $consumptions = array();

        foreach($zone->sub_zones->sortBy('name') as $sub_zone) {
            $monthly = $this->getMonthlyTotal($sub_zone);
            //$yesterday = $this->getYesterdayConsumption($sub_zone);
            array_push($consumptions,[
                $sub_zone->name => array_merge(
                    ['this-year' => $this->getThisYearTotal($sub_zone)->toArray()],
                     $monthly->toArray())
                ]);
        }

        echo json_encode($consumptions);*/
        $consumptions = collect($this->getConsumptions())->collapse();
        return $this->testResponse($consumptions->map(function($item)));
        $first =collect($consumptions->first());
        $rows = array();
        foreach ($consumptions as $sub_zone => $consumption) {
           $name = str_replace(' TG-1','',str_replace(' TG-2','',$sub_zone));
           foreach($consumption as $key => $data) {
               if($key !== 'this-year') {
                   if(!isset($rows[$name][$key])) {
                       $rows[$name][$key] = $data;
                   } else  {
                       $rows[$name][$key] += $data;
                   }
               }



           }
        }
        return view('water-management.dashboard.energy.power-bi', [
            'rows' =>  collect($rows)->map(function($column,$index){
                return array_values(collect($column)->map(function($col,$month) use($index){
                    return [
                        $index,$col,$month
                    ];
                })->toArray());
            })->collapse(),
        ]);
    }


    public function testResponse($results)
    {
        return response()->json(array_merge(['results' => $results],$this->getExecutionTime()));
    }

    public function getExecutionTime()
    {
        return [
            'time_in_seconds' => (microtime(true) - LARAVEL_START)
        ];
    }

    protected function getTodayConsumption($sub_zone,$last_read)
    {
        $sensor = Sensor::
        with(['device.report','dispositions.unit'])
            ->find($sub_zone->consumptions
                ->where('sensor_type')
                ->first()
                ->sensor_id
            );
        $value = $this->getAnalogousValue($sensor);

        return number_format( ($value['value'] - $last_read),2);
    }

    protected function getYesterdayConsumption($sub_zone)
    {
        return $sub_zone->consumptions
            ->where('sensor_type','ee-e-activa')
            ->where('date',now()->subDay()
                ->toDateString())->first();

    }

    protected function getMonthlyTotal($sub_zone)
    {
        return ElectricityConsumption::select(
            DB::raw('sum(consumption) as consumption'),
            DB::raw("DATE_FORMAT(date,'%Y-%m') as month")
        )->where('sensor_type','ee-e-activa')
            ->where('sub_zone_id',$sub_zone->id)
            ->groupBy('month')
            ->get()->map(function($item){
                return [$item->month => $item->consumption];
            })->collapse();
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


    protected function getConsumptions()
    {
        return json_decode(
            '{"Castrol TG-1":[{"consumption":44371,"month":"2020-01"},{"consumption":83001,"month":"2020-02"},{"consumption":101764,"month":"2020-03"},{"consumption":99001,"month":"2020-04"},{"consumption":25133,"month":"2020-05"},{"consumption":28072,"month":"2020-06"},{"consumption":54522,"month":"2020-07"},{"consumption":74891,"month":"2020-08"},{"consumption":89672,"month":"2020-09"},{"consumption":30906,"month":"2020-10"},{"consumption":36117,"month":"2020-11"},{"consumption":70029,"month":"2020-12"},{"consumption":92947.016,"month":"2021-01"},{"consumption":97069.696,"month":"2021-02"},{"consumption":78122.94399999999,"month":"2021-03"},{"consumption":3667.712,"month":"2021-04"}],"Castrol TG-2":[{"consumption":18893,"month":"2020-01"},{"consumption":35259,"month":"2020-02"},{"consumption":42554,"month":"2020-03"},{"consumption":39953,"month":"2020-04"},{"consumption":8815,"month":"2020-05"},{"consumption":10917,"month":"2020-06"},{"consumption":22443,"month":"2020-07"},{"consumption":32082,"month":"2020-08"},{"consumption":37972,"month":"2020-09"},{"consumption":10101,"month":"2020-10"},{"consumption":14792,"month":"2020-11"},{"consumption":30346,"month":"2020-12"},{"consumption":40404.272,"month":"2021-01"},{"consumption":41521.15199999999,"month":"2021-02"},{"consumption":32148.608,"month":"2021-03"},{"consumption":1427.5839999999998,"month":"2021-04"}],"Don Sata TG-1":[{"consumption":25131.2,"month":"2020-01"},{"consumption":77455.60000000002,"month":"2020-02"},{"consumption":104999.19999999998,"month":"2020-03"},{"consumption":108775.2,"month":"2020-04"},{"consumption":83374.00000000003,"month":"2020-05"},{"consumption":20322.800000000003,"month":"2020-06"},{"consumption":39091.99999999999,"month":"2020-07"},{"consumption":56980.799999999996,"month":"2020-08"},{"consumption":84859.99999999999,"month":"2020-09"},{"consumption":88413.2,"month":"2020-10"},{"consumption":23879.199999999997,"month":"2020-11"},{"consumption":58224,"month":"2020-12"},{"consumption":86659,"month":"2021-01"},{"consumption":90714.40000000001,"month":"2021-02"},{"consumption":115717.59999999999,"month":"2021-03"},{"consumption":16447.2,"month":"2021-04"}],"Don Sata TG-2":[{"consumption":6422.999999999999,"month":"2020-01"},{"consumption":18471.4,"month":"2020-02"},{"consumption":25695.4,"month":"2020-03"},{"consumption":26748.200000000004,"month":"2020-04"},{"consumption":21090.5,"month":"2020-05"},{"consumption":6060.400000000001,"month":"2020-06"},{"consumption":11330.2,"month":"2020-07"},{"consumption":15959.1,"month":"2020-08"},{"consumption":22028.3,"month":"2020-09"},{"consumption":20809.1,"month":"2020-10"},{"consumption":6958,"month":"2020-11"},{"consumption":15207.500000000004,"month":"2020-12"},{"consumption":21877.8,"month":"2021-01"},{"consumption":22737.2,"month":"2021-02"},{"consumption":28586.999999999996,"month":"2021-03"},{"consumption":2616.6000000000004,"month":"2021-04"}],"El Diputado":[{"consumption":11072.1,"month":"2020-01"},{"consumption":17728.699999999993,"month":"2020-02"},{"consumption":19948.699999999997,"month":"2020-03"},{"consumption":34181.200000000004,"month":"2020-04"},{"consumption":6249.700000000003,"month":"2020-05"},{"consumption":36182.09999999999,"month":"2020-06"},{"consumption":83170.10000000002,"month":"2020-07"},{"consumption":32862.5,"month":"2020-08"},{"consumption":18840.900000000005,"month":"2020-09"},{"consumption":25119.499999999996,"month":"2020-10"},{"consumption":32234.499999999996,"month":"2020-11"},{"consumption":41802.8,"month":"2020-12"},{"consumption":38517.200000000004,"month":"2021-01"},{"consumption":32849.49999999999,"month":"2021-02"},{"consumption":32435.899999999998,"month":"2021-03"},{"consumption":450.59999999999997,"month":"2021-04"}],"El Divisadero TG-1":[{"consumption":120683.40000000001,"month":"2020-01"},{"consumption":59645.399999999994,"month":"2020-02"},{"consumption":30274.59999999999,"month":"2020-03"},{"consumption":22667.999999999996,"month":"2020-04"},{"consumption":41209.899999999994,"month":"2020-05"},{"consumption":42156.80000000001,"month":"2020-06"},{"consumption":51113.8,"month":"2020-07"},{"consumption":27353.899999999998,"month":"2020-08"},{"consumption":16929.3,"month":"2020-09"},{"consumption":31286.4,"month":"2020-10"},{"consumption":47812.3,"month":"2020-11"},{"consumption":62135.1,"month":"2020-12"},{"consumption":51187.4,"month":"2021-01"},{"consumption":17956.8,"month":"2021-02"},{"consumption":32445.200000000004,"month":"2021-03"},{"consumption":6935.099999999999,"month":"2021-04"}],"El Divisadero TG-2":[{"consumption":37376.899999999994,"month":"2020-01"},{"consumption":83045.9,"month":"2020-02"},{"consumption":27169.999999999996,"month":"2020-03"},{"consumption":30737.899999999998,"month":"2020-04"},{"consumption":50102.799999999996,"month":"2020-05"},{"consumption":51289.8,"month":"2020-06"},{"consumption":65029.90000000001,"month":"2020-07"},{"consumption":15294.6,"month":"2020-08"},{"consumption":18968.100000000002,"month":"2020-09"},{"consumption":39338.600000000006,"month":"2020-10"},{"consumption":63721.90000000001,"month":"2020-11"},{"consumption":85422.20000000001,"month":"2020-12"},{"consumption":56014.40000000001,"month":"2021-01"},{"consumption":21070.600000000006,"month":"2021-02"},{"consumption":43344,"month":"2021-03"},{"consumption":8519.300000000001,"month":"2021-04"}],"El Retorno TG-1":[{"consumption":36485,"month":"2020-01"},{"consumption":30141,"month":"2020-02"},{"consumption":25024,"month":"2020-03"},{"consumption":36814,"month":"2020-04"},{"consumption":45640,"month":"2020-05"},{"consumption":40396,"month":"2020-06"},{"consumption":33197,"month":"2020-07"},{"consumption":9495,"month":"2020-08"},{"consumption":21043.104000000003,"month":"2020-09"},{"consumption":38521.087999999996,"month":"2020-10"},{"consumption":52425.088,"month":"2020-11"},{"consumption":49214.208,"month":"2020-12"},{"consumption":17340.704,"month":"2021-01"},{"consumption":24429.823999999997,"month":"2021-02"},{"consumption":43452.28799999999,"month":"2021-03"},{"consumption":8057.6,"month":"2021-04"}],"El Retorno TG-2":[{"consumption":43167.700000000004,"month":"2020-01"},{"consumption":45743.80000000002,"month":"2020-02"},{"consumption":35395.4,"month":"2020-03"},{"consumption":53539.20000000001,"month":"2020-04"},{"consumption":68186.09999999999,"month":"2020-05"},{"consumption":62464.900000000016,"month":"2020-06"},{"consumption":48138.40000000001,"month":"2020-07"},{"consumption":17594.600000000002,"month":"2020-08"},{"consumption":29912.899999999998,"month":"2020-09"},{"consumption":56820.2,"month":"2020-10"},{"consumption":74189.40000000001,"month":"2020-11"},{"consumption":79957.99999999999,"month":"2020-12"},{"consumption":24336.6,"month":"2021-01"},{"consumption":37242.7,"month":"2021-02"},{"consumption":66879.19999999998,"month":"2021-03"},{"consumption":11848.2,"month":"2021-04"}],"La Fiera":[{"consumption":40978.1,"month":"2020-01"},{"consumption":83635.5,"month":"2020-02"},{"consumption":106509.19999999998,"month":"2020-03"},{"consumption":58357.1,"month":"2020-04"},{"consumption":82618.49999999997,"month":"2020-05"},{"consumption":38185.19999999999,"month":"2020-06"},{"consumption":80234.19999999998,"month":"2020-07"},{"consumption":30571.399999999998,"month":"2020-08"},{"consumption":94255.99999999997,"month":"2020-09"},{"consumption":30226.2,"month":"2020-10"},{"consumption":107482.19999999997,"month":"2020-11"},{"consumption":52639,"month":"2020-12"},{"consumption":124698.79999999999,"month":"2021-01"},{"consumption":45789.799999999996,"month":"2021-02"},{"consumption":105073.79999999997,"month":"2021-03"},{"consumption":2921,"month":"2021-04"}],"La Liguana":[{"consumption":2626.2000000000003,"month":"2020-01"},{"consumption":7132.300000000001,"month":"2020-02"},{"consumption":10376.6,"month":"2020-03"},{"consumption":755.2,"month":"2020-06"},{"consumption":154.9,"month":"2020-07"},{"consumption":15566.800000000001,"month":"2020-08"},{"consumption":9674.800000000001,"month":"2020-09"},{"consumption":12531.4,"month":"2020-10"},{"consumption":13207.4,"month":"2020-11"},{"consumption":17493,"month":"2020-12"},{"consumption":7556,"month":"2021-01"},{"consumption":13820.199999999999,"month":"2021-02"},{"consumption":11023.200000000003,"month":"2021-03"},{"consumption":485.40000000000003,"month":"2021-04"}],"Las Brisas TG-1":[{"consumption":27157.311999999994,"month":"2020-01"},{"consumption":63185.2,"month":"2020-02"},{"consumption":74272.79999999999,"month":"2020-03"},{"consumption":69479.2,"month":"2020-04"},{"consumption":21307.6,"month":"2020-05"},{"consumption":28963.999999999996,"month":"2020-06"},{"consumption":45383.20000000001,"month":"2020-07"},{"consumption":55695.200000000004,"month":"2020-08"},{"consumption":70831.59999999999,"month":"2020-09"},{"consumption":22369.600000000006,"month":"2020-10"},{"consumption":34365.600000000006,"month":"2020-11"},{"consumption":62699.2,"month":"2020-12"},{"consumption":74711.2,"month":"2021-01"},{"consumption":76425.6,"month":"2021-02"},{"consumption":45641.2,"month":"2021-03"},{"consumption":3740.4,"month":"2021-04"}],"Las Brisas TG-2":[{"consumption":16208.599999999999,"month":"2020-01"},{"consumption":39507.4,"month":"2020-02"},{"consumption":46279.60000000001,"month":"2020-03"},{"consumption":43256.2,"month":"2020-04"},{"consumption":10186.600000000002,"month":"2020-05"},{"consumption":15108.199999999997,"month":"2020-06"},{"consumption":25870.199999999997,"month":"2020-07"},{"consumption":33671.799999999996,"month":"2020-08"},{"consumption":44212.00000000001,"month":"2020-09"},{"consumption":10269.4,"month":"2020-10"},{"consumption":20188,"month":"2020-11"},{"consumption":38145.200000000004,"month":"2020-12"},{"consumption":46683.40000000001,"month":"2021-01"},{"consumption":47787.99999999999,"month":"2021-02"},{"consumption":27747.999999999996,"month":"2021-03"},{"consumption":2056.7999999999997,"month":"2021-04"}],"Los Tatas TG-1":[{"consumption":53516.09999999999,"month":"2020-01"},{"consumption":71081.79999999999,"month":"2020-02"},{"consumption":46831,"month":"2020-03"},{"consumption":69604.1,"month":"2020-04"},{"consumption":87746.29999999999,"month":"2020-05"},{"consumption":79833.79999999999,"month":"2020-06"},{"consumption":65110.299999999996,"month":"2020-07"},{"consumption":16444.7,"month":"2020-08"},{"consumption":37361.200000000004,"month":"2020-09"},{"consumption":69388.7,"month":"2020-10"},{"consumption":95850.10000000002,"month":"2020-11"},{"consumption":111017.3,"month":"2020-12"},{"consumption":34064.1,"month":"2021-01"},{"consumption":43615.799999999996,"month":"2021-02"},{"consumption":79664.4,"month":"2021-03"},{"consumption":13788.4,"month":"2021-04"}],"Los Tatas TG-2":[{"consumption":13730.199999999999,"month":"2020-01"},{"consumption":19916.500000000004,"month":"2020-02"},{"consumption":12746.599999999999,"month":"2020-03"},{"consumption":18753.600000000002,"month":"2020-04"},{"consumption":23941.800000000003,"month":"2020-05"},{"consumption":22814.499999999996,"month":"2020-06"},{"consumption":18917.899999999998,"month":"2020-07"},{"consumption":6804.5,"month":"2020-08"},{"consumption":11615.599999999999,"month":"2020-09"},{"consumption":19202.699999999997,"month":"2020-10"},{"consumption":25143.6,"month":"2020-11"},{"consumption":28380.7,"month":"2020-12"},{"consumption":9856.4,"month":"2021-01"},{"consumption":12543.5,"month":"2021-02"},{"consumption":21224.50000000001,"month":"2021-03"},{"consumption":3695.9000000000005,"month":"2021-04"}],"Pozo 1 Rapel":[{"consumption":21542.899999999998,"month":"2020-01"},{"consumption":34874.99999999999,"month":"2020-02"},{"consumption":35170.00000000001,"month":"2020-03"},{"consumption":8402.1,"month":"2020-04"},{"consumption":2798.7,"month":"2020-05"},{"consumption":1417.0999999999997,"month":"2020-06"},{"consumption":3230.6000000000004,"month":"2020-07"},{"consumption":1340.5,"month":"2020-08"},{"consumption":2621.7,"month":"2020-09"},{"consumption":4667.800000000001,"month":"2020-10"},{"consumption":2947.400000000001,"month":"2020-11"},{"consumption":1302.8000000000002,"month":"2020-12"},{"consumption":50562.6,"month":"2021-01"},{"consumption":77276.59999999999,"month":"2021-02"},{"consumption":99065.19999999998,"month":"2021-03"},{"consumption":13304.9,"month":"2021-04"}],"Pozo 2 Rapel":[{"consumption":18020.499999999996,"month":"2020-01"},{"consumption":1631.0000000000002,"month":"2020-03"},{"consumption":80509.30000000002,"month":"2020-04"},{"consumption":93558.20000000001,"month":"2020-05"},{"consumption":85147.8,"month":"2020-06"},{"consumption":85152.60000000002,"month":"2020-07"},{"consumption":77238.4,"month":"2020-08"},{"consumption":92706.9,"month":"2020-09"},{"consumption":91408.90000000001,"month":"2020-10"},{"consumption":100545.90000000001,"month":"2020-11"},{"consumption":108514.00000000001,"month":"2020-12"},{"consumption":54014.69999999998,"month":"2021-01"},{"consumption":744.6999999999999,"month":"2021-02"},{"consumption":1166.0000000000005,"month":"2021-03"},{"consumption":46.199999999999996,"month":"2021-04"}],"Pozo R1":[{"consumption":1936.1000000000004,"month":"2020-01"},{"consumption":4387.6,"month":"2020-02"},{"consumption":1974.2000000000003,"month":"2020-03"},{"consumption":3563.999999999999,"month":"2020-04"},{"consumption":7131.500000000001,"month":"2020-05"},{"consumption":4622.5999999999985,"month":"2020-06"},{"consumption":3962.9,"month":"2020-07"},{"consumption":3249.0999999999995,"month":"2020-08"},{"consumption":3254.7000000000003,"month":"2020-09"},{"consumption":4765.4,"month":"2020-10"},{"consumption":5129.900000000001,"month":"2020-11"},{"consumption":2451.0999999999995,"month":"2020-12"},{"consumption":3529.7999999999997,"month":"2021-01"},{"consumption":1630.3999999999999,"month":"2021-02"},{"consumption":3072.7,"month":"2021-03"},{"consumption":1155.5,"month":"2021-04"}],"Pozo R2":[{"consumption":2208.6,"month":"2020-01"},{"consumption":3571.0000000000005,"month":"2020-02"},{"consumption":2155.6000000000004,"month":"2020-10"},{"consumption":4231.9,"month":"2020-11"},{"consumption":4428,"month":"2020-12"},{"consumption":5212.999999999999,"month":"2021-01"},{"consumption":5901.500000000001,"month":"2021-02"},{"consumption":7300.100000000001,"month":"2021-03"},{"consumption":961.5,"month":"2021-04"}],"Rapel TG-1":[{"consumption":79726.20000000001,"month":"2020-01"},{"consumption":107689.09999999998,"month":"2020-02"},{"consumption":114468.19999999998,"month":"2020-03"},{"consumption":112838.1,"month":"2020-04"},{"consumption":108648.10000000003,"month":"2020-05"},{"consumption":92438.39999999997,"month":"2020-06"},{"consumption":101558.69999999998,"month":"2020-07"},{"consumption":15719.999999999998,"month":"2020-08"},{"consumption":560.0000000000001,"month":"2020-09"},{"consumption":647.9000000000001,"month":"2020-10"},{"consumption":3064.6000000000004,"month":"2020-11"},{"consumption":882.6000000000003,"month":"2020-12"},{"consumption":2.4,"month":"2021-01"},{"consumption":0.1,"month":"2021-02"},{"consumption":4.1,"month":"2021-03"},{"consumption":0,"month":"2021-04"}],"Rapel TG-2":[{"consumption":49915.3,"month":"2020-01"},{"consumption":83826.19999999998,"month":"2020-02"},{"consumption":5767.4,"month":"2020-03"},{"consumption":27161.9,"month":"2020-08"},{"consumption":157411.80000000002,"month":"2020-09"},{"consumption":159209.1,"month":"2020-10"},{"consumption":164225.6,"month":"2020-11"},{"consumption":179808.89999999997,"month":"2020-12"},{"consumption":183043.2,"month":"2021-01"},{"consumption":140597.19999999998,"month":"2021-02"},{"consumption":189842.4,"month":"2021-03"},{"consumption":24708.8,"month":"2021-04"}]}'
            ,true);
    }
}
