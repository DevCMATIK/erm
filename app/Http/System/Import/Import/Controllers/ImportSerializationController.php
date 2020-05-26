<?php

namespace App\Http\System\Import\Import\Controllers;

use App\Domain\System\Import\Import;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class ImportSerializationController extends Controller
{
    public function index($id)
    {
        $import = Import::find($id);
        $fields = $import->getFieldsArray();
        return view('system.import.serialization',compact('import','fields'));
    }

    public function serialize(Request $request,$id)
    {
        $fields = json_decode($request->fields, true);
        $newFieldsOrder = array();
        foreach ($fields as $f) {
            array_push($newFieldsOrder, $f['id']);
        }
        $import = Import::find($id);
        $import->fields = implode(',',$newFieldsOrder);
        $import->save();
        return response()->json(['success' => 'Import Serializado correctamente.']);
    }
}
