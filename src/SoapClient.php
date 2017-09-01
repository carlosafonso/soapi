<?php

namespace Afonso\Soapi;

use League\Pipeline\Pipeline;
use SoapClient as NativeSoapClient;

/**
 * A enhanced, drop-in replacement for PHP's native SoapClient class.
 *
 * This client includes input and output pipelines to aribtrarily modify
 * requests and responses.
 */
class SoapClient extends NativeSoapClient
{
    use ProcessesWithPipelines;

    /**
     * Creates and returns a new SoapClient with empty inbound and outbound
     * pipelines.
     *
     * @param   string|null $wsdl
     * @param   array       $options
     */
    public function __construct($wsdl, array $options = array())
    {
        parent::__construct($wsdl, $options);

        // initialize in and outbound pipelines
        $this->inboundPipeline = new Pipeline();
        $this->outboundPipeline = new Pipeline();
    }

    /**
     * Performs a SOAP request.
     *
     * This function delegates on PHP's native SoapClient __doRequest(), but
     * processes the payload through the oubtound and inbound pipelines. This
     * allows for arbitrary manipulation of requests and responses, such as
     * encryption or logging.
     *
     * @see     http://php.net/manual/en/soapclient.dorequest.php
     * @param   string  $soapRequest
     * @param   string  $location
     * @param   string  $action
     * @param   int     $version
     * @param   int     $oneWay
     */
    public function __doRequest($soapRequest, $location, $action, $version, $oneWay = 0)
    {
        /*
         * Run the request XML through the outbound pipeline.
         */
        $soapRequest = $this->outboundPipeline->process($soapRequest);

        /*
         * Do the actual request.
         */
        $soapResponse = parent::__doRequest($soapRequest, $location, $action, $version, $oneWay);

        /*
         * Then run the response through the inbound pipeline.
         */
        $soapResponse = $this->inboundPipeline->process($soapResponse);
        return $soapResponse;
    }
}
