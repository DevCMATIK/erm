<?php

namespace App\Http\Client\Command\Controllers;

use App\Exports\Client\Command\ExportCommandsExecuted;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class CommandsExecutedController extends Controller
{
    public function index()
    {
        return view('client.commands.index');
    }

    public function export()
    {
        return (new ExportCommandsExecuted())->download('Comandos Ejecutados'.Carbon::now()->toDateString().'.xlsx');
    }
}
