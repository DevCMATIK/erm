<?php

namespace App\Http\Watermanagement\Dashboard\Chart;

use App\Domain\Data\Export\ExportReminder;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Exports\ExportChartDataWithSheets;
use App\Http\Data\Export\ExportDataWithBox;
use App\Http\Data\Jobs\Export\CreateFileForSensor;
use App\Http\Data\Jobs\Export\ExportDataBySensor;
use App\Http\Data\Jobs\Export\SendMailExportCompleted;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Sentinel;

class ExportDataTotal extends Controller
{
    public function __invoke(Request $request)
    {

        $ss = array_unique($request->sensors);

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
            return back()->withSuccess('Export started!');
        } else {
            return (new \App\Exports\ExportDataTotal($sensors,$request->dates))
                ->download('Data-'.Carbon::today()->toDateString().'.xlsx');
        }

    }
}
