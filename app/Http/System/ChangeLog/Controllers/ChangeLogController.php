<?php

namespace App\Http\System\ChangeLog\Controllers;

use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class ChangeLogController extends Controller
{
    public function index()
    {
        return view('system.change-log.index');
    }
}
