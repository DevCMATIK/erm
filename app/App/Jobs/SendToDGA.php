<?php

namespace App\App\Jobs;

use App\App\Controllers\Soap\InstanceSoapClient;
use App\App\Controllers\Soap\SoapController;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use SoapHeader;

class SendToDGA extends SoapController implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $totalizador;
    public $caudal;
    public $nivelFreatico;
    public $codigoDeObra;
    public $checkPoint;


    public function __construct($totalizador,$caudal,$nivelFreatico,$codigoDeObra,$checkPoint)
    {

        $this->totalizador = $totalizador;
        $this->caudal = $caudal;
        $this->nivelFreatico = $nivelFreatico;
        $this->codigoDeObra = $codigoDeObra;
        $this->checkPoint = $checkPoint;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->ReportToDGA($this->totalizador,$this->caudal,$this->nivelFreatico,$this->codigoDeObra,$this->checkPoint);
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
                        'caudal' => number_format(($caudal<0)?0:$caudal,2,'.',''),
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
