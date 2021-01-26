<?php

namespace App\Http\Data\Jobs\Restore;

use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\Data\Digital\DigitalReport;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Domain\WaterManagement\Main\Historical;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RestoreDataForSensor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, HasAnalogousData;

    public $sensor_id;
    public $start_date;
    public $end_date;
    public $current_date;


    public function __construct($sensor_id,$start_date,$end_date,$current_date)
    {
        //
        $this->sensor_id = $sensor_id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->current_date = $current_date;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sensor = Sensor::with(['device','address','type','dispositions','selected_disposition','ranges'])->find($this->sensor_id);

        $rows = Historical::where('grd_id', $sensor->device->internal_id)
            ->where('register_type',$sensor->address->register_type_id)
            ->where('address',$sensor->address_number)
            ->whereRaw("timestamp between '{$this->current_date} 00:00:00' and '{$this->current_date} 23:59:59'")
            ->get();
        $records = $this->getRowsFilteredByInterval($rows,$sensor->type->interval,$this->current_date);
        if(count($records) > 0) {
            if($sensor->address->configuration_type == 'scale') {
                $toInsert = array();
                if (!$disposition = $sensor->selected_disposition->first()) {
                    $disposition = $sensor->dispositions()->first();
                }

                if ($disposition) {
                    foreach ($records as $record) {
                        $value = $record['value'];
                        $ingMin = optional($disposition)->sensor_min;
                        $ingMax = optional($disposition)->sensor_max;
                        $escalaMin = optional($disposition)->scale_min;
                        $escalaMax = optional($disposition)->scale_max;
                        if($escalaMin == null && $escalaMax == null) {
                            $data = ($ingMin * $value) + $ingMax;
                        } else {
                            $f1 = $ingMax - $ingMin;
                            $f2 = $escalaMax - $escalaMin;
                            $f3 = $value - $escalaMin;
                            if($f2 == 0) {
                                $data = ((0)*($f3)) + $ingMin ;
                            } else {
                                $data = (($f1/$f2)*($f3)) + $ingMin ;
                            }
                        }
                        if($disposition->unit->name == 'mt') {
                            $data = $sensor->max_value + $data;
                        }
                        $ranges = $sensor->ranges;
                        if (count($ranges) > 0) {
                            foreach($ranges as $range) {
                                if((float)$data >= $range->min && (float)$data <= $range->max) {
                                    $color = $range->color;
                                }
                            }
                        }
                        if(!isset($color) || $color == '') {
                            $color = null;
                        }
                        array_push($toInsert, [
                            'device_id' => $sensor->device->id,
                            'register_type' => $sensor->address->register_type_id,
                            'address' => $sensor->address_number,
                            'sensor_id' => $sensor->id,
                            'scale' => $disposition->name,
                            'scale_min'=> $disposition->scale_min,
                            'scale_max' => $disposition->scale_max,
                            'ing_min' => $disposition->sensor_min,
                            'ing_max' => $disposition->sensor_max,
                            'unit' => $disposition->unit->name,
                            'value' => $value,
                            'result' => $data,
                            'scale_color' => $color,
                            'date' => $record['timestamp'],
                            'pump_location' => $sensor->max_value
                        ]);
                    }
                }
                AnalogousReport::insert($toInsert);


            } else {
                $toInsert = array();
                $label = $sensor->label;
                if ($label) {
                    foreach ($records as $record) {
                        array_push($toInsert, [
                            'device_id' => $sensor->device->id,
                            'register_type' => $sensor->address->register_type_id,
                            'address' => $sensor->address_number,
                            'sensor_id' => $sensor->id,
                            'name' => $sensor->name,
                            'on_label' => $label->on_label,
                            'off_label' => $label->off_label,
                            'value' => $record['value'],
                            'label' => ($record['value'] == 1)? $label->on_label : $label->off_label,
                            'date' => $record['timestamp']
                        ]);
                    }
                }

                DigitalReport::insert($toInsert);
            }
        }


        if($this->current_date != $this->end_date) {
            RestoreDataForSensor::dispatch($this->sensor_id,$this->start_date,$this->end_date,Carbon::parse($this->current_date)->addDay()->toDateString())->onQueue('long-running-queue-low');
        }
    }

   protected function getRowsFilteredByInterval($rows,$interval,$current_date)
   {
       switch($interval){
           case 10:
               $newRows = array();
               for($i= 0;$i<24;$i++) {
                   $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
                   $row = $rows->filter(function($item) use ($hour,$current_date){
                       return (
                           strtotime($item->toArray()['timestamp']) > strtotime("{$current_date} {$hour}:00:00")
                           && strtotime($item->toArray()['timestamp']) < strtotime("{$current_date} {$hour}:09:59")
                       );
                   })->first();
                   if($row) {
                       array_push($newRows,$row->toArray());
                   }
                   $row = $rows->filter(function($item) use ($hour,$current_date){
                       return (
                           strtotime($item->toArray()['timestamp']) > strtotime("{$current_date} {$hour}:10:00")
                           && strtotime($item->toArray()['timestamp']) < strtotime("{$current_date} {$hour}:19:59")
                       );
                   })->first();
                   if($row) {
                       array_push($newRows,$row->toArray());
                   }
                   $row = $rows->filter(function($item) use ($hour,$current_date){
                       return (
                           strtotime($item->toArray()['timestamp']) > strtotime("{$current_date} {$hour}:20:00")
                           && strtotime($item->toArray()['timestamp']) < strtotime("{$current_date} {$hour}:29:59")
                       );
                   })->first();
                   if($row) {
                       array_push($newRows,$row->toArray());
                   }

                   $row = $rows->filter(function($item) use ($hour,$current_date){
                       return (
                           strtotime($item->toArray()['timestamp']) > strtotime("{$current_date} {$hour}:30:00")
                           && strtotime($item->toArray()['timestamp']) < strtotime("{$current_date} {$hour}:39:59")
                       );
                   })->first();
                   if($row) {
                       array_push($newRows,$row->toArray());
                   }

                   $row = $rows->filter(function($item) use ($hour,$current_date){
                       return (
                           strtotime($item->toArray()['timestamp']) > strtotime("{$current_date} {$hour}:40:00")
                           && strtotime($item->toArray()['timestamp']) < strtotime("{$current_date} {$hour}:49:59")
                       );
                   })->first();
                   if($row) {
                       array_push($newRows,$row->toArray());
                   }

                   $row = $rows->filter(function($item) use ($hour,$current_date){
                       return (
                           strtotime($item->toArray()['timestamp']) > strtotime("{$current_date} {$hour}:50:00")
                           && strtotime($item->toArray()['timestamp']) < strtotime("{$current_date} {$hour}:59:59")
                       );
                   })->first();
                   if($row) {
                       array_push($newRows,$row->toArray());
                   }
               }
               break;
           case 15:
               $newRows = array();
               for($i= 0;$i<24;$i++) {
                   $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
                   $row = $rows->filter(function($item) use ($hour,$current_date){
                       return (
                           strtotime($item->toArray()['timestamp']) > strtotime("{$current_date} {$hour}:00:00")
                           && strtotime($item->toArray()['timestamp']) < strtotime("{$current_date} {$hour}:14:59")
                       );
                   })->first();
                   if($row) {
                       array_push($newRows,$row->toArray());
                   }
                   $row = $rows->filter(function($item) use ($hour,$current_date){
                       return (
                           strtotime($item->toArray()['timestamp']) > strtotime("{$current_date} {$hour}:15:00")
                           && strtotime($item->toArray()['timestamp']) < strtotime("{$current_date} {$hour}:29:59")
                       );
                   })->first();
                   if($row) {
                       array_push($newRows,$row->toArray());
                   }
                   $row = $rows->filter(function($item) use ($hour,$current_date){
                       return (
                           strtotime($item->toArray()['timestamp']) > strtotime("{$current_date} {$hour}:30:00")
                           && strtotime($item->toArray()['timestamp']) < strtotime("{$current_date} {$hour}:44:59")
                       );
                   })->first();
                   if($row) {
                       array_push($newRows,$row->toArray());
                   }

                   $row = $rows->filter(function($item) use ($hour,$current_date){
                       return (
                           strtotime($item->toArray()['timestamp']) > strtotime("{$current_date} {$hour}:45:00")
                           && strtotime($item->toArray()['timestamp']) < strtotime("{$current_date} {$hour}:59:59")
                       );
                   })->first();
                   if($row) {
                       array_push($newRows,$row->toArray());
                   }


               }
               break;
           case 30:
               $newRows = array();
               for($i= 0;$i<24;$i++) {
                   $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
                   $row = $rows->filter(function($item) use ($hour,$current_date){
                       return (
                           strtotime($item->toArray()['timestamp']) > strtotime("{$current_date} {$hour}:00:00")
                           && strtotime($item->toArray()['timestamp']) < strtotime("{$current_date} {$hour}:29:59")
                       );
                   })->first();
                   if($row) {
                       array_push($newRows,$row->toArray());
                   }
                   $row = $rows->filter(function($item) use ($hour,$current_date){
                       return (
                           strtotime($item->toArray()['timestamp']) > strtotime("{$current_date} {$hour}:30:00")
                           && strtotime($item->toArray()['timestamp']) < strtotime("{$current_date} {$hour}:59:59")
                       );
                   })->first();
                   if($row) {
                       array_push($newRows,$row->toArray());
                   }

               }
               break;
           case 60:
               $newRows = array();
               for($i= 0;$i<24;$i++) {
                   $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
                   $row = $rows->filter(function($item) use ($hour,$current_date){
                       return (
                           strtotime($item->toArray()['timestamp']) > strtotime("{$current_date} {$hour}:00:00")
                           && strtotime($item->toArray()['timestamp']) < strtotime("{$current_date} {$hour}:59:59")
                       );
                   })->first();
                   if($row) {
                       array_push($newRows,$row->toArray());
                   }
               }
               break;
           default:
               if(count($rows) > 0) {
                   $newRows = $rows->toArray();
               } else {
                   $newRows = [];
               }


       }

       return $newRows;
   }
}
