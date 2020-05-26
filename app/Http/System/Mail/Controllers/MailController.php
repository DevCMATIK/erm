<?php

namespace App\Http\System\Mail\Controllers;

use App\Domain\System\Mail\Mail;
use App\Domain\System\Mail\MailAttachable;
use App\Http\System\Mail\Requests\MailRequest;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Sentinel;

class MailController extends Controller
{
    public function index()
    {
        return view('system.mail.index');
    }

    public function create()
    {
        $attachables = MailAttachable::get();
        return view('system.mail.create',compact('attachables'));
    }

    public function store(MailRequest $request)
    {
        if($mail = Mail::create([
            'name' => $request->name,
            'subject' => $request->subject,
            'body' => $request->body,
            'header' => $request->header,
            'user_id' => Sentinel::getUser()->id,
            'share_with_all' => ($request->has('share_with_all'))?1:0
        ])) {
            $attachables = MailAttachable::get();
            foreach($attachables as $attachable) {
                if(strstr($request->body,$attachable->code)) {
                    $mail->attachables()->attach($attachable->id);
                }
            }
            addChangeLog('Email creado','mails',null,convertColumns($mail));

            return $this->getResponse('success.store');
        } else {
            return $this->getResponse('error.store');
        }
    }

    public function edit($id)
    {
        $mail = Mail::findOrFail($id);
        $attachables = MailAttachable::get();
        return view('system.mail.edit',compact('attachables','mail'));
    }

    public function update(MailRequest $request,$id)
    {
        $mail = Mail::findOrFail($id);
        $old = convertColumns($mail);
        if($mail->update([
            'name' => $request->name,
            'subject' => $request->subject,
            'body' => $request->body,
            'header' => $request->header,
            'share_with_all' => ($request->has('share_with_all'))?1:0
        ])) {
            $attachables = MailAttachable::get();
            $mail->attachables()->detach();
            foreach($attachables as $attachable) {
                if(strstr($request->body,$attachable->code)) {
                    $mail->attachables()->attach($attachable->id);
                }
            }
            addChangeLog('Mail modificado','mails',$old,convertColumns($mail));

            return $this->getResponse('success.update');
        } else {
            return $this->getResponse('error.update');
        }
    }

    public function destroy($id)
    {
        $mail = Mail::findOrFail($id);
        $mail->attachables()->detach();
        $mail->notifications()->delete();
        $mail->reminders()->delete();
        $mail->mail_reports()->forceDelete();
        if($mail->delete()) {
            addChangeLog('Mail Eliminado','mails',convertColumns($mail));

            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
