<?php

namespace App\Http;

use App\App\Controllers\Soap\InstanceSoapClient;
use App\App\Controllers\Soap\SoapController;
use App\Domain\Client\Area\Area;
use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\WaterManagement\Device\Device;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Sentinel;
use SoapHeader;


class TestController extends SoapController
{


    public function __invoke(Request $request)
    {
        $checkPoint = CheckPoint::whereNotNull('work_code')->first();


            $device = Device::with([
                'sensors' => function ($q) {
                    return $q->sensorType('totalizador');
                },
                'sensors.type',
                'sensors.analogous_reports' => function($q)
                {
                    $q->orderBy('id', 'desc')->first();
                }
            ])->whereHas('sensors', function ($q) {
                return $q->sensorType('totalizador');
            })->where('check_point_id',$checkPoint->id)->first();
            $totalizador = $device->sensors->first()->analogous_reports->first()->result;

            $flow = Device::with([
                'sensors' => function ($q) {
                    return $q->sensorType('tx-caudal');
                },
                'sensors.type',
                'sensors.analogous_reports' => function($q)
                {
                    $q->orderBy('id', 'desc')->first();
                }
            ])->whereHas('sensors', function ($q) {
                return $q->sensorType('tx-caudal');
            })->where('check_point_id',$checkPoint->id)->first();
            $caudal = $flow->sensors->first()->analogous_reports->first()->result;



            $device = Device::with([
                'sensors' => function ($q) {
                    return $q->sensorType('tx-nivel');
                },
                'sensors.type',
                'sensors.analogous_reports' => function($q)
                {
                    $q->orderBy('id', 'desc')->first();
                }
            ])->whereHas('sensors', function ($q) {
                return $q->sensorType('tx-nivel');
            })->where('check_point_id',$checkPoint->id)->first();
            $nivel = $device->sensors->first()->analogous_reports->first()->result * -1;

            $this->ReportToDGA($totalizador,$caudal,$nivel,$checkPoint->work_code,$checkPoint);

    }


    public function ReportToDGA($totalizador,$caudal,$nivelFreatico,$codigoDeObra,$checkPoint)
    {
        try {
            ini_set('default_socket_timeout', 600);
            self::setWsdl('https://snia.mop.gob.cl/controlextraccion/wsdl/datosExtraccion/SendDataExtraccionService');
            $service = InstanceSoapClient::init();
            $params = [
                'sendDataExtraccionRequest' => [
                    'dataExtraccionSubterranea' => [
                        'fechaMedicion' => Carbon::now()->format('d-m-Y'),
                        'horaMedicion' => Carbon::now()->format('H:i:s'),
                        'totalizador' => number_format($totalizador,0,'',''),
                        'caudal' => number_format($caudal,2,'.',''),
                        'nivelFreaticoDelPozo' => number_format($nivelFreatico,2,'.',''),
                    ]
                ]
            ];

            $headerParams = array(
                'codigoDeLaObra' => $codigoDeObra,
                'timeStampOrigen' =>   Carbon::now()->toIso8601ZuluString()
            );


            $headers[] = new SoapHeader('http://www.mop.cl/controlextraccion/xsd/datosExtraccion/SendDataExtraccionRequest',
                'sendDataExtraccionTraza',
                $headerParams
            );

            $service->__setSoapHeaders($headers);

            $response = $service->__soapCall('sendDataExtraccionOp',$params);

           dd($response,$headers,$headerParams,$service,$params);



        } catch(\Exception $e) {
            return $e->getMessage();
        }
    }
}
