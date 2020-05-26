<?php

namespace App\Http\WaterManagement\Admin\Panel;

use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\Zone\Sub\SubZoneElement;
use App\Domain\Client\Zone\Sub\SubZoneSubElement;
use App\Domain\WaterManagement\Device\Device;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class PanelColumnController extends Controller
{
    public function changeColumnName(Request $request)
    {
        $index = explode('_',$request->column);
        $element = SubZoneElement::where('sub_zone_id',$index[2])
                                ->where('column',$index[3])
                                ->first();
        $element->name = $request->name;
        $element->save();
    }

    public function updateItems(Request $request)
    {
        $index = explode('_',$request->group);

        $element = SubZoneElement::where('sub_zone_id',$index[1])
            ->where('column',$index[2])
            ->first();
        $i = 0;
        foreach(explode(',',$request->items) as $item) {
            if($item != '') {
                $check_point = CheckPoint::with('devices')->find(explode('_',$item)[1]);
                foreach($check_point->devices as $device) {
                    $element->sub_elements()->updateOrCreate(['device_id' => $device->id],['position' => $i,'check_point_id' => $check_point->id]);
                    $i++;
                }


            }

        }

    }

    public function removeSubElement($sub_element)
    {
        if(SubZoneSubElement::destroy($sub_element)) {
            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
