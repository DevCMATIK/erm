<?php

namespace App\App\Jobs\DGA;

use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\CheckPoint\DGA\CheckPointReport;
use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RestoreReports implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $checkpoint;

    public function __construct(CheckPoint $checkPoint)
    {
        $this->checkpoint = $checkPoint;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $reports = CheckPointReport::where('check_point_id',$this->checkpoint->id)
            ->where('response',0)->whereRaw("report_date between '2021-06-10 00:00:00' and '2021-06-10 23:59:00'")->get()->groupBy(function($item){
                return Carbon::parse($item->report_date)->format('Y-m-d');
            })->filter(function($item) {
                return count($item) < 24;
            });
        $missing = array();
        $sensors = $this->getSensors($this->checkpoint->id);

        foreach($reports as $day => $report)
        {
            $report_day = array();
            for ($i = 1;$i<25;$i++) {
                $hour = str_pad($i,2,"0",STR_PAD_LEFT);
                if(!$report
                    ->where(
                        'report_date',
                        '>=',
                        $day.' '.$hour.':00:00'
                    )->where(
                        'report_date',
                        '<=',
                        $day .' '.$hour.':59:59'
                    )->first()) {
                    array_push($report_day,[
                        'start_hour' => $hour.':00:00',
                        'end_hour' => $hour.':59:59'
                    ]);
                }
            }
            array_push($missing,[$day => $report_day]);
        }

        $dates =collect($missing)->map(function($item,$key){
            return array_keys($item);
        })->collapse();

        $first_date = collect($dates)->first();
        $last_date = collect(array_reverse($dates->toArray()))->first();

        if($first_date && $last_date) {
            $analogous_reports = AnalogousReport::whereIn('sensor_id',$sensors->pluck('id')->toArray())
                ->whereRaw("date between '{$first_date} 00:00:00' and '{$last_date} 23:59:00'")->get();

            $toRestore = array();
            foreach($missing as  $miss) {
                foreach($miss as $day => $items) {
                    $values = array();
                    foreach($items as $hours) {
                        $start_date = $day.' '.$hours['start_hour'];
                        $end_date = $day.' '.$hours['end_hour'];
                        array_push($values, [
                            'work_code' => $this->checkpoint->work_code,
                            'tote' => $analogous_reports->where('sensor_id',$this->getToteSensor($sensors)->id)
                                    ->where("date", '>=',$start_date)->where('date','<=',$end_date)
                                    ->first()->result ?? 0,
                            'flow' => $analogous_reports->where('sensor_id',$this->getFlowSensor($sensors)->id)
                                    ->where("date", '>=',$start_date)->where('date','<=',$end_date)
                                    ->first()->result ?? 0,
                            'level' => $analogous_reports->where('sensor_id',$this->getLevelSensor($sensors)->id)
                                    ->where("date", '>=',$start_date)->where('date','<=',$end_date)
                                    ->first()->result ?? 0,
                            'hour' => $start_date
                        ]);
                    }
                    array_pop($values);
                    array_push($toRestore,[$day => $values]);
                }
            }
            foreach($toRestore as $rests) {
                foreach($rests as $day => $items) {
                    foreach($items as $item) {
                        $date = $item['hour'];
                        RestoreToDGA::dispatch($item['tote'],$item['flow'],$item['level'],$item['work_code'],$this->checkpoint,$date)->onQueue('long-running-queue-low');
                    }
                }
            }
        }


    }

    protected function getSensors($checkPoint)
    {
        return $this->getSensorsByCheckPoint($checkPoint)
            ->whereIn('type_id',function($query){
                $query->select('id')->from('sensor_types')
                    ->where('is_dga',1)
                    ->whereIn('sensor_type',[
                        'tote',
                        'level',
                        'flow',
                    ]);
            })->get();
    }

    protected function getSensorsByCheckPoint($check_point)
    {

        return Sensor::query()->with([
            'device.check_point',
        ]) ->whereIn('address_id', function($query){
            $query->select('id')
                ->from('addresses')
                ->where('configuration_type','scale');
        })->whereIn('device_id',function($query)  use($check_point){
            $query->select('id')
                ->from('devices')
                ->where('check_point_id',$check_point);
        });;
    }

    protected function getLevelSensor($sensors)
    {
        return $sensors->filter(function($sensor) {
            return collect(['level'])->contains($sensor->type->sensor_type);
        })->first();
    }

    protected function getToteSensor($sensors)
    {
        return $sensors->filter(function($sensor) {
            return collect(['tote'
            ])->contains($sensor->type->sensor_type);
        })->first();

    }

    protected function getFlowSensor($sensors)
    {
        return $sensors->filter(function($sensor) {
            return collect(['flow'
            ])->contains($sensor->type->sensor_type);
        })->first();

    }
}
