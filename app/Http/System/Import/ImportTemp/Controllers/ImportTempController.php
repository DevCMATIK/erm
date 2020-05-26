<?php

namespace App\Http\System\Import\ImportTemp\Controllers;

use App\Domain\System\Import\ImportFile;
use App\Domain\System\Import\ImportTemp;
use App\App\Controllers\Controller;
use League\Csv\Reader;

class ImportTempController extends Controller
{
    public function checkFileStatus($id)
    {
        $importFile = ImportFile::with('import')->find($id);
        if($importFile->imported == 0) {
            return $this->importCsv($importFile);
        } else {
            return response()->json(['success' => 'Listo para Procesar']);
        }
    }

    public function importCsv($importFile)
    {
        $import = $importFile->import;
        $path = 'storage/imports/'.$import->slug.'/'.$importFile->file;
        $csv = Reader::createFromPath($path,'r');
        $csv->setDelimiter(";");
        if($import->ignore_header == 0) {
            $csv->setHeaderOffset($import->offset);
            $header = $csv->getHeader();
            $fields = $import->getFieldsArray();
            if($this->validateHeader($header,$fields))
            {
                $records = $csv->getRecords();
            } else {
                return response()->json(['error' => 'El formato de csv no corresponde al del sistema.'],401);
            }
        } else {
            $records = $csv->getRecords($import->getFieldsArray());
        }

        return $this->processRecords($records,$importFile);
    }

    public function validateHeader($header,$fields)
    {
        if (count(array_values($header)) == count($fields)) {
            return true;
        }
        return false;
    }

    public function processRecords($records,$importFile)
    {
        $i = 1;
        $row = 0;
        $recordsAsArray = iterator_to_array($records);

        foreach(array_chunk($recordsAsArray,200) as $items){
	        $rows  = array();
            foreach ($items as $item) {
                if($row > $importFile->import->offset) {
                    array_push($rows,[
                        'import_file_id' => $importFile->id,
                        'row_num' => $i,
                        'data' => $this->makeData($item),
                        'processed' => 0
                    ]);
                }
                $i++;
                $row++;
            }
	        ImportTemp::insert($rows);
        }

        $importFile->imported = 1;
        $importFile->save();
        return response()->json(['success' => 'Datos cargados correctamente, listos para procesar']);
    }

    public function makeData($record)
    {
        return utf8_encode(str_replace('\\\\',';',str_replace(',','',implode('\\\\',array_values($record)))));
    }
}
