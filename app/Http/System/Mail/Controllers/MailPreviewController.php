<?php

namespace App\Http\System\Mail\Controllers;

use App\Domain\System\Mail\Mail;
use App\Mail\SystemMail;
use App\App\Controllers\Controller;

class MailPreviewController extends Controller
{

    public function __invoke($id)
    {
        $mail = Mail::findOrFail($id);
        return (new SystemMail($mail))->render();
    }

}
