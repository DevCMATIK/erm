<?php

namespace App\App\Traits\Dates;

use Carbon\Carbon;

trait DateUtilitiesTrait
{
    public function monthsBetween($start, $end = null)
    {
        $start = Carbon::parse($start);
        $end   = (($end)?Carbon::parse($end):null ?? Carbon::today())->startOfMonth();
        do {
            $months[] = $start->format('m');
        } while ($start->addMonth() <= $end);
        return $months;
    }

    protected function handleDates($query, $dates, $field='date')
    {
        if($dates != '')
        {
            $dates = explode(' ',$dates);
            $from = date($dates[0]);
            $to = date($dates[2]);
            $from = Carbon::parse($from)->startOfDay()->toDateTimeString();
            $to = Carbon::parse($to)->endOfDay()->toDateTimeString();
            $query = $query->between($field,$from,$to);
        }
        return $query;
    }
}
