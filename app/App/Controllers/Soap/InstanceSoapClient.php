<?php
namespace App\App\Controllers\Soap;

use SoapClient;

class InstanceSoapClient extends SoapController implements InterfaceInstanceSoap
{
    public static function init(){
        $wsdlUrl = self::getWsdl();

        $soapClientOptions = [
            'stream_context' => self::generateContext(),
            'cache_wsdl'     => WSDL_CACHE_NONE,
            'trace' => true,
            'keep_alive' => false,
            'connection_timeout' => 60000,
        ];

        return new SoapClient($wsdlUrl, $soapClientOptions);
    }
}
