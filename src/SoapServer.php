<?php
namespace Afonso\Soapi;

use League\Pipeline\Pipeline;
use League\Pipeline\StageInterface;
use SoapServer as NativeSoapServer;

/**
 * A enhanced, drop-in replacement for PHP's
 * native SoapServer class.
 *
 * This server includes input and output
 * pipelines to aribtrarily modify requests
 * and responses.
 *
 */
class SoapServer extends NativeSoapServer
{
	// protected $autoresponse = true;

	/**
	 * The inbound pipeline.
	 *
	 * @var	League\Pipeline\Pipeline
	 */
	protected $inboundPipeline;

	/**
	 * The outbound pipeline.
	 *
	 * @var	League\Pipeline\Pipeline
	 */
	protected $outboundPipeline;

	/**
	 * Creates and returns a new SoapServer
	 * with empty inbound and outbound pipelines.
	 *
	 * @param	string|null	$wsdl
	 * @param	array		$options
	 * @return	SoapServer
	 */
	public function __construct($wsdl, array $options = array()/*, $autoresponse = true*/)
	{
		parent::__construct($wsdl, $options);
		// $this->autoresponse = $autoresponse;

		// initialize in and outbound pipelines
		$this->inboundPipeline = new Pipeline();
		$this->outboundPipeline = new Pipeline();
	}

	/**
	 * Adds a new stage to the inbound pipeline.
	 *
	 * @param	League\Pipeline\StageInterface	$stage
	 */
	public function addInboundPipelineStage(StageInterface $stage)
	{
		$this->inboundPipeline = $this->inboundPipeline->pipe($stage);
	}

	/**
	 * Adds a new stage to the outbound pipeline.
	 *
	 * @param	League\Pipeline\StageInterface	$stage
	 */
	public function addOutboundPipelineStage(StageInterface $stage)
	{
		$this->outboundPipeline = $this->outboundPipeline->pipe($stage);
	}

	/**
	 * Handles a SOAP request.
	 *
	 * This function delegates on PHP's native
	 * SoapServer handle(), but processes the input
	 * XML through the inbound and outbound pipelines.
	 * This allows for arbitrary manipulation of
	 * requests and responses, such as encryption or
	 * logging.
	 *
	 * Just as the parent class, this function will
	 * fetch the input from the POST data if none is
	 * passed as an argument. Likewise, it will return
	 * nothing and output the response instead.
	 *
	 * @param	string|null	$soapRequest
	 */
	public function handle($soapRequest = null)
	{
		if (! $soapRequest) {
			$soapRequest = file_get_contents('php://input');
		}

		/*
		 * Run the request XML through the inbound
		 * pipeline
		 */
		$soapRequest = $this->inboundPipeline->process($soapRequest);

		/*
		 * Execute the request
		 */
		ob_start();
		parent::handle($soapRequest);
		$soapResponse = ob_get_clean();

		/*
		 * The run the response through the outbound
		 * pipeline
		 */
		$soapResponse = $this->outboundPipeline->process($soapResponse);

		/*
		 * Output the response and we're done
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
