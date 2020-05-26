<?php

namespace App\Http\System\Import\Queue\Controllers;

use App\Domain\System\Import\Import;
use App\Domain\System\Import\QueuedImport;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class SerializeQueuedImportController extends Controller
{
    public function index($id)
    {
        $queue = QueuedImport::findOrFail($id);
        $imports  = Import::find(json_decode($queue->imports));

        return view('system.import.queue.serialization', compact('queue','imports'));
    }

    public  function serialize(Request $request, $id)
    {
        $queue = QueuedImport::findOrFail($id);
        $fields = json_decode($request->fields, true);
        $imports = array();
        foreach ($fields as $f) {
            array_push($imports, $f['id']);
        }
        $queue->imports = json_encode($imports);
        $queue->save();


        return response()->json(['success'=> 'Sequencia Serializada Correctamente']);
    }
}
