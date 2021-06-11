<?php

namespace App\App\Jobs\DGA;

use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GetChekpointsToRestore implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $check;

    public function __construct($check)
    {
        $this->check = $check;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $checkpoint = CheckPoint::find($this->check);

        $sensors = $this->getSensors($checkpoint->id);

        $analogous_reports = AnalogousReport::whereIn('sensor_id',$sensors->pluck('id')->toArray())
            ->whereRaw("date between '2021-06-10 00:00:00' and '2021-06-10 23:59:00'")->get();

        $tote =  $analogous_reports->where('sensor_id',$this->getToteSensor($sensors)->id)
                ->where("date", '>=','2021-06-10 00:00:00')->where('date','<=','2021-06-10 23:59:00')
                ->first()->result ?? 0;

        $flow =  $analogous_reports->where('sensor_id',$this->getFlowSensor($sensors)->id)
                ->where("date", '>=','2021-06-10 00:00:00')->where('date','<=','2021-06-10 23:59:00')
                ->first()->result ?? 0;

        $level =  $analogous_reports->where('sensor_id',$this->getLevelSensor($sensors)->id)
                ->where("date", '>=','2021-06-10 00:00:00')->where('date','<=','2021-06-10 23:59:00')
                ->first()->result ?? 0;

        RestoreToDGA::dispatch($tote,$flow,$level,$checkpoint->work_code,$checkpoint,'2021-06-10 12:00:00')->onQueue('long-running-queue-low');



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
