<?php

namespace App\Http\Controllers\Api\Sensor;

use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Api\ApiKey;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetSensorsApiController extends Controller
{
    use HasAnalogousData;

    public function __invoke(Request $request)
    {
        if(!$request->hasHeader('api-key')) {
            return response(['No posee permisos para ingresar al recurso.'],401);
        }

        if(!$api = ApiKey::with('sensors')->where('api_key',$request->header('api-key'))->first()) {
            return response(['Llave no encontrada.'],404);
        }

        $data = array();
        foreach($api->sensors as $sensor) {
            $s = $this->getSensorById($sensor->sensor_id);
            $analogous_data = $this->getAnalogousValue($s,true);

            array_push($data,[
                'name' => $s->device->check_point->name,
                'value' => $analogous_data['value'],
                'unit' => $analogous_data['unit'],
                'date' => Carbon::now()->toDateTimeString()
            ]);
        }

        return $data;
    }

}
