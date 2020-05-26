<?php

namespace App\Http\WaterManagement\Report\Controllers;

use App\Domain\WaterManagement\Report\MailReport;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class SensorsSerializeController extends Controller
{
    public function index($id)
    {
        $mailReport = MailReport::with(['sensors' => function($q){
            return $q->orderBy('pivot_position');
        }, 'sensors.device.sub_element.element.sub_zone'])->find($id);

        return view('water-management.report.serialize',compact('mailReport'));

    }

    public function serialize(Request $request,$id)
    {
        $sensors = json_decode($request->sensors,true);
        $mail_report = MailReport::with('sensors')->find($id);
        $i = 1;
        $ss = array();
        foreach($sensors as $s) {
            $mail_report->sensors()->updateExistingPivot($s['id'], ['position' => $i]);
            $i++;
        }
        return response()->json(['success' => 'Sensores Serializados correctamente.']);
    }
}
