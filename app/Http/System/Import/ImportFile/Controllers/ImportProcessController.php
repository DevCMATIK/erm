<?php

namespace App\Http\System\Import\ImportFile\Controllers;

use App\Domain\System\Import\ImportFile;
use App\App\Controllers\Controller;

class ImportProcessController extends Controller
{
    public function index($id)
    {
        $importFile = ImportFile::with(['import','temps'])->find($id);
        return view('system.import.import-file.process',compact('importFile'));
    }

    public function progressBar($id)
    {
        $importFile = ImportFile::withCount(['temps','processed'])->find($id);
        if ($importFile->temps_count > 0) {
            $percentaje = round(($importFile->processed_count * 100)/$importFile->temps_count,2);
            return view('system.import.import-file.progressBar', compact('importFile','percentaje'));
        } else {
            return view('system.import.import-file.finished', compact('importFile'));
        }
    }

    public function getErrorLog($id)
    {
        $importFile = ImportFile::with('error_messages')->find($id);
        return view('system.import.import-file.errorLog',compact('importFile'));
    }

    public function cleanErrorLog($id){
        $importFile = ImportFile::with('import')->find($id);
        $importFile->temps()->delete();
        return redirect('/importFile/'.$importFile->import->slug);
    }
}
