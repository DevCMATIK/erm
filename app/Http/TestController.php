<?php

namespace App\Http;

use App\App\Controllers\Controller;
use App\App\Controllers\Soap\InstanceSoapClient;
use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\WaterManagement\Device\Device;
use Carbon\Carbon;
use Sentinel;


class TestController extends Controller
{
    use HasAnalogousData;

    public function __invoke()
    {
        $time_start = microtime(true);

        $checkPoints = $this->getCheckPoints(1);
        foreach($checkPoints as $checkPoint)
        {
                $sensors = $this->getSensors($checkPoint);
                if(count($sensors) == 3) {
                    $this->ReportToDGA(
                        $this->getAnalogousValue($sensors->where('name','Aporte')->first(),true),
                        $this->getAnalogousValue($sensors->where('name','Caudal')->first(),true),
                        ($this->getAnalogousValue($sensors->where('name','Nivel')->first(),true) * -1),
                        $checkPoint->work_code,
                        $checkPoint
                    );
                } else {
                    continue;
                }
        }

        $time_end = microtime(true);

        $execution_time = ($time_end - $time_start);

        dd($execution_time);

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

            $checkPoint->dga_reports()->create([
                'response' => $response->status->Code,
                'response_text' => $response->status->Description,
                'tote_reported' => $totalizador,
                'flow_reported' => $caudal,
                'water_table_reported' => $nivelFreatico,
                'report_date' => Carbon::now()->toDateTimeString()
            ]);



        } catch(\Exception $e) {
            return $e->getMessage();
        }
    }

    protected function getCheckPoints($dga_report)
    {
        return  CheckPoint::with('last_report')
                    ->whereNotNull('work_code')
                    ->where('dga_report',1)
                    ->get();
    }

    protected function calculateTimeSinceLastReport($check_point)
    {
        return Carbon::now()->diffInMinutes(Carbon::parse($check_point->last_report->report_date));
    }

    protected function getSensors($checkPoint)
    {
        return $this->getSensorsByCheckPoint($checkPoint->id)
            ->whereIn('name',['Nivel','Aporte','Caudal'])
            ->get();
    }



}
