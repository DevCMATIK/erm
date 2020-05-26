<?php

namespace App\Http\User\Settings\Controllers;

use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class UserSettingsController extends Controller
{
    public function index()
    {
        return view('user.settings.index');
    }
}
