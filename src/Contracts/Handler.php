<?php namespace Conductor\Contracts;

interface Handler {

	/**
	 * @param Request $request
	 * @return \Conductor\Response
	 */
	public function handle(Request $request);
}
