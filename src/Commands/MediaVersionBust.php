<?php

namespace Wpfh\Commands;

/**
 * Class MediaVersionBust
 * @package Wpfh\Commands
 *
 * Command signature: wp wpfh-media-version-bust
 */
class MediaVersionBust extends Command {

	/**
	 * @inheritdoc
	 */
	public function __invoke( array $args ) {
		$options       = \Wpfh\WpfhOptions::init();
		$media_options = $options->get( 'media' );

		$media_options['version_tag'] = uniqid();

		$options->set( 'media', $media_options, true );
		$this->console_log( 'Version tag updated!', 'success' );
	}

	/**
	 * @inheritdoc
	 *
	 * @codeCoverageIgnore
	 */
	public function get_name(): string {
		return 'wpfh-media-version-bust';
	}

	/**
	 * @inheritdoc
	 *
	 * @codeCoverageIgnore
	 */
	public function get_arguments(): array {
		return [
			'shortdesc' => 'Update the media version tag, busting the cache.',
			'when'      => 'plugins_loaded',
			'longdesc'  => '## EXAMPLES' . "\n\n" . 'wp wpfh-media-version-bust',
		];
	}

}