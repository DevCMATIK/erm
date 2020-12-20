<?php

namespace App\Http\Data\Jobs\CheckPoint;

use App\App\Controllers\Soap\InstanceSoapClient;
use App\App\Controllers\Soap\SoapController;
use App\App\Traits\ERM\HasAnalogousData;
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
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, HasAnalogousData;

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
        $checkPoints = $this->getCheckPoints();
        foreach($checkPoints as $checkPoint)
        {
            if(!isset($checkPoint->last_report) || $this->calculateTimeSinceLastReport($checkPoint) > 40) {
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

    protected function getCheckPoints()
    {
        return  CheckPoint::with('last_report')
            ->whereNotNull('work_code')
            ->where('dga_report',$this->dga_report)
            ->get();
    }

    protected function calculateTimeSinceLastReport($check_point)
    {
        return Carbon::now()->diffInMinutes(Carbon::parse($check_point->last_report->report_date));
    }

    protected function getSensors($checkPoint)
    {
        return $this->getSensorsByCheckPoint($checkPoint->id)
            ->whereIn('type_id',function($query){
                $query->select('id')->from('sensor_types')
                    ->whereIn('slug',[
                        'tx-nivel',
                        'caudal-dga-arkon-modbus',
                        'caudal-dga-siemens-modbus',
                        'caudal-dga-wellford-corriente',
                        'caudal-dga-wellford-modbus',
                        'totalizador-dga-arkon-modbus',
                        'totalizador-dga-siemens-modbus',
                        'totalizador-dga-wellford-modbus',
                        'totalizador-dga-wellford-pulsos'
                    ]);
            })->get();
    }
}
