<?php
namespace Afonso\Soapi;

use League\Pipeline\Pipeline;
use League\Pipeline\StageInterface;

trait ProcessesWithPipelines
{
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
}
