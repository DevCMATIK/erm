<?php

namespace App\App\Traits\File;


use App\Domain\System\File\File;
use Illuminate\Support\Facades\Storage;

trait CanDeleteFiles
{
    public $disk = 'public';

    public function deleteFile($file,$path)
    {
        $fullPath = $path.$file->file;

        if (Storage::disk($this->disk)->exists($fullPath)) {
            if (Storage::disk($this->disk)->delete($fullPath)) {
                if (!$file->delete()) {
                    return response()->json(['error' => 'No se pudo eliminar el registro del archivo'],401);
                }

                return response()->json(['success' => 'Se ha eliminado el archivo correctamente.']);
            } else {
                return response()->json(['error' => 'No se puede eliminar el archivo.'],401);
            }
        } else {
            return response()->json(['error' => 'No se encuentra el archivo en el disco.'],401);
        }
    }
}
