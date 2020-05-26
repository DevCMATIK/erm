<?php

namespace App\Http\System\File\Controllers;

use App\App\Traits\File\CanDeleteFiles;
use App\App\Traits\File\CanUploadFiles;
use App\Domain\System\File\File;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Sentinel;

class FileController extends Controller
{
    use CanUploadFiles, CanDeleteFiles;
    protected $directory = 'filesUploaded/';
    public function create($table,$id,$unique = 1)
    {
        return view('system.file.create', compact(['table','id','unique']));
    }

    public function upload(Request $request)
    {

         if ($file_name = $this->uploadFile($request,$this->directory.'/'.$request->referenced_table.'/')) {
             if ($request->is_unique == 1) {
                $old = File::findByTableAndId($request->referenced_table,$request->referenced_id);
                if($old)
                    $this->deleteFile($old,$this->directory.'/'.$request->referenced_table.'/');
             }
             if (File::create([
                 'user_id' => Sentinel::getUser()->id,
                 'referenced_table' => $request->referenced_table,
                 'referenced_id' => $request->referenced_id,
                 'file' => $file_name['file'],
                 'extension' => $file_name['extension'],
                 'is_unique' => $request->is_unique
             ])) {
                return response()->json(['success' => 'Se ha cargado el archivo correctamente']);
             } else {
                return response()->json(['error' => 'No se ha podido guardar el registro.'],401);
             }
         } else {
            return response()->json(['error','No se pudo subir el archivo'],401);
         }
    }

    public function delete($table,$id) {
        $file = File::findByTableAndId($table,$id);
        if($this->deleteFile($file,$this->directory.'/'.$table.'/')) {
            return response()->json(['success' => 'Archivo eliminado correctamente.']);
        } else {
            return response()->json(['error' => 'No se pudo eliminar el archivo'],401);
        }
    }
}
