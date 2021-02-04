<?php

namespace App\Http;

use App\App\Controllers\Soap\SoapController;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Domain\WaterManagement\Main\Historical;
use App\Http\Data\Jobs\Restore\RestoreEnergyConsumption;
use Carbon\Carbon;
use Sentinel;


class TestController extends SoapController
{

    public $current_date = '2020-12-01';

    public function __invoke()
    {
        dd(Sensor::get()->unique());
    }
}
