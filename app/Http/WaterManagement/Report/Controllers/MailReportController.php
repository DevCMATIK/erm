<?php

namespace App\Http\WaterManagement\Report\Controllers;

use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\CheckPoint\Type\CheckPointType;
use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\Client\Zone\Zone;
use App\Domain\System\Mail\Mail;
use App\Domain\WaterManagement\Device\Address\Address;
use App\Domain\WaterManagement\Device\Sensor\Type\SensorType;
use App\Domain\WaterManagement\Group\Group;
use App\Domain\WaterManagement\Report\MailReport;
use App\Http\WaterManagement\Report\Request\MailReportRequest;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Sentinel;


class MailReportController extends Controller
{
    public function index()
    {
        return view('water-management.report.index');
    }

    public function create()
    {
        $groups = Group::get();
        $sub_zones = SubZone::get();
        $zones = Zone::with('sub_zones')->get();
        $checkPoints = CheckPointType::get();
        $sensor_types = SensorType::get();
        $mails = Mail::where('share_with_all',1)->orWhere('user_id',Sentinel::getUser()->id)->get();
        $addresses = Address::get();
        return view('water-management.report.create',compact('groups','sub_zones','zones','sensor_types','mails','addresses','checkPoints'));
    }

    public function store(MailReportRequest $request)
    {
        if($mailReport = MailReport::create(
            array_merge($request->all(),[
                'is_active' => 1,
                'user_id' => Sentinel::getUser()->id
            ])
        )) {
            if(!$request->has('group_id')) {
                $mailReport->delete();
                return response()->json(['error' => 'No ha Seleccionado grupos'],401);
            } else {
                if(!$request->has('sensor_id')) {
                    $mailReport->delete();
                    return response()->json(['error' => 'No ha Seleccionado Sensores'],401);
                } else {
                    $mailReport->groups()->attach($request->group_id);
                    $mailReport->sensors()->attach($request->sensor_id);
                    return $this->getResponse('success.store');
                }
            }


        } else {
            return $this->getResponse('error.store');
        }
    }

    public function edit($id){
        $groups = Group::get();
        $sub_zones = SubZone::get();
        $zones = Zone::with('sub_zones')->get();
        $checkPoints = CheckPointType::get();
        $sensor_types = SensorType::get();
        $mails = Mail::where('share_with_all',1)->orWhere('user_id',Sentinel::getUser()->id)->get();
        $addresses = Address::get();
        $mailReport = MailReport::with([
            'sensors.device.sub_element.element.sub_zone',
            'sensors.device.check_point.type'
        ])->find($id);
        return view('water-management.report.edit',compact('mailReport','groups','sub_zones','zones','sensor_types','mails','addresses','checkPoints'));

    }

    public function update(MailReportRequest $request,$id)
    {
        $mailReport = MailReport::find($id);
        if($mailReport->update(
            array_merge($request->all(),[
                'is_active' => 1,
                'user_id' => Sentinel::getUser()->id
            ])
        )) {
            if(!$request->has('group_id')) {
                return response()->json(['error' => 'No ha Seleccionado grupos'],401);
            } else {
                if(!$request->has('sensor_id')) {
                    return response()->json(['error' => 'No ha Seleccionado Sensores'],401);
                } else {
                    $mailReport->groups()->sync($request->group_id);
                    $mailReport->sensors()->sync($request->sensor_id);
                    return $this->getResponse('success.update');
                }
            }


        } else {
            return $this->getResponse('error.update');
        }
    }

    public function destroy($id)
    {
        $mailReport = MailReport::find($id);
        if($mailReport->delete()) {
            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
