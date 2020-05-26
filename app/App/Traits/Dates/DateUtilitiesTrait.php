<?php

namespace App\App\Traits\Dates;

use Carbon\Carbon;

trait DateUtilitiesTrait
{
    public function monthsBetween($start, $end = null)
    {
        $start = Carbon::parse($start);
        $end   = (($end)?Carbon::parse($end):null ?? Carbon::today())->startOfMonth();
        $i = 0;
        do {
            $months[] = $start->format('m');
        } while ($start->addMonth() <= $end);

        return $months;
    }
}
