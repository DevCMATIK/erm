<?php

namespace App\Http\User\Profile\Controllers;

use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class UserProfileController extends Controller
{
    public function index()
    {
        return view('user.profile.index');
    }
}
