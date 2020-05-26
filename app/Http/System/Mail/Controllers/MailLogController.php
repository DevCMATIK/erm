<?php

namespace App\Http\System\Mail\Controllers;

use App\Domain\System\Mail\MailLog;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class MailLogController extends Controller
{
    public function index()
    {
        return view('system.mail.log');
    }

    public function receptors($id)
    {
        $users  = MailLog::with('users')->find($id)->users;

        return view('system.mail.receptors',compact('users'));
    }
}
