<?php

namespace App\Http\System\Import\Import\Controllers;

use App\Domain\System\Import\Import;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class ImportViewController extends Controller
{
    public function index()
    {
    	return view('system.import.show.index');
    }

    public function getView($view)
    {
	    $imports = $this->getImportsList();
    	if ($view == 'list') {
		    return view('system.import.show.table',compact('imports'));
	    } else {
    	    $imports = collect($imports);
		    return view('system.import.show.item',compact('imports'));
	    }

    }

    public function getImportsList()
    {
    	return $this->filterImports(Import::with('roles')
            ->withCount('files')
            ->orderBy('files_count','desc')
            ->get());
    }

	public function filterImports($imports){
		$selected = [];
		foreach ($imports as $key => $import) {
			if ($import->userHasPermission()) {
				$selected[] = $imports->pull($key);
			}
		}
		return $selected;
	}
}
