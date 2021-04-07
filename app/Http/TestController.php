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
        $zone = Zone::with('sub_zones.consumptions')->find(11);
        $consumptions = collect($this->getConsumptions())->collapse();
        $months = array_keys(collect($consumptions->first())->collapse()->toArray());

        return view('water-management.dashboard.energy.resume-chart', [
            'months' => $months,
            'sub_zones' => $zone->sub_zones->map(function($item){
                return str_replace(' TG-1','',str_replace(' TG-2','',$item->name));
            })->unique()->toArray(),
            'zone' => $zone
        ]);
    }


    public function chartData(Request $request,$zone_id)
    {
        $data['series'] = array();
        array_push($data['series'] , [
            'name' => "Consumo",
            'data' => $this->makeSeries($request,$zone_id),
        ]) ;

        return json_encode($data,JSON_NUMERIC_CHECK);
    }

    protected function makeSeries(Request $request,$zone_id)
    {
        $zone = Zone::with('sub_zones.consumptions')->find($zone_id);
        $consumptions = array();
        foreach($zone->sub_zones->sortBy('name') as $sub_zone) {
            $monthly = $this->getMonthlyTotal($sub_zone);
            //$yesterday = $this->getYesterdayConsumption($sub_zone);
            array_push($consumptions,
                [
                    $sub_zone->name => $monthly->toArray()
                ]
            );
        }
        $consumptions = collect($consumptions)->collapse();
        $rows = array();
        if($request->sub_zone != '') {
            foreach ($consumptions as $sub_zone => $consumption) {
                $name = str_replace(' TG-1','',str_replace(' TG-2','',$sub_zone));
                foreach(collect($consumption) as $key => $data) {
                    if($row = collect($rows)->where('sub_zone',$name)->where('month',$key)->first()) {
                        $rows =  collect($rows)->map(function($item) use($name,$data,$key){
                            if($item['sub_zone'] == $name && $item['month'] == $key) {
                                return [
                                    'sub_zone' => $name,
                                    'month' => $key,
                                    'consumption' => $item['consumption'] +$data,
                                ];
                            } else {
                                return $item;
                            }
                        })->toArray();
                    } else {
                        array_push($rows,[
                            'sub_zone' => $name,
                            'month' => $key,
                            'consumption' => $data
                        ]);
                    }

                }
            }
            $rows = $rows->where('sub_zone',$request->sub_zone);
        } else {
            foreach ($consumptions as $sub_zone => $consumption) {
                foreach (collect($consumption) as $key => $data) {
                    if ($row = collect($rows)->where('month', $key)->first()) {
                        $rows = collect($rows)->map(function ($item) use ($data, $key) {
                            if ($item['month'] == $key) {
                                return [
                                    'month' => $key,
                                    'consumption' => $item['consumption'] + $data,
                                ];
                            } else {
                                return $item;
                            }
                        })->toArray();
                    } else {
                        array_push($rows, [
                            'month' => $key,
                            'consumption' => $data
                        ]);
                    }

                }
            }
        }
        $rows = collect($rows)->whereIn('month',$request->months);

        $array = array();
        foreach ($rows as $key => $row) {
            array_push($array, [
                'x' => (strtotime($row['month'].'-01'))*1000,
                'y' => number_format($row['consumption'],0),
                'name' => $row['month']
            ]);

        }
        return $array;
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
            '[{"Castrol TG-1":[{"2020-01":44371},{"2020-02":83001},{"2020-03":101764},{"2020-04":99001},{"2020-05":25133},{"2020-06":28072},{"2020-07":54522},{"2020-08":74891},{"2020-09":89672},{"2020-10":30906},{"2020-11":36117},{"2020-12":70029},{"2021-01":92947.016},{"2021-02":97069.696},{"2021-03":78122.94399999999},{"2021-04":3667.712}]},{"Castrol TG-2":[{"2020-01":18893},{"2020-02":35259},{"2020-03":42554},{"2020-04":39953},{"2020-05":8815},{"2020-06":10917},{"2020-07":22443},{"2020-08":32082},{"2020-09":37972},{"2020-10":10101},{"2020-11":14792},{"2020-12":30346},{"2021-01":40404.272},{"2021-02":41521.15199999999},{"2021-03":32148.608},{"2021-04":1427.5839999999998}]},{"Don Sata TG-1":[{"2020-01":25131.2},{"2020-02":77455.60000000002},{"2020-03":104999.19999999998},{"2020-04":108775.2},{"2020-05":83374.00000000003},{"2020-06":20322.800000000003},{"2020-07":39091.99999999999},{"2020-08":56980.799999999996},{"2020-09":84859.99999999999},{"2020-10":88413.2},{"2020-11":23879.199999999997},{"2020-12":58224},{"2021-01":86659},{"2021-02":90714.40000000001},{"2021-03":115717.59999999999},{"2021-04":16447.2}]},{"Don Sata TG-2":[{"2020-01":6422.999999999999},{"2020-02":18471.4},{"2020-03":25695.4},{"2020-04":26748.200000000004},{"2020-05":21090.5},{"2020-06":6060.400000000001},{"2020-07":11330.2},{"2020-08":15959.1},{"2020-09":22028.3},{"2020-10":20809.1},{"2020-11":6958},{"2020-12":15207.500000000004},{"2021-01":21877.8},{"2021-02":22737.2},{"2021-03":28586.999999999996},{"2021-04":2616.6000000000004}]},{"El Diputado":[{"2020-01":11072.1},{"2020-02":17728.699999999993},{"2020-03":19948.699999999997},{"2020-04":34181.200000000004},{"2020-05":6249.700000000003},{"2020-06":36182.09999999999},{"2020-07":83170.10000000002},{"2020-08":32862.5},{"2020-09":18840.900000000005},{"2020-10":25119.499999999996},{"2020-11":32234.499999999996},{"2020-12":41802.8},{"2021-01":38517.200000000004},{"2021-02":32849.49999999999},{"2021-03":32435.899999999998},{"2021-04":450.59999999999997}]},{"El Divisadero TG-1":[{"2020-01":120683.40000000001},{"2020-02":59645.399999999994},{"2020-03":30274.59999999999},{"2020-04":22667.999999999996},{"2020-05":41209.899999999994},{"2020-06":42156.80000000001},{"2020-07":51113.8},{"2020-08":27353.899999999998},{"2020-09":16929.3},{"2020-10":31286.4},{"2020-11":47812.3},{"2020-12":62135.1},{"2021-01":51187.4},{"2021-02":17956.8},{"2021-03":32445.200000000004},{"2021-04":6935.099999999999}]},{"El Divisadero TG-2":[{"2020-01":37376.899999999994},{"2020-02":83045.9},{"2020-03":27169.999999999996},{"2020-04":30737.899999999998},{"2020-05":50102.799999999996},{"2020-06":51289.8},{"2020-07":65029.90000000001},{"2020-08":15294.6},{"2020-09":18968.100000000002},{"2020-10":39338.600000000006},{"2020-11":63721.90000000001},{"2020-12":85422.20000000001},{"2021-01":56014.40000000001},{"2021-02":21070.600000000006},{"2021-03":43344},{"2021-04":8519.300000000001}]},{"El Retorno TG-1":[{"2020-01":36485},{"2020-02":30141},{"2020-03":25024},{"2020-04":36814},{"2020-05":45640},{"2020-06":40396},{"2020-07":33197},{"2020-08":9495},{"2020-09":21043.104000000003},{"2020-10":38521.087999999996},{"2020-11":52425.088},{"2020-12":49214.208},{"2021-01":17340.704},{"2021-02":24429.823999999997},{"2021-03":43452.28799999999},{"2021-04":8057.6}]},{"El Retorno TG-2":[{"2020-01":43167.700000000004},{"2020-02":45743.80000000002},{"2020-03":35395.4},{"2020-04":53539.20000000001},{"2020-05":68186.09999999999},{"2020-06":62464.900000000016},{"2020-07":48138.40000000001},{"2020-08":17594.600000000002},{"2020-09":29912.899999999998},{"2020-10":56820.2},{"2020-11":74189.40000000001},{"2020-12":79957.99999999999},{"2021-01":24336.6},{"2021-02":37242.7},{"2021-03":66879.19999999998},{"2021-04":11848.2}]},{"La Fiera":[{"2020-01":40978.1},{"2020-02":83635.5},{"2020-03":106509.19999999998},{"2020-04":58357.1},{"2020-05":82618.49999999997},{"2020-06":38185.19999999999},{"2020-07":80234.19999999998},{"2020-08":30571.399999999998},{"2020-09":94255.99999999997},{"2020-10":30226.2},{"2020-11":107482.19999999997},{"2020-12":52639},{"2021-01":124698.79999999999},{"2021-02":45789.799999999996},{"2021-03":105073.79999999997},{"2021-04":2921}]},{"La Liguana":[{"2020-01":2626.2000000000003},{"2020-02":7132.300000000001},{"2020-03":10376.6},{"2020-06":755.2},{"2020-07":154.9},{"2020-08":15566.800000000001},{"2020-09":9674.800000000001},{"2020-10":12531.4},{"2020-11":13207.4},{"2020-12":17493},{"2021-01":7556},{"2021-02":13820.199999999999},{"2021-03":11023.200000000003},{"2021-04":485.40000000000003}]},{"Las Brisas TG-1":[{"2020-01":27157.311999999994},{"2020-02":63185.2},{"2020-03":74272.79999999999},{"2020-04":69479.2},{"2020-05":21307.6},{"2020-06":28963.999999999996},{"2020-07":45383.20000000001},{"2020-08":55695.200000000004},{"2020-09":70831.59999999999},{"2020-10":22369.600000000006},{"2020-11":34365.600000000006},{"2020-12":62699.2},{"2021-01":74711.2},{"2021-02":76425.6},{"2021-03":45641.2},{"2021-04":3740.4}]},{"Las Brisas TG-2":[{"2020-01":16208.599999999999},{"2020-02":39507.4},{"2020-03":46279.60000000001},{"2020-04":43256.2},{"2020-05":10186.600000000002},{"2020-06":15108.199999999997},{"2020-07":25870.199999999997},{"2020-08":33671.799999999996},{"2020-09":44212.00000000001},{"2020-10":10269.4},{"2020-11":20188},{"2020-12":38145.200000000004},{"2021-01":46683.40000000001},{"2021-02":47787.99999999999},{"2021-03":27747.999999999996},{"2021-04":2056.7999999999997}]},{"Los Tatas TG-1":[{"2020-01":53516.09999999999},{"2020-02":71081.79999999999},{"2020-03":46831},{"2020-04":69604.1},{"2020-05":87746.29999999999},{"2020-06":79833.79999999999},{"2020-07":65110.299999999996},{"2020-08":16444.7},{"2020-09":37361.200000000004},{"2020-10":69388.7},{"2020-11":95850.10000000002},{"2020-12":111017.3},{"2021-01":34064.1},{"2021-02":43615.799999999996},{"2021-03":79664.4},{"2021-04":13788.4}]},{"Los Tatas TG-2":[{"2020-01":13730.199999999999},{"2020-02":19916.500000000004},{"2020-03":12746.599999999999},{"2020-04":18753.600000000002},{"2020-05":23941.800000000003},{"2020-06":22814.499999999996},{"2020-07":18917.899999999998},{"2020-08":6804.5},{"2020-09":11615.599999999999},{"2020-10":19202.699999999997},{"2020-11":25143.6},{"2020-12":28380.7},{"2021-01":9856.4},{"2021-02":12543.5},{"2021-03":21224.50000000001},{"2021-04":3695.9000000000005}]},{"Pozo 1 Rapel":[{"2020-01":21542.899999999998},{"2020-02":34874.99999999999},{"2020-03":35170.00000000001},{"2020-04":8402.1},{"2020-05":2798.7},{"2020-06":1417.0999999999997},{"2020-07":3230.6000000000004},{"2020-08":1340.5},{"2020-09":2621.7},{"2020-10":4667.800000000001},{"2020-11":2947.400000000001},{"2020-12":1302.8000000000002},{"2021-01":50562.6},{"2021-02":77276.59999999999},{"2021-03":99065.19999999998},{"2021-04":13304.9}]},{"Pozo 2 Rapel":[{"2020-01":18020.499999999996},{"2020-03":1631.0000000000002},{"2020-04":80509.30000000002},{"2020-05":93558.20000000001},{"2020-06":85147.8},{"2020-07":85152.60000000002},{"2020-08":77238.4},{"2020-09":92706.9},{"2020-10":91408.90000000001},{"2020-11":100545.90000000001},{"2020-12":108514.00000000001},{"2021-01":54014.69999999998},{"2021-02":744.6999999999999},{"2021-03":1166.0000000000005},{"2021-04":46.199999999999996}]},{"Pozo R1":[{"2020-01":1936.1000000000004},{"2020-02":4387.6},{"2020-03":1974.2000000000003},{"2020-04":3563.999999999999},{"2020-05":7131.500000000001},{"2020-06":4622.5999999999985},{"2020-07":3962.9},{"2020-08":3249.0999999999995},{"2020-09":3254.7000000000003},{"2020-10":4765.4},{"2020-11":5129.900000000001},{"2020-12":2451.0999999999995},{"2021-01":3529.7999999999997},{"2021-02":1630.3999999999999},{"2021-03":3072.7},{"2021-04":1155.5}]},{"Pozo R2":[{"2020-01":2208.6},{"2020-02":3571.0000000000005},{"2020-10":2155.6000000000004},{"2020-11":4231.9},{"2020-12":4428},{"2021-01":5212.999999999999},{"2021-02":5901.500000000001},{"2021-03":7300.100000000001},{"2021-04":961.5}]},{"Rapel TG-1":[{"2020-01":79726.20000000001},{"2020-02":107689.09999999998},{"2020-03":114468.19999999998},{"2020-04":112838.1},{"2020-05":108648.10000000003},{"2020-06":92438.39999999997},{"2020-07":101558.69999999998},{"2020-08":15719.999999999998},{"2020-09":560.0000000000001},{"2020-10":647.9000000000001},{"2020-11":3064.6000000000004},{"2020-12":882.6000000000003},{"2021-01":2.4},{"2021-02":0.1},{"2021-03":4.1},{"2021-04":0}]},{"Rapel TG-2":[{"2020-01":49915.3},{"2020-02":83826.19999999998},{"2020-03":5767.4},{"2020-08":27161.9},{"2020-09":157411.80000000002},{"2020-10":159209.1},{"2020-11":164225.6},{"2020-12":179808.89999999997},{"2021-01":183043.2},{"2021-02":140597.19999999998},{"2021-03":189842.4},{"2021-04":24708.8}]}]'
            ,true);
    }
}
