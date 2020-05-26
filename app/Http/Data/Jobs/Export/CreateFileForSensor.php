<?php

namespace App\Http\Data\Jobs\Export;

use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\Data\Digital\DigitalReport;
use App\Domain\Data\Export\ExportReminderFile;
use App\Domain\System\File\File;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
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
        $writer = WriterEntityFactory::createCSVWriter();
        $writer->setFieldDelimiter(';');
        $fileName = 'Data-'.md5(rand(0,10000000)).'.csv';
        $writer->openToFile(storage_path('app/public/'.$fileName));
        $rows  = $this->getData();
        $writer->addRow(WriterEntityFactory::createRowFromArray($this->getHeader()));
        $writer->addRows($this->mapRows($rows));
        $writer->close();
        $this->reminder->files()->create([
            'file' => $fileName,
            'display_name' => $this->sensor->device->check_point->sub_zones()->first()->name.'_'.$this->sensor->device->check_point->name.'_'.$this->sensor->name,
        ]);
        freeMemory();
    }

    protected function mapRows($rows)
    {
        if ($this->is_digital) {
            return $rows->map(function($item){
                return WriterEntityFactory::createRow([
                    WriterEntityFactory::createCell($item->sensor->device->check_point->name),
                    WriterEntityFactory::createCell($item->sensor->name),
                    WriterEntityFactory::createCell((string)$item->value),
                    WriterEntityFactory::createCell($item->label),
                    WriterEntityFactory::createCell(Carbon::parse($item->date)->toDateString()),
                    WriterEntityFactory::createCell(Carbon::parse($item->date)->toTimeString()),
                ]);
            })->toArray();
        } else {
            return $rows->map(function ($item) {
                if ($item->sensor->type->id === 1 && strtolower($item->unit) === 'mt') {
                    $result = (float)number_format(((float)$item->sensor->max_value + (float)$item->result), 2);
                    $interpreter = " UBba {$item->sensor->max_value} MT";
                } else {
                    $result = $item->result;
                    $interpreter = $item->interpreter;
                }
                return WriterEntityFactory::createRow([
                    WriterEntityFactory::createCell($item->sensor->device->check_point->name),
                    WriterEntityFactory::createCell($item->sensor->name),
                    WriterEntityFactory::createCell(number_format($result,2,',','')),
                    WriterEntityFactory::createCell($item->unit),
                    WriterEntityFactory::createCell(Carbon::parse($item->date)->toDateString()),
                    WriterEntityFactory::createCell(Carbon::parse($item->date)->toTimeString()),
                    WriterEntityFactory::createCell($interpreter),
                ]);
            })->toArray();
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
