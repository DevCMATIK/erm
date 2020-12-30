<?php

namespace App\Http\Data\Jobs\Export;

use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\Data\Digital\DigitalReport;
use App\Domain\Data\Export\ExportReminderFile;
use App\Domain\System\File\File;
use Box\Spout\Common\Type;
use Rap2hpoutre\FastExcel\FastExcel;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateFileForSensor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $sensor;

    public $from;

    public $to;

    public $reminder;

    public $is_digital;

    public $user;

    public function __construct($sensor,$from,$to,$user, $reminder)
    {
        $this->sensor = $sensor;
        $this->from = $from;
        $this->to = $to;
        $this->user = $user;
        $this->reminder = $reminder;
    }


    public function handle()
    {
        ini_set('memory_limit','2048M');



        $fileName = 'Data-'.md5(rand(0,10000000)).'.xlsx';


        (new FastExcel($this->getData()))->export(storage_path('app/public/'.$fileName), function ($row) {
            return array_combine($this->getHeader(),$this->mapRows($row));
        });

        $this->reminder->files()->create([
            'file' => $fileName,
            'display_name' => $this->sensor->device->check_point->sub_zones()->first()->name.'_'.$this->sensor->device->check_point->name.'_'.$this->sensor->name,
        ]);
        freeMemory();
    }

    protected function mapRows($row)
    {
        if ($this->is_digital) {
            return  [
                $row->sensor->device->check_point->name,
                $row->sensor->name,
                    (string)$row->value,
                $row->label,
                    Carbon::parse($row->date)->toDateString(),
                    Carbon::parse($row->date)->toTimeString(),
                ];
        } else {

                if ($row->sensor->type->id === 1 && strtolower($row->unit) === 'mt') {
                    $interpreter = " UBba {$row->sensor->max_value} MT";
                } else {
                    $interpreter = $row->interpreter;
                }

                return [
                    $row->sensor->device->check_point->name,
                    $row->sensor->name,
                    $row->result,
                    $row->unit,
                    Carbon::parse($row->date)->toDateString(),
                    Carbon::parse($row->date)->toTimeString(),
                    $interpreter,
                ];
        }
    }

    protected function getData()
    {
        if(optional($this->sensor->label)->name) {
            $this->is_digital = true;
        } else {
            $this->is_digital = false;
        }
        if($this->is_digital) {
            $query = DigitalReport::query();
        } else {
            $query = AnalogousReport::query();
        }
        return $this->handleQuery($query
            ->with('sensor.device.check_point.sub_zones')
            ->where('sensor_id',$this->sensor->id))
            ->orderBy('date')->get();
    }

    protected function handleQuery($query)
    {
        $from = Carbon::parse($this->from)->startOfDay()->toDateTimeString();  //2016-09-29 00:00:00.000000
        $to = Carbon::parse($this->to)->endOfDay()->toDateTimeString();
        return $query->between('date',$from,$to);
    }

    protected function getHeader()
    {
        if($this->is_digital) {
            return [
                'Punto de Control',
                'Variable',
                'Valor Leído',
                'Etiqueta',
                'Fecha',
                'Hora',
            ];
        } else {
            return [
                'Punto de Control',
                'Variable',
                'Valor Leído',
                'Unidad',
                'Fecha',
                'Hora',
                'Descripción',
            ];
        }
    }
}
