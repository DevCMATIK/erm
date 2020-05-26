<?php

namespace App\Http\Imports;

use App\App\Controllers\Controller;
use App\Domain\System\Import\ImportFile;
use App\Domain\System\Import\ImportTemp;

abstract class ImportAbstract extends Controller
{
    protected $importFile;

    protected $preloaded;

    protected $toInsert = array();

    public abstract function processRecord($record);

    public function processData($id)
    {
        $importFile = ImportFile::find($id);
        if ($importFile->before_function == 0) {
            if ($this->beforeLoad($id)) {
                $this->donedBeforeLoad($importFile);
            }
        }

        $this->preloaded = $this->preloadData();

        return $this->process($importFile,$this->preloaded);
    }

    public function process($importFile,$preloaded)
    {
        $records = $this->filterPackage($this->getPackage($importFile->id));

        if (count($records) > 0) {
            $time_start = microtime(true);
            foreach ($records as $record) {
                $this->processRecord($record);
            }
            if(count($this->toInsert) > 0) {
                $this->massInsert();
            }
            $time_end = microtime(true);
            $execution_time = ($time_end - $time_start);
            return response()->json(['msg' => 'OK', 'execution_time' => round($execution_time,1)." seg."],200);
        } else {
            return $this->finalize($importFile->id);
        }
    }

    public function beforeLoad($id)
    {
        return true;
    }

    public function afterLoad($id)
    {
        return true;
    }

    public function massInsert()
    {
        return true;
    }

    public function preloadData()
    {
        return true;
    }

    public function filterPackage($package)
    {
        return $package;
    }

    public function donedBeforeLoad($importFile)
    {
        $importFile->before_function = 1;
        $importFile->save();
    }



    public function markAsDoned($id,$error = false)
    {
        $importTemp = ImportTemp::find($id);
        if($importTemp) {
            if($error === false) {
                $importTemp->update(['processed' => 1]);
            }  else {
                $importTemp->update(['processed' => 1, 'feedback' => $error]);
            }
        } else {
            dd($id);
        }
    }

    public function getPackage($id,$take = 200)
    {
        $this->importFile = ImportFile::with(['temps','import'])->find($id);
        if($take == -1) {
            $temps = $this->importFile->temps()
                ->processed(0)
                ->get()->toArray();
        } else {
            $temps = $this->importFile->temps()
                ->processed(0)
                ->take($take)
                ->get()->toArray();
        }


        $fields = $this->importFile->import->getFieldsArray();
        array_push($fields, 'id');

        $package = array();

        foreach ($temps as $temp) {
            $row = explode(';',$temp['data']);
            array_push($row,$temp['id']);
            if(count($row) == count($fields)) {
                array_push($package,array_combine($fields,$row));
            } else {
                $this->markAsDoned($temp['id'],'La línea posee ";" que no permite procesarla.');
            }
        }
        return $package;
    }

    public function finalize($id)
    {
        return $this->finishProcess($id);
    }

    public function finishProcess($id)
    {
        $importFile = ImportFile::find($id);
        if ($importFile->after_function == 0) {
            if ($this->afterLoad($id)) {
                $importFile->after_function = 1;
            }
        }

        $importFile->imported = 2;
        $importFile->save();
        ImportTemp::deleteDoned();

        return response()->json(['msg' => 'Doned']);
    }

    public function findInPreloaded($index,$field,$value)
    {
        return $this->preloaded[$index]->where($field,$value)->first();
    }
}
