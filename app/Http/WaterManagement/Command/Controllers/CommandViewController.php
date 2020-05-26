<?php

namespace App\Http\WaterManagement\Command\Controllers;

use App\App\Controllers\Controller;

class CommandViewController extends Controller
{
    public function index()
    {
        return view('water-management.command.index');
    }
}
