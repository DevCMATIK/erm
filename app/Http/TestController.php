<?php

namespace App\Http;

use App\App\Controllers\Soap\SoapController;
use App\App\Jobs\SendToDGA;
use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\CheckPoint\DGA\CheckPointReport;
use App\Domain\Client\Zone\Zone;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Sentinel;


class TestController extends SoapController
{
    use HasAnalogousData;

    public $current_date = '2020-12-01';

    public function __invoke()
    {


        return $this->testResponse([
            'zones' => $this->getZones()
        ]);
    }

    protected function getZones()
    {
        return Zone::with([
            'sub_zones.configuration',
            'sub_zones.sub_elements'
        ])->get()->filter(function($item){
            return $item->sub_zones->filter(function($sub_zone) {
                    return Sentinel::getUser()->inSubZone($sub_zone->id) && isset($sub_zone->configuration);
                })->count() > 0;
        });
    }

    public function testResponse($results)
    {
        return response()->json(array_merge(['results' => $results],$this->getExecutionTime()));
    }

    public function getExecutionTime()
    {
        return [
            'time_in_seconds' => (microtime(true) - LARAVEL_START)
        ];
    }
}
