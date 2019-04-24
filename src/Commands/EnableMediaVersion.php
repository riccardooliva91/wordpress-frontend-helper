<?php

namespace Wpfh\Commands;

/**
 * Class EnableMediaVersion
 * @package Wpfh\Commands
 *
 * Command signature: wp wpfh-media-version <on|off> <threshold>
 */
class EnableMediaVersion extends Command {

	/**
	 * @inheritdoc
	 */
	public function __invoke( array $args ) {
		// @codeCoverageIgnoreStart
		if ( ! in_array( $args[0], [ 'on', 'off' ] ) ) {
			$this->exit_with_error( 'Invalid flag. Type "wp help wpfh-media-version" for more information.' );
		}
		if ( isset( $args[1] ) && ( ! is_numeric( $args[1] ) || $args[1] < 0 ) ) {
			$this->exit_with_error( 'Invalid threshold. Type "wp help wpfh-media-version" for more information.' );
		}
		// @codeCoverageIgnoreEnd

		$options       = \Wpfh\WpfhOptions::init();
		$media_options = $options->get( 'media' );
		$flag          = $args[0];
		$threshold     = $args[1] ?? 0;

		$media_options['enable_version']     = 'on' === $flag ? true : false;
		$media_options['auto_bust_interval'] = (int) $threshold;

		$options->set( 'media', $media_options, true );
		$this->console_log( 'Options updated!', 'success' );
	}

	/**
	 * @inheritdoc
	 *
	 * @codeCoverageIgnore
	 */
	public function get_name(): string {
		return 'wpfh-media-version';
	}

	/**
	 * @inheritdoc
	 *
	 * @codeCoverageIgnore
	 */
	public function get_arguments(): array {
		return [
			'shortdesc' => 'Activate/deactivate the media version.',
			'synopsis'  => [
				[
					'type'        => 'positional',
					'name'        => 'flag',
					'description' => 'Turns on/off the media version',
					'optional'    => false,
					'repeating'   => false,
				],
				[
					'type'        => 'positional',
					'name'        => 'threshold',
					'description' => 'Set an expiration time. Should be >= 0.',
					'optional'    => true,
					'repeating'   => false,
				]
			],
			'when'      => 'plugins_loaded',
			'longdesc'  => '## EXAMPLES' . "\n\n" . 'wp wpfh-media-version on 3600' . PHP_EOL . 'wp wpfh-media-version off' . "\n\n" . 'If the threshold is set to 0 the version won\'t be updated automatically.',
		];
	}

}