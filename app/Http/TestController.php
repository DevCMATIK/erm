<?php

namespace App\Http;

use App\App\Controllers\Controller;
use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\Client\Zone\Zone;
use App\Domain\System\User\User;
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

        $consumptions = collect(json_decode($this->getJson(),true));

        foreach($consumptions as $consumption)
        {
            dd(collect($consumption[key($consumption)]['monthly'])->where('month','2020-06')->first()['consumption']);

        }


        $time_end = microtime(true);

        $execution_time = ($time_end - $time_start);

        dd($consumptions,$execution_time);

    }

    public function getJson()
    {
        return '[{"Pozo 1 Rapel":{"this-year":{"consumption":52813141.199999996,"year":2020},"monthly":[{"consumption":21542.899999999998,"month":"2020-01"},{"consumption":34874.99999999999,"month":"2020-02"},{"consumption":35170.00000000001,"month":"2020-03"},{"consumption":8402.1,"month":"2020-04"},{"consumption":2798.7,"month":"2020-05"},{"consumption":1417.0999999999997,"month":"2020-06"},{"consumption":3230.6000000000004,"month":"2020-07"},{"consumption":1340.5,"month":"2020-08"},{"consumption":2621.7,"month":"2020-09"},{"consumption":52698569.800000004,"month":"2020-10"},{"consumption":2947.400000000001,"month":"2020-11"},{"consumption":225.4,"month":"2020-12"}],"this-month":{"consumption":225.4,"month":"2020-12"},"yesterday":87.4,"today":25.8}},{"Pozo 2 Rapel":{"this-year":{"consumption":736213.1999999998,"year":2020},"monthly":[{"consumption":18020.499999999996,"month":"2020-01"},{"consumption":1631.0000000000002,"month":"2020-03"},{"consumption":80509.30000000002,"month":"2020-04"},{"consumption":93558.20000000001,"month":"2020-05"},{"consumption":85147.8,"month":"2020-06"},{"consumption":85152.60000000002,"month":"2020-07"},{"consumption":77238.4,"month":"2020-08"},{"consumption":92706.9,"month":"2020-09"},{"consumption":91408.90000000001,"month":"2020-10"},{"consumption":100545.90000000001,"month":"2020-11"},{"consumption":10293.7,"month":"2020-12"}],"this-month":{"consumption":10293.7,"month":"2020-12"},"yesterday":3403.4,"today":"1,509.20"}},{"El Diputado":{"this-year":{"consumption":317954.8999999999,"year":2020},"monthly":[{"consumption":11072.1,"month":"2020-01"},{"consumption":17728.699999999993,"month":"2020-02"},{"consumption":19948.699999999997,"month":"2020-03"},{"consumption":34181.200000000004,"month":"2020-04"},{"consumption":6249.700000000003,"month":"2020-05"},{"consumption":36182.09999999999,"month":"2020-06"},{"consumption":83170.10000000002,"month":"2020-07"},{"consumption":32862.5,"month":"2020-08"},{"consumption":18840.900000000005,"month":"2020-09"},{"consumption":25119.499999999996,"month":"2020-10"},{"consumption":32234.499999999996,"month":"2020-11"},{"consumption":364.9,"month":"2020-12"}],"this-month":{"consumption":364.9,"month":"2020-12"},"yesterday":22,"today":8.5}},{"Don Sata TG-1":{"this-year":{"consumption":717209.9999999997,"year":2020},"monthly":[{"consumption":25131.2,"month":"2020-01"},{"consumption":77455.60000000002,"month":"2020-02"},{"consumption":104999.19999999998,"month":"2020-03"},{"consumption":108775.2,"month":"2020-04"},{"consumption":83374.00000000003,"month":"2020-05"},{"consumption":20322.800000000003,"month":"2020-06"},{"consumption":39091.99999999999,"month":"2020-07"},{"consumption":56980.799999999996,"month":"2020-08"},{"consumption":84859.99999999999,"month":"2020-09"},{"consumption":88413.2,"month":"2020-10"},{"consumption":23879.199999999997,"month":"2020-11"},{"consumption":3926.8,"month":"2020-12"}],"this-month":{"consumption":3926.8,"month":"2020-12"},"yesterday":1676,"today":338}},{"Don Sata TG-2":{"this-year":{"consumption":182587.00000000006,"year":2020},"monthly":[{"consumption":6422.999999999999,"month":"2020-01"},{"consumption":18471.4,"month":"2020-02"},{"consumption":25695.4,"month":"2020-03"},{"consumption":26748.200000000004,"month":"2020-04"},{"consumption":21090.5,"month":"2020-05"},{"consumption":6060.400000000001,"month":"2020-06"},{"consumption":11330.2,"month":"2020-07"},{"consumption":15959.1,"month":"2020-08"},{"consumption":22028.3,"month":"2020-09"},{"consumption":20809.1,"month":"2020-10"},{"consumption":6958,"month":"2020-11"},{"consumption":1013.4000000000001,"month":"2020-12"}],"this-month":{"consumption":1013.4000000000001,"month":"2020-12"},"yesterday":435.8,"today":95.5}},{"Los Tatas TG-1":{"this-year":{"consumption":703245.2999999998,"year":2020},"monthly":[{"consumption":53516.09999999999,"month":"2020-01"},{"consumption":71081.79999999999,"month":"2020-02"},{"consumption":46831,"month":"2020-03"},{"consumption":69604.1,"month":"2020-04"},{"consumption":87746.29999999999,"month":"2020-05"},{"consumption":79833.79999999999,"month":"2020-06"},{"consumption":65110.299999999996,"month":"2020-07"},{"consumption":16444.7,"month":"2020-08"},{"consumption":37361.200000000004,"month":"2020-09"},{"consumption":69388.7,"month":"2020-10"},{"consumption":95850.10000000002,"month":"2020-11"},{"consumption":10477.2,"month":"2020-12"}],"this-month":{"consumption":10477.2,"month":"2020-12"},"yesterday":3900.6,"today":"1,370.20"}},{"Los Tatas TG-2":{"this-year":{"consumption":196307.0999999999,"year":2020},"monthly":[{"consumption":13730.199999999999,"month":"2020-01"},{"consumption":19916.500000000004,"month":"2020-02"},{"consumption":12746.599999999999,"month":"2020-03"},{"consumption":18753.600000000002,"month":"2020-04"},{"consumption":23941.800000000003,"month":"2020-05"},{"consumption":22814.499999999996,"month":"2020-06"},{"consumption":18917.899999999998,"month":"2020-07"},{"consumption":6804.5,"month":"2020-08"},{"consumption":11615.599999999999,"month":"2020-09"},{"consumption":19202.699999999997,"month":"2020-10"},{"consumption":25143.6,"month":"2020-11"},{"consumption":2719.6000000000004,"month":"2020-12"}],"this-month":{"consumption":2719.6000000000004,"month":"2020-12"},"yesterday":1015.2,"today":354.2}},{"La Liguana":{"this-year":{"consumption":72637.00000000001,"year":2020},"monthly":[{"consumption":2626.2000000000003,"month":"2020-01"},{"consumption":7132.300000000001,"month":"2020-02"},{"consumption":10376.6,"month":"2020-03"},{"consumption":755.2,"month":"2020-06"},{"consumption":154.9,"month":"2020-07"},{"consumption":15566.800000000001,"month":"2020-08"},{"consumption":9674.800000000001,"month":"2020-09"},{"consumption":12531.4,"month":"2020-10"},{"consumption":13207.4,"month":"2020-11"},{"consumption":611.4,"month":"2020-12"}],"this-month":{"consumption":611.4,"month":"2020-12"},"yesterday":299.2,"today":100.3}},{"Pozo R1":{"this-year":{"consumption":44203.39999999997,"year":2020},"monthly":[{"consumption":1936.1000000000004,"month":"2020-01"},{"consumption":4387.6,"month":"2020-02"},{"consumption":1974.2000000000003,"month":"2020-03"},{"consumption":3563.999999999999,"month":"2020-04"},{"consumption":7131.500000000001,"month":"2020-05"},{"consumption":4622.5999999999985,"month":"2020-06"},{"consumption":3962.9,"month":"2020-07"},{"consumption":3249.0999999999995,"month":"2020-08"},{"consumption":3254.7000000000003,"month":"2020-09"},{"consumption":4765.4,"month":"2020-10"},{"consumption":5129.900000000001,"month":"2020-11"},{"consumption":225.39999999999998,"month":"2020-12"}],"this-month":{"consumption":225.39999999999998,"month":"2020-12"},"yesterday":87.5,"today":26.3}},{"Pozo R2":{"this-year":{"consumption":12454.599999999997,"year":2020},"monthly":[{"consumption":2208.6,"month":"2020-01"},{"consumption":3571.0000000000005,"month":"2020-02"},{"consumption":2155.6000000000004,"month":"2020-10"},{"consumption":4231.9,"month":"2020-11"},{"consumption":287.5,"month":"2020-12"}],"this-month":{"consumption":287.5,"month":"2020-12"},"yesterday":106.2,"today":10.3}},{"Castrol TG-1":{"this-year":{"consumption":671.4410000000001,"year":2020},"monthly":[{"consumption":43.284000000000006,"month":"2020-01"},{"consumption":83.00100000000002,"month":"2020-02"},{"consumption":101.764,"month":"2020-03"},{"consumption":99.00099999999999,"month":"2020-04"},{"consumption":25.133000000000003,"month":"2020-05"},{"consumption":28.072000000000003,"month":"2020-06"},{"consumption":54.522,"month":"2020-07"},{"consumption":72.162,"month":"2020-08"},{"consumption":92.40099999999998,"month":"2020-09"},{"consumption":30.906000000000002,"month":"2020-10"},{"consumption":36.11699999999999,"month":"2020-11"},{"consumption":5.077999999999999,"month":"2020-12"}],"this-month":{"consumption":5.077999999999999,"month":"2020-12"},"yesterday":2.092,"today":0.48}},{"Castrol TG-2":{"this-year":{"consumption":711.5219999999993,"year":2020},"monthly":[{"consumption":454.4820000000001,"month":"2020-01"},{"consumption":35.259,"month":"2020-02"},{"consumption":42.55399999999999,"month":"2020-03"},{"consumption":39.952999999999996,"month":"2020-04"},{"consumption":8.815000000000001,"month":"2020-05"},{"consumption":10.917000000000002,"month":"2020-06"},{"consumption":22.442999999999994,"month":"2020-07"},{"consumption":30.98900000000001,"month":"2020-08"},{"consumption":39.065000000000005,"month":"2020-09"},{"consumption":10.101,"month":"2020-10"},{"consumption":14.791999999999996,"month":"2020-11"},{"consumption":2.152,"month":"2020-12"}],"this-month":{"consumption":2.152,"month":"2020-12"},"yesterday":0.9,"today":0.2}},{"La Fiera":{"this-year":{"consumption":753689.6000000001,"year":2020},"monthly":[{"consumption":40978.1,"month":"2020-01"},{"consumption":83635.5,"month":"2020-02"},{"consumption":106509.19999999998,"month":"2020-03"},{"consumption":58357.1,"month":"2020-04"},{"consumption":82618.49999999997,"month":"2020-05"},{"consumption":38185.19999999999,"month":"2020-06"},{"consumption":80234.19999999998,"month":"2020-07"},{"consumption":30571.399999999998,"month":"2020-08"},{"consumption":94255.99999999997,"month":"2020-09"},{"consumption":30226.2,"month":"2020-10"},{"consumption":107482.19999999997,"month":"2020-11"},{"consumption":636,"month":"2020-12"}],"this-month":{"consumption":636,"month":"2020-12"},"yesterday":92.8,"today":48}},{"Rapel TG-1 (A\u00e9reo)":{"this-year":{"consumption":738218.3999999994,"year":2020},"monthly":[{"consumption":79726.20000000001,"month":"2020-01"},{"consumption":107689.09999999998,"month":"2020-02"},{"consumption":114468.19999999998,"month":"2020-03"},{"consumption":112838.1,"month":"2020-04"},{"consumption":108648.10000000003,"month":"2020-05"},{"consumption":92438.39999999997,"month":"2020-06"},{"consumption":101558.69999999998,"month":"2020-07"},{"consumption":15719.999999999998,"month":"2020-08"},{"consumption":560.0000000000001,"month":"2020-09"},{"consumption":647.9000000000001,"month":"2020-10"},{"consumption":3064.6000000000004,"month":"2020-11"},{"consumption":859.1,"month":"2020-12"}],"this-month":{"consumption":859.1,"month":"2020-12"},"yesterday":0,"today":0}},{"Rapel TG-2 (Terrestre)":{"this-year":{"consumption":663966.4999999998,"year":2020},"monthly":[{"consumption":49915.3,"month":"2020-01"},{"consumption":83826.19999999998,"month":"2020-02"},{"consumption":5767.4,"month":"2020-03"},{"consumption":27161.9,"month":"2020-08"},{"consumption":157411.80000000002,"month":"2020-09"},{"consumption":159209.1,"month":"2020-10"},{"consumption":164225.6,"month":"2020-11"},{"consumption":16449.2,"month":"2020-12"}],"this-month":{"consumption":16449.2,"month":"2020-12"},"yesterday":5694.2,"today":"2,541.60"}},{"Las Brisas TG-1":{"this-year":{"consumption":2357859.9700000025,"year":2020},"monthly":[{"consumption":1867057.57,"month":"2020-01"},{"consumption":63185.2,"month":"2020-02"},{"consumption":74272.79999999999,"month":"2020-03"},{"consumption":69479.2,"month":"2020-04"},{"consumption":21307.6,"month":"2020-05"},{"consumption":28963.999999999996,"month":"2020-06"},{"consumption":45383.20000000001,"month":"2020-07"},{"consumption":55695.200000000004,"month":"2020-08"},{"consumption":70831.59999999999,"month":"2020-09"},{"consumption":22369.600000000006,"month":"2020-10"},{"consumption":34365.600000000006,"month":"2020-11"},{"consumption":4948.4,"month":"2020-12"}],"this-month":{"consumption":4948.4,"month":"2020-12"},"yesterday":1986,"today":521.2}},{"Las Brisas TG-2":{"this-year":{"consumption":307846.0000000002,"year":2020},"monthly":[{"consumption":16208.599999999999,"month":"2020-01"},{"consumption":39507.4,"month":"2020-02"},{"consumption":46279.60000000001,"month":"2020-03"},{"consumption":43256.2,"month":"2020-04"},{"consumption":10186.600000000002,"month":"2020-05"},{"consumption":15108.199999999997,"month":"2020-06"},{"consumption":25870.199999999997,"month":"2020-07"},{"consumption":33671.799999999996,"month":"2020-08"},{"consumption":44212.00000000001,"month":"2020-09"},{"consumption":10269.4,"month":"2020-10"},{"consumption":20188,"month":"2020-11"},{"consumption":3088,"month":"2020-12"}],"this-month":{"consumption":3088,"month":"2020-12"},"yesterday":1267.2,"today":330.4}},{"El Retorno TG-1":{"this-year":{"consumption":492835.86699999997,"year":2020},"monthly":[{"consumption":36.485,"month":"2020-01"},{"consumption":30.141,"month":"2020-02"},{"consumption":25.024000000000004,"month":"2020-03"},{"consumption":36.814,"month":"2020-04"},{"consumption":45.640000000000015,"month":"2020-05"},{"consumption":40.395999999999994,"month":"2020-06"},{"consumption":33.197,"month":"2020-07"},{"consumption":9.495000000000001,"month":"2020-08"},{"consumption":395880.94700000004,"month":"2020-09"},{"consumption":38521.087999999996,"month":"2020-10"},{"consumption":52425.088,"month":"2020-11"},{"consumption":5751.552,"month":"2020-12"}],"this-month":{"consumption":5751.552,"month":"2020-12"},"yesterday":2136.192,"today":693.7}},{"El Retorno TG-2":{"this-year":{"consumption":717701.5999999996,"year":2020},"monthly":[{"consumption":25622.8,"month":"2020-01"},{"consumption":77455.60000000002,"month":"2020-02"},{"consumption":104999.19999999998,"month":"2020-03"},{"consumption":108775.2,"month":"2020-04"},{"consumption":83374.00000000003,"month":"2020-05"},{"consumption":20322.800000000003,"month":"2020-06"},{"consumption":39091.99999999999,"month":"2020-07"},{"consumption":56980.799999999996,"month":"2020-08"},{"consumption":84859.99999999999,"month":"2020-09"},{"consumption":88413.2,"month":"2020-10"},{"consumption":23879.199999999997,"month":"2020-11"},{"consumption":3926.8,"month":"2020-12"}],"this-month":{"consumption":3926.8,"month":"2020-12"},"yesterday":1676,"today":338}},{"El Divisadero TG-1":{"this-year":{"consumption":496581.9000000002,"year":2020},"monthly":[{"consumption":120683.40000000001,"month":"2020-01"},{"consumption":59645.399999999994,"month":"2020-02"},{"consumption":30274.59999999999,"month":"2020-03"},{"consumption":22667.999999999996,"month":"2020-04"},{"consumption":41209.899999999994,"month":"2020-05"},{"consumption":42156.80000000001,"month":"2020-06"},{"consumption":51113.8,"month":"2020-07"},{"consumption":27353.899999999998,"month":"2020-08"},{"consumption":16929.3,"month":"2020-09"},{"consumption":31286.4,"month":"2020-10"},{"consumption":47812.3,"month":"2020-11"},{"consumption":5448.1,"month":"2020-12"}],"this-month":{"consumption":5448.1,"month":"2020-12"},"yesterday":2084.3,"today":691.4}},{"El Divisadero TG-2":{"this-year":{"consumption":489618.5000000001,"year":2020},"monthly":[{"consumption":37376.899999999994,"month":"2020-01"},{"consumption":83045.9,"month":"2020-02"},{"consumption":27169.999999999996,"month":"2020-03"},{"consumption":30737.899999999998,"month":"2020-04"},{"consumption":50102.799999999996,"month":"2020-05"},{"consumption":51289.8,"month":"2020-06"},{"consumption":65029.90000000001,"month":"2020-07"},{"consumption":15294.6,"month":"2020-08"},{"consumption":18968.100000000002,"month":"2020-09"},{"consumption":39338.600000000006,"month":"2020-10"},{"consumption":63721.90000000001,"month":"2020-11"},{"consumption":7542.1,"month":"2020-12"}],"this-month":{"consumption":7542.1,"month":"2020-12"},"yesterday":2824.1,"today":930.7}}]';
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
