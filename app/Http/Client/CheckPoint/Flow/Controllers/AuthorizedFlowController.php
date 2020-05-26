<?php

namespace App\Http\Client\CheckPoint\Flow\Controllers;

use App\Domain\Client\CheckPoint\Flow\CheckPointAuthorizedFlow;
use App\Domain\Client\CheckPoint\Flow\CheckPointFlow;
use App\Domain\WaterManagement\Device\Device;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class AuthorizedFlowController extends Controller
{
    public function index()
    {
        $devices = Device::with([
            'check_point.sub_zones.zone',
            'check_point.authorized_flow',
            'sensors'
        ])->whereHas('sensors', function($q){
            return $q->sensorType('tx-caudal');
        })->get();

        return view('client.check-point.flow.index',compact('devices'));
    }

    public function store(Request $request)
    {
        $i = 0;
        foreach($request->check_points as $check_point) {

            if($request->flows[$i] != '') {
                $flow = CheckPointAuthorizedFlow::updateOrCreate(['check_point_id' => $check_point],[
                    'authorized_flow' => $request->flows[$i]
                ]);
                addChangeLog('Caudal autorizado Modificado/Agregado','check_point_authorized_flows',$flow);
            }
            $i++;
        }
       return response()->json(['success' => 'Caudales guardados correctamente']);
    }
}
