<?php

namespace Afonso\Soapi;

use League\Pipeline\Pipeline;
use SoapServer as NativeSoapServer;

/**
 * A enhanced, drop-in replacement for PHP's native SoapServer class.
 *
 * This server includes input and output pipelines to aribtrarily modify
 * requests and responses.
 */
class SoapServer extends NativeSoapServer
{
    use ProcessesWithPipelines;

    /**
     * Creates and returns a new SoapServer with empty inbound and outbound
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
     * Handles a SOAP request.
     *
     * This function delegates on PHP's native SoapServer handle(), but
     * processes the input XML through the inbound and outbound pipelines. This
     * allows for arbitrary manipulation of requests and responses, such as
     * encryption or logging.
     *
     * Just as the parent class, this function will fetch the input from the
     * POST data if none is passed as an argument. Likewise, it will return
     * nothing and output the response instead.
     *
     * @see     http://php.net/manual/en/soapserver.handle.php
     * @param   string|null $soapRequest
     */
    public function handle($soapRequest = null)
    {
        if (! $soapRequest) {
            $soapRequest = file_get_contents('php://input');
        }

        /*
         * Run the request XML through the inbound pipeline.
         */
        $soapRequest = $this->inboundPipeline->process($soapRequest);

        /*
         * Execute the request.
         */
        ob_start();
        parent::handle($soapRequest);
        $soapResponse = ob_get_clean();

        /*
         * Then run the response through the outbound pipeline.
         */
        $soapResponse = $this->outboundPipeline->process($soapResponse);

        /*
         * Output the response and we're done.
         */
        $this->outputResponse($soapResponse);
    }

    protected function outputResponse($soapResponse)
    {
        echo $soapResponse;
        header('Content-Type: text/xml; charset=utf8');
        header('Content-Length: ' . strlen($soapResponse));
        exit(0);
    }
}
