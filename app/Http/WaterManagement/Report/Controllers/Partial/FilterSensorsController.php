<?php

namespace App\Http\WaterManagement\Report\Controllers\Partial;

use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Domain\WaterManagement\Report\MailReport;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class FilterSensorsController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = Sensor::with([
            'device.sub_element.element.sub_zone',
            'device.check_point.type'
        ]);
        $subZones = explode(',',$request->sub_zones);
        $checkPoints = explode(',',$request->check_points);
        $types = explode(',',$request->types);
        $address = explode(',',$request->address);



        if(count($types) > 0 && $types[0] != ''){
            $query = $this->filterTypes($query,$types);
        }

        if(count($address) > 0  && $types[0] != '' ){
            $query = $this->filterAddress($query,$types);
        }

        if(count($checkPoints) > 0  && $checkPoints[0] != '' ){
            $query = $this->filterCheckPoints($query,$checkPoints);
        }

        if(count($subZones) > 0  && $subZones[0] != '' ){
            $query = $this->filterSubZone($query,$subZones);
        }
        $mr = MailReport::with('sensors')
            ->find($request->mail_report);
        if($mr) {
            $selected_sensors = $mr->sensors()
                ->pluck('id')
                ->toArray();
            $sensors = $query->orWhereIn('id',$selected_sensors)->get();
        } else {
            $sensors = $query->get();
        }



        return view('water-management.report.sensor-list',compact('sensors'));
    }

    protected function filterTypes($query,$types)
    {
        return $query->whereIn('type_id',$types);
    }

    protected function filterAddress($query,$address)
    {
        return $query->whereIn('address_id',$address);
    }

    protected function filterCheckPoints($query,$checkPoints)
    {
        return $query->whereHas('device', function($q) use($checkPoints){
            return $q->whereHas('check_point', function($q) use($checkPoints){
                return $q->whereIn('type_id',$checkPoints);
            });
        });
    }

    protected function filterSubZone($query,$sub_zones)
    {
        return $query->whereHas('device', function($q) use($sub_zones){
            return $q->whereHas('sub_element', function($q) use($sub_zones){
                return $q->whereHas('element',function($q) use($sub_zones){
                    return $q->whereIn('sub_zone_id',$sub_zones);
                });
            });
        });
    }
}
