<?php

namespace App\Http\Data\Jobs\Backup;

use App\Domain\Backup\SimulatedAnalogousReport;
use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class StoreSimulatedData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $sensor_id;
    public $reports;

    public function __construct($sensor_id)
    {
        //
        $this->sensor_id = $sensor_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sensor = Sensor::whereHas('analogous_reports', $filter = function($query) {
            $query->whereRaw("date between '2020-01-26 00:00:00' and '2020-02-01 00:00:59'");
        })->with(['type','analogous_reports' => $filter])->find($this->sensor_id);
        if($sensor) {

            $reports  = $sensor->analogous_reports->groupBy(function($item,$key){
                return Carbon::parse($item->date)->month;
            });
            $hour = array();
            $avgperHour = array();
            $results = array();
            $toInsert = array();
            $x = 0;
            $interval = $sensor->type->interval;
            $fix = $sensor->fix_values_out_of_range;
            foreach($reports as $month => $rows) {
                foreach($rows->groupBy(function($item,$key){
                    return Carbon::parse($item->date)->day;
                }) as $day => $items){
                    foreach($items->groupBy(function($item,$key){
                        return Carbon::parse($item->date)->hour;
                    }) as $hour => $records) {
                        $month = str_pad($month, 2, '0', STR_PAD_LEFT);
                        $day = str_pad($day, 2, '0', STR_PAD_LEFT);
                        $hour = str_pad($hour, 2, '0', STR_PAD_LEFT);

                        $nextRecord = $sensor->analogous_reports->filter(function($item) use ($month,$day,$hour){
                            $date = "2020-{$month}-{$day} {$hour}:30:00";
                            $nextDate = Carbon::parse($date)->addMinutes(30);
                            return (
                                strtotime($item->date) > strtotime("2020-{$nextDate->month}-{$nextDate->day} {$nextDate->hour}:00:00")
                                && strtotime($item->date) < strtotime("2020-{$nextDate->month}-{$nextDate->day} {$nextDate->hour}:00:59")
                            );
                        })->first();
                        $avg = $this->getNextValue($records,$nextRecord,$month,$day,$hour,$interval);
                        $this->insertSimulation($records,$avg,$month,$day,$hour,$x,$interval,$fix);
                        unset($nextRecord);
                        $x++;
                    }


                }
            }
        }

    }

    protected function insertSimulation($records,$avg,$month,$day,$hour,$x,$interval,$fix)
    {
        $month = str_pad($month, 2, '0', STR_PAD_LEFT);
        $day = str_pad($day, 2, '0', STR_PAD_LEFT);
        $hour = str_pad($hour, 2, '0', STR_PAD_LEFT);

        $row = $records->filter(function($item) use ($month,$day,$hour){
            return (
                strtotime($item->date) > strtotime("2020-{$month}-{$day} {$hour}:29:59")
                && strtotime($item->date) < strtotime("2020-{$month}-{$day} {$hour}:31:00")
            );
        })->first();
        if(!$row) {
            return true;
        }
        $data = $row->toArray();
        $toInsert = array();
        $last_result = $row['result'];
        if($last_result < 0 && $fix === 1) {
            $last_result = 0;
        }

        //35
        if($interval === 5) {
            if(!$records->filter(function($item) use ($month,$day,$hour){
                return (
                    strtotime($item->date) > strtotime("2020-{$month}-{$day} {$hour}:34:59")
                    && strtotime($item->date) < strtotime("2020-{$month}-{$day} {$hour}:35:30")
                );
            })->first()) {
                $last_result = $last_result + $avg;
                if($last_result < 0  && $fix === 1) {
                    $last_result = 0;
                }
                $data['result'] = $last_result;
                $data['date'] = "2020-{$month}-{$day} {$hour}:35:00";
                array_push($toInsert,$data);

            }else {
                $last_result = $last_result + $avg;
            }
        }



        //40
        if(!$records->filter(function($item) use ($month,$day,$hour){
            return (
                strtotime($item->date) > strtotime("2020-{$month}-{$day} {$hour}:39:59")
                && strtotime($item->date) < strtotime("2020-{$month}-{$day} {$hour}:40:30")
            );
        })->first()) {
            $last_result = $last_result + $avg;
            if($last_result < 0  && $fix === 1) {
                $last_result = 0;
            }
            $data['result'] = $last_result;
            $data['date'] = "2020-{$month}-{$day} {$hour}:40:00";
            array_push($toInsert, $data);
        } else {
            $last_result = $last_result + $avg;
        }

        //45
        if($interval === 5) {
            if(!$records->filter(function($item) use ($month,$day,$hour){
                return (
                    strtotime($item->date) > strtotime("2020-{$month}-{$day} {$hour}:44:59")
                    && strtotime($item->date) < strtotime("2020-{$month}-{$day} {$hour}:45:30")
                );
            })->first()) {
                $last_result = $last_result + $avg;
                if($last_result < 0  && $fix === 1) {
                    $last_result = 0;
                }
                $data['result'] = $last_result;
                $data['date'] = "2020-{$month}-{$day} {$hour}:45:00";
                array_push($toInsert, $data);
            } else {
                $last_result = $last_result + $avg;
            }
        }


        //50
        if(!$records->filter(function($item) use ($month,$day,$hour){
            return (
                strtotime($item->date) > strtotime("2020-{$month}-{$day} {$hour}:49:59")
                && strtotime($item->date) < strtotime("2020-{$month}-{$day} {$hour}:50:30")
            );
        })->first()) {
            $last_result = $last_result + $avg;
            if($last_result < 0  && $fix === 1) {
                $last_result = 0;
            }
            $data['result'] = $last_result;
            $data['date'] = "2020-{$month}-{$day} {$hour}:50:00";
            array_push($toInsert, $data);
        } else {
            $last_result = $last_result + $avg;
        }
        //55
        if($interval === 5) {
            if(!$records->filter(function($item) use ($month,$day,$hour){
                return (
                    strtotime($item->date) > strtotime("2020-{$month}-{$day} {$hour}:54:59")
                    && strtotime($item->date) < strtotime("2020-{$month}-{$day} {$hour}:55:30")
                );
            })->first()) {
                $last_result = $last_result + $avg;
                if($last_result < 0  && $fix === 1) {
                    $last_result = 0;
                }
                $data['result'] = $last_result;
                $data['date'] = "2020-{$month}-{$day} {$hour}:55:00";
                array_push($toInsert, $data);
            }else {
                $last_result = $last_result + $avg;
            }
        }

        AnalogousReport::insert($toInsert);
    }

    protected function getNextValue($rows,$nextRecord,$month,$day,$hour,$interval)
    {


        $firstRecord = $rows->filter(function($item) use ($month,$day,$hour){
            return (
                strtotime($item->date) > strtotime("2020-{$month}-{$day} {$hour}:29:59")
                && strtotime($item->date) < strtotime("2020-{$month}-{$day} {$hour}:30:30")
            );
        })->first();
        if($nextRecord && $firstRecord) {
            $total = $nextRecord->result - $firstRecord->result;
            if($total === 0) {
                return 0;
            } else {
                if($interval === 5) {
                    return $total / 6;
                } else {
                    return $total / 3;
                }
            }
        } else {
            return 0;
        }

    }
}
