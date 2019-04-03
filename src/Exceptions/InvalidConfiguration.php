<?php

namespace Wpfh\Exceptions;

/**
 * Class InvalidConfiguration
 * @package Wpfh\Exceptions
 *
 * @codeCoverageIgnore
 */
class InvalidConfiguration extends \Exception {

	/**
	 * GlobalNotInstantiated constructor.
	 *
	 * @param string $message
	 */
	public function __construct( string $message ) {
		parent::__construct( $message, 500, null );
	}

}