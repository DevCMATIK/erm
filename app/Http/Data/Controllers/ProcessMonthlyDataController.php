<?php

namespace App\Http\Data\Controllers;

use App\App\Traits\Dates\DateUtilitiesTrait;
use App\Domain\WaterManagement\Device\Device;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Illuminate\Support\Arr;

class ProcessMonthlyDataController extends Controller
{
     use DateUtilitiesTrait;

    public function index(Request $request)
    {
        $devices = Device::with('data_checks', 'check_point.sub_zones','sensors.average')->get();
        return view('data.index', compact('devices'));
    }

    protected function syncDevices()
    {
        $devices = Device::with(['data_checks','sensors.address'])->get();
        $months = collect($this->monthsBetween('2019-01-01'))->flip();

        foreach($devices as $device) {
            if(isset($device->data_checks) && count($device->data_checks) > 0) {
                foreach($months as $month => $value) {
                    foreach($device->sensors as $sensor) {
                        if(!$device->data_checks()->where('address',$sensor->full_address)->where('month',$month)->first()) {
                            $device->data_checks()->create([
                                'check' => 0,
                                'month' => $month,
                                'address' => $sensor->full_address,
                            ]);
                        }
                    }
                }
            } else {
                foreach($months as $month => $value){
                    foreach($device->sensors as $sensor) {
                        $device->data_checks()->create([
                            'check' => 0,
                            'month' => $month,
                            'address' => $sensor->full_address,
                        ]);
                    }
                }
            }
        }

        return back()->with('success','Se han sincronizado los dispositivos');

    }


}
