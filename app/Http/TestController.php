<?php

namespace App\Http;

use App\App\Controllers\Soap\SoapController;
use App\Http\Data\Jobs\Restore\RestoreEnergyConsumption;
use Carbon\Carbon;
use Sentinel;


class TestController extends SoapController
{

    public function __invoke()
    {
        RestoreEnergyConsumption::dispatch(1532,'2020-01-02','2021-01-20','2020-01-02')->onQueue('long-running-queue-low');
    }
}
