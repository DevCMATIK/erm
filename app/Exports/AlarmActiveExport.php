<?php

namespace App\Exports;

use App\Domain\System\User\User;
use App\Users;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;


class AlarmActiveExport implements FromCollection
{
    Use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        // TODO: Implement collection() method.
    }

}
