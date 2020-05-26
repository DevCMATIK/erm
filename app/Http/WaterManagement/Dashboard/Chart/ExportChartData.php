<?php

namespace App\Http\WaterManagement\Dashboard\Chart;

use App\Domain\Data\Export\ExportReminder;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Exports\ExportChartDataWithSheets;
use App\Http\Data\Jobs\Export\CreateFileForSensor;
use App\Http\Data\Jobs\Export\ExportDataBySensor;
use App\Http\Data\Jobs\Export\SendMailExportCompleted;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Sentinel;

class ExportChartData extends Controller
{
    public function __invoke(Request $request,$device_id,$sensor_id)
    {
        $s = array($sensor_id);
        if($request->has('sensors')) {
            $ss = array_merge($s,array_unique($request->sensors));
        } else {
            $ss = $s;
        }
        $sensors  = Sensor::with([
            'type',
            'device.check_point'
        ])->whereIn('id',$ss)->get();

        $dates = explode(' ',$request->dates);
        $from = date($dates[0]);
        $to = date($dates[2]);
        $from = Carbon::parse($from)->startOfDay();  //2016-09-29 00:00:00.000000
        $to = Carbon::parse($to)->endOfDay();

        if($to->diffInDays($from) > 30 || count($sensors) >= 5) {
            $reminder = ExportReminder::create([
                'user_id' => Sentinel::getUser()->id,
                'sensors' => $sensors->pluck('id')->implode(','),
                'from' => $from,
                'to' => $to,
                'creation_date' => Carbon::now()->toDateTimeString(),
                'expires_at' => Carbon::tomorrow()->toDateString()
            ]);
            $user_id = Sentinel::getUser()->id;
            $jobs = $sensors->map(function($item) use($from,$to,$user_id,$reminder){
                return new CreateFileForSensor($item,$from,$to,$user_id,$reminder);
            })->toArray();
            ExportDataBySensor::withChain(
                array_merge(
                    $jobs,
                    [ new SendMailExportCompleted(Sentinel::getUser(),$reminder)]
                )
            )->dispatch()
                ->allOnQueue('exports-queue');
            return response()->json(['success' => 'Export Started'],200);
        } else {
            $fileName = $sensors->first()->device->check_point->name.'.xlsx';
            if(strlen($fileName) > 31) {
                $fileName = substr($sensors->first()->device->check_point->name,'0','20').'.xlsx';
            }
            return (new ExportChartDataWithSheets($device_id,$sensors,$request->dates))
                ->download($fileName);
        }

    }
}
