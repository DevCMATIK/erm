<?php


namespace App\Http\Audit\Controllers;

use App\App\Controllers\Controller;
use App\App\Traits\Dates\DateUtilitiesTrait;
use App\Domain\System\User\User;
use App\Http\Audit\Traits\HasAuditTrait;
use Illuminate\Http\Request;
use App\Domain\System\Audit\Audit;

class LogTableController extends Controller
{
    use DateUtilitiesTrait, HasAuditTrait;

    public function index(Request $request)
    {
        //$logs=Audit::get()->take(5);
        //return view('audit.log',compact('logs'));

        $logs=$this->getLogWithParameters($request)->get();
        return view('audit.log',compact('logs'));
    }

    public function getSearch(Request $request)
    {
        $val = explode('_',$request->element);
        User::find($val[2])->alarm_reminders()->toggle($val[1]);
    }


}
