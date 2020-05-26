<?php

namespace App\Http\System\Import\ImportFile\Controllers;

use App\App\Traits\File\CanDeleteFiles;
use App\App\Traits\File\CanUploadFiles;
use App\Domain\System\Import\Import;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Sentinel;

class ImportFileUploadController extends Controller
{
    use CanUploadFiles,CanDeleteFiles;

    public function uploadView($slug)
    {
        $import = Import::findBySlug($slug);
        return view('system.import.import-file.upload',compact('slug'));
    }

    public function fileUpload(Request $request)
    {
        $import = Import::findBySlug($request->slug);
        if ($file_name = $this->uploadFile($request,'imports/'.$import->slug.'/')) {
            if($import->files()->create([
                'user_id' => Sentinel::getUser()->id,
                'file' => $file_name['file'],
                'extension' => $file_name['extension'],
                'imported' => 0,
                'before_function' => 0,
                'after_function' => 0
            ])) {
                return response()->json(['success' => 'Archivo cargado correctamente.']);
            } else {
                return response()->json(['error' => 'No se cargó el registro de la carga de archivo.'],401);
            }
        } else {
            return response()->json(['error' => 'No se pudo guardar el archivo.'],401);
        }
    }
}
