<?php
namespace App\Http\Audit\Traits;

use App\App\Traits\Dates\DateUtilitiesTrait;
use App\Domain\System\Audit\Audit;
use App\Domain\System\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Sentinel;

trait HasAuditTrait
{
    use DateUtilitiesTrait;

    protected function LogQuery()
    {
        return Audit::query()
            ->join('users','audits.user_id','=','users.id')
            ->orderBy('audits.id','DESC');
    }

    protected function getLogWithParameters(Request $request)
    {
        return $this->handleDates($this->resolveLogsParameters($request,$this->LogQuery(),[
            'audits.user_id'  => 'user',
            'audits.event'    => 'type_event',
        ]),$request->dates,'audit_created_at');
    }

    protected function resolveLogsParameters($request, $query,$parameters)
    {
        foreach($parameters as $field => $parameter) {
            if($request->has($parameter) && $request->{$parameter} !== null && count($request->{$parameter}) > 0) {
                $query = $query->search($field,$request->{$parameter});
            }
        }
        return $query;
    }
}
