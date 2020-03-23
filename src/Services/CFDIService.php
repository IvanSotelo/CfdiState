<?php

namespace IvanSotelo\CfdiState\Services;

use SoapClient;
use SoapVar;

class CFDIService
{
    private $soapClientFactory;
    protected $expression;
    protected $url = 'https://consultaqr.facturaelectronica.sat.gob.mx/ConsultaCFDIService.svc';

    public function __construct($expression)
    {
        if (config('cfdi-state.production_mode') != false) {
            $this->url = 'https://pruebacfdiconsultaqr.cloudapp.net/ConsultaCFDIService.svc';
        }
        $this->expression = $expression;
        $this->soapClientFactory = new SoapClientFactory();
    }

    public function send()
    {
        // prepare call
        /** @var int $encoding Override because inspectors does not know that second argument can be NULL */
        $encoding = null;
        $soapClient = $this->soapClientFactory->create($this->url);
        $arguments = [
            new SoapVar($this->expression, $encoding, '', '', 'expresionImpresa', 'http://tempuri.org/'),
        ];
        $options = [
            'soapaction' => 'http://tempuri.org/IConsultaCFDIService/Consulta',
        ];

        $response = $this->callConsulta($soapClient, $arguments, $options);
        return $response;
    }


    /**
     * This method is abstracted here to be able to mock responses in tests.
     *
     * @param SoapClient $soapClient
     * @param array $arguments
     * @param array $options
     * @return stdClass|array|false
     */
    protected function callConsulta(SoapClient $soapClient, array $arguments, array $options)
    {
        return $soapClient->__soapCall('Consulta', $arguments, $options);
    }
}