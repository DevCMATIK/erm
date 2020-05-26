<?php

namespace App\Http\System\Import\ImportFile\Controllers;

use App\App\Traits\File\CanDeleteFiles;
use App\Domain\System\Import\Import;
use App\Domain\System\Import\ImportFile;
use App\App\Controllers\Controller;

class ImportFileController extends Controller
{
    use CanDeleteFiles;

    public function index($slug)
    {
    	$import = Import::findBySlug($slug);
    	return view('system.import.import-file.index',compact('import'));
    }

    public function destroy($id)
    {
        $importFile = ImportFile::with('import')->withCount('temps')->find($id);
        if ($importFile->temps_count > 0) {
            $importFile->temps()->delete();
        }
        if($this->deleteFile($importFile,'imports/'.$importFile->import->slug.'/')) {
            return response()->json(['success' => 'Registro Eliminado Correctamente']);
        } else {
            return response()->json(['error' => 'No se pudo eliminar el archivo del sistema.'],401);
        }
    }

    public function importView($id)
    {
        $importFile = ImportFile::find($id);
        return view('system.import.import-file.import',compact('importFile'));
    }
}
