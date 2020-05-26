<?php

namespace App\Http\Data\Export;

use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\Data\Digital\DigitalReport;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ExportDataWithBox extends Controller
{
    public $is_digital;

    public function download($sensors,$from,$to)
    {
        $writer = WriterEntityFactory::createXLSXWriter();
        $fileName = 'Data-'.md5(rand(0,10000000)).'.xlsx';
        $writer->openToFile(storage_path('app/public/'.$fileName));
        $i = 0;
        foreach($sensors as $sensor) {
            $rows  = $this->getData($sensor,$from,$to);

            if($i === 0) {
                $sheet = $writer->getCurrentSheet();
            } else {
                $sheet = $writer->addNewSheetAndMakeItCurrent();
            }
            $sheet->setName($this->getsheetName($sensor));
            $writer->addRow(WriterEntityFactory::createRowFromArray($this->getHeader()));
            $writer->addRows($this->mapRows($rows));

            $i++;
        }
        $writer->close();

        //return Storage::disk('public')->download($fileName,'Data-'.Carbon::today()->toDateString().'.xlsx');
        return response()->download(storage_path('app/public/'.$fileName), 'Data-'.Carbon::today()->toDateString().'.xlsx');
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
                    $interpreter = " UBba {$item->sensor->max_value} MT";
                } else {
                    $interpreter = $item->interpreter;
                }
                $result = $item->result;

                return WriterEntityFactory::createRow([
                    WriterEntityFactory::createCell($item->sensor->device->check_point->name),
                    WriterEntityFactory::createCell($item->sensor->name),
                    WriterEntityFactory::createCell($result),
                    WriterEntityFactory::createCell($item->unit),
                    WriterEntityFactory::createCell(Carbon::parse($item->date)->toDateString()),
                    WriterEntityFactory::createCell(Carbon::parse($item->date)->toTimeString()),
                    WriterEntityFactory::createCell($interpreter),
                ]);
            })->toArray();
        }
    }

    protected function getSheetName($sensor)
    {
        $name = $sensor->device->check_point->name.' - '.$sensor->name;
        if(strlen($name) > 30) {
            $name = substr($sensor->device->check_point->name,0,10).' - '.$sensor->name;
        }
        return $name;
    }

    protected function getData($sensor,$from,$to)
    {
        if(optional($sensor->label)->name) {
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
            ->where('sensor_id',$sensor->id)
        ,$from,$to)->orderBy('date')->get();
    }

    protected function handleQuery($query,$from,$to)
    {
        $from = Carbon::parse($from)->startOfDay()->toDateTimeString();  //2016-09-29 00:00:00.000000
        $to = Carbon::parse($to)->endOfDay()->toDateTimeString();
        return $query->between('date',$from,$to);
    }
}
