<?php

namespace Wpfh\Commands;

/**
 * Class CommandsLoader
 * @package Wpfh\Commands
 */
class CommandsLoader {

	/**
	 * Load commands
	 *
	 * @return void
	 */
	public static function build() {
		$obj = null;
		if ( ! $obj ) {
			$obj = new static;

			$commands = [
				new EnableMediaVersion()
			];

			foreach ( $commands as $command ) {
				\WP_CLI::add_command( $command->get_name(), $command, $command->get_arguments() );
			}
		}
	}

}