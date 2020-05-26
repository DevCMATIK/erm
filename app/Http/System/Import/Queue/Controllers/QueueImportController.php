<?php

namespace App\Http\System\Import\Queue\Controllers;

use App\Domain\System\Import\Import;
use App\Domain\System\Import\QueuedImport;
use App\Http\System\Import\Queue\Requests\QueueImportRequest;
use App\App\Controllers\Controller;
use Sentinel;

class QueueImportController extends Controller
{
    public function index()
    {
        return view('system.import.queue.index');
    }

    public function create()
    {
        $imports = Import::get();
        return view('system.import.queue.create', compact('imports'));
    }

    public function store(QueueImportRequest $request)
    {
        if (count($request->imports) < 2) {
            return response()->json(['errors' => ['imports' => 'seleccione almenos 1']],422);
        } else {
            if(QueuedImport::create([
                'user_id' => Sentinel::getUser()->id,
                'name' => $request->name,
                'imports' => json_encode($request->imports)
            ])) {
                return $this->getResponse('success.store');
            } else {
                return $this->getResponse('error.store');
            }
        }
    }

    public function edit($id)
    {
        $queue = QueuedImport::findOrFail($id);
        $imports = Import::get();
        return view('system.import.queue.edit',compact('queue','imports'));
    }

    public function update(QueueImportRequest $request, $id)
    {
        $queue = QueuedImport::findOrFail($id);
        if (count($request->imports) < 2) {
            return response()->json(['errors' => ['imports' => 'seleccione almenos 1']],422);
        } else {
            if($queue->update([
                'name' => $request->name,
                'imports' => json_encode($request->imports)
            ])) {
                return $this->getResponse('success.update');
            } else {
                return $this->getResponse('error.update');
            }
        }
    }

    public function destroy($id)
    {
        if(QueuedImport::destroy($id)) {
            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
