<?php

namespace App\Http\System\Import\ImportFile\Controllers;

use App\Domain\System\Import\Import;
use App\Domain\System\Import\ImportFile;
use App\App\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ImportFileDatatableController extends Controller
{
    public function getData($slug)
    {
    	$import = Import::findBySlug($slug);
	    $records = ImportFile::where('import_id',$import->id)
		    ->with('user')
		    ->withCount('error_messages')
		    ->orderBy('created_at','desc')
		    ->get();
	    $data = array();
	    $i = 1;
	    foreach ($records as $record) {
	        $status = $this->handleStatus($record);
		    array_push($data, [
			    $i,
			    $record->user->full_name,
			    makeLink(Storage::url('imports/'.$import->slug.'/'.$record->file),$this->makeShortFilename($record),'fa-file','btn-link'),
			    $record->extension,
			    $status['status'],
			    Carbon::parse($record->created_at)->toDateTimeString(),
                $status['buttons']
		    ]);
		    $i++;
	    }
	    $json = array('data' => $data);
	    return json_encode($json);
    }

    public function handleStatus($record)
    {
        $deleteButton = makeDeleteButton('Realmente desea eliminar este archivo?',$record->id,"'reload'",'importFiles',true);
        switch ($record->imported) {
            case 0:
                return [
                    'status' => 'Archivo Cargado',
                    'buttons' => makeGroupedLinks([makeLink('/importFiles/import/'.$record->id,'Importar','fa-upload','btn-info','btn-sm',true),$deleteButton]),
                ];
                break;
            case 1:
                return [
                    'status' => 'Listo para procesar',
	                'buttons' => makeGroupedLinks([makeLink('/importFiles/import/'.$record->id,'Procesar','fa-cogs','btn-info','btn-sm',true),$deleteButton]),
                ];
                break;
            case 2:
            	if ($record->error_messages_count > 0) {
	            	$error_log_button = makeRemoteLink('/importFiles/errorLog/'.$record->id,'Errores','fa-exclamation-circle','btn-warning','btn-sm');
	            } else {
            		$error_log_button = 'Completado';
	            }
                return [
                    'status' => 'Procesado',
                    'buttons' => $error_log_button,
                ];
                break;
            default:
                return [
                    'status' => 'Con Errores',
                    'buttons' => $deleteButton,
                ];
                break;
        }
    }

    public function makeShortFilename($record)
    {
    	$ext = explode('.',$record->file)[1];
    	$aux = explode('_',$record->file);
		$user = substr($record->user->first_name,0,1).substr($record->user->last_name,0,1);

		return $user."_".$aux[1].str_replace('-','',Carbon::parse($record->created_at)->format('YmdHis')).'.'.$ext;

    }
}
