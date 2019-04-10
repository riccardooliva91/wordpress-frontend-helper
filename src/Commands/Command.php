<?php

namespace Wpfh\Commands;

/**
 * Class Command
 * @package Wpfh\Commands
 */
abstract class Command {

	/**
	 * Setup the command name
	 *
	 * @return string
	 */
	public abstract function get_name(): string;

	/**
	 * Setup the command arguments.
	 *
	 * @return array
	 */
	public abstract function get_arguments(): array;

	/**
	 * Command execution
	 *
	 * @param array $args
	 *
	 * @return void
	 */
	public abstract function __invoke( array $args );

	/**
	 * Logs a message
	 *
	 * @param string $message
	 * @param string $severity = 'log'
	 *
	 * @return void
	 *
	 * @codeCoverageIgnore
	 */
	protected function console_log( string $message, string $severity = 'log' ) {
		\WP_CLI::$severity( $message );
	}

	/**
	 * Exits with a log
	 *
	 * @param string $message
	 *
	 * @return void
	 *
	 * @codeCoverageIgnore
	 */
	protected function exit_with_error( string $message ) {
		$this->console_log( 'Something went wrong: ' . $message, 'error' );
		exit();
	}
}