<?php

namespace App\Http\Data\Jobs\CheckPoint;

use App\App\Controllers\Soap\InstanceSoapClient;
use App\App\Controllers\Soap\SoapController;
use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\CheckPoint\DGA\CheckPointReport;
use App\Domain\WaterManagement\Device\Device;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use SoapHeader;

class ReportToDGA extends SoapController implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $dga_report;

    public function __construct($dga_report)
    {
        $this->dga_report = $dga_report;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $checkPoints = CheckPoint::whereNotNull('work_code')->where('dga_report',$this->dga_report)->get();

        foreach($checkPoints as $checkPoint) {
            $last_report = '';
            $last_report = CheckPointReport::where('check_point_id',$checkPoint->id)->orderBy('id','desc')->first();
            if(Carbon::now()->diffInMinutes(Carbon::parse($last_report->report_date)) > 40) {
                $device = Device::with([
                    'sensors' => function ($q) {
                        return $q->sensorType('totalizador');
                    },
                    'sensors.type',
                    'sensors.analogous_reports' => function($q)
                    {
                        $q->orderBy('id', 'desc')->take(1);
                    }
                ])->whereHas('sensors', function ($q) {
                    return $q->sensorType('totalizador');
                })->where('check_point_id',$checkPoint->id)->first();
                if(!$device->sensors->first()) {
                    continue;
                } else {
                    $totalizador = $device->sensors->first()->analogous_reports->first()->result;
                }

                $flow = Device::with([
                    'sensors' => function ($q) {
                        return $q->sensorType('tx-caudal');
                    },
                    'sensors.type',
                    'sensors.analogous_reports' => function($q)
                    {
                        $q->orderBy('id', 'desc')->take(1);
                    }
                ])->whereHas('sensors', function ($q) {
                    return $q->sensorType('tx-caudal');
                })->where('check_point_id',$checkPoint->id)->first();
                if(!$flow->sensors->first()) {
                    continue;
                } else {
                    $caudal = $flow->sensors->first()->analogous_reports->first()->result;
                }




                $device = Device::with([
                    'sensors' => function ($q) {
                        return $q->sensorType('tx-nivel');
                    },
                    'sensors.type',
                    'sensors.analogous_reports' => function($q)
                    {
                        $q->orderBy('id', 'desc')->take(1);
                    }
                ])->whereHas('sensors', function ($q) {
                    return $q->sensorType('tx-nivel');
                })->where('check_point_id',$checkPoint->id)->first();
                if(!$device->sensors->first()->first()) {
                    continue;
                } else {
                    $nivel = $device->sensors->first()->analogous_reports->first()->result * -1;
                }


                $this->ReportToDGA($totalizador,$caudal,$nivel,$checkPoint->work_code,$checkPoint);
            }

        }
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
}
