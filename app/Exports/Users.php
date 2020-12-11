<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Rap2hpoutre\FastExcel\FastExcel;

class Users implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
    }
}
