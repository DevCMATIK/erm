<?php

namespace App\App\Traits\File;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait CanUploadFiles
{
    use CanManageFiles;

    protected $file;

    protected $extension;

    public function uploadFile(Request $request,$directory)
    {
        if ($request->hasFile('file')) {
            $this->file = $request->file('file');
            $this->extension = $this->file->getClientOriginalExtension();
            $this->setFileName($directory);
            $this->setFileDirectory($directory);

            if($this->moveFile()) {
                return [ 'file' => $this->getFileName(), 'extension' => $this->extension];
            } else {
                return response()->json(['error' => 'No se pudo cargar el archivo.'],401);
            }
        } else {
            return response()->json(['error' => 'No File was uploaded'],401);
        }
    }

    public function moveFile()
    {
        if(Storage::putFileAs('public',$this->file , $this->getfullPath())) {
            if (Storage::disk('public')->exists($this->getfullPath())) {
                return true;
            } else {
                return response()->json(['error' => 'No fue movido el archivo'],401);
            }
        } else {
            return response()->json(['error' => 'No se pudo mover el archivo'],401);
        }
    }
}
