<?php

namespace Wpfh\Exceptions;

/**
 * Class MethodNotFound
 * @package Wpfh\Exceptions
 *
 * @codeCoverageIgnore
 */
class MethodNotFound extends \Exception {

	/**
	 * GlobalNotInstantiated constructor.
	 *
	 * @param string $method
	 */
	public function __construct( string $method ) {
		parent::__construct( sprintf( 'The %s method was not found inside %s', $method, debug_backtrace()[1]['class'] ), 500, null );
	}

}