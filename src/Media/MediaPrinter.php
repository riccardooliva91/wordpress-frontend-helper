<?php

namespace Wpfh\Media;

use Wpfh\WpfhOptions;
use Wpfh\Media\MediaTag;

/**
 * Class MediaPrinter
 * @package Wpfh\Media
 */
class MediaPrinter {

	/**
	 * @var WpfhOptions
	 */
	protected $options;

	/**
	 * @var array
	 */
	protected $saved_media = [];

	/**
	 * MediaPrinter constructor.
	 *
	 * @param WpfhOptions $options
	 */
	private function __construct( WpfhOptions $options ) {
		$this->options = $options;
	}

	/**
	 * CLass init
	 *
	 * @param WpfhOptions $options
	 *
	 * @return MediaPrinter
	 */
	public static function init( WpfhOptions $options ): MediaPrinter {
		static $obj = null;
		if ( ! $obj ) {
			$obj = new static( $options );

			$obj->guess_version_tag();
		}

		return $obj;
	}

	/**
	 * Save a media for later use
	 *
	 * @param string $name
	 * @param string $tag
	 * @param array $meta = []
	 *
	 * @return MediaPrinter
	 */
	public function save_media( string $name, string $tag, array $meta = [] ): MediaPrinter {
		$this->saved_media[ $name ] = $this->get_tag( $tag, $meta );

		return $this;
	}

	/**
	 * Get a saved media
	 *
	 * @param string $name
	 * @param mixed $default = false
	 *
	 * @return mixed
	 */
	public function get( string $name, $default = false ) {
		return $this->saved_media[ $name ] ?? $default;
	}

	/**
	 * Echoes a saved media
	 *
	 * @param string $name
	 *
	 * @return void
	 */
	public function write( string $name ) {
		echo $this->saved_media[ $name ] ?? '';
	}

	/**
	 * Get a media tag html
	 *
	 * @param string $tag
	 * @param array $meta = []
	 *
	 * @return string
	 */
	public function get_tag( string $tag, array $meta = [] ): string {
		$media      = MediaTag::init( $this->options->get( 'media' ) );
		$media->tag = $tag;
		foreach ( $meta as $key => $value ) {
			$media->$key = $value;
		}

		return $media;
	}

	/**
	 * Echoes a media tag html
	 *
	 * @param string $tag
	 * @param array $meta = []
	 *
	 * @return void
	 */
	public function write_tag( string $tag, array $meta = [] ) {
		echo $this->get_tag( $tag, $meta );
	}

	/**
	 * Read the .wpfh_cb file if needed and updates the options
	 *
	 * @return void
	 *
	 * @codeCoverageIgnore
	 */
	protected function guess_version_tag() {
		$media_options = $this->options->get( 'media' );
		$wpfh_cb       = get_template_directory() . '/.wpfh_cb';

		if ( ! $media_options['enable_version'] && file_exists( $wpfh_cb ) ) {
			$media_options['enable_version'] = true;
			$media_options['version_tag']    = trim( file_get_contents( $wpfh_cb ) );

			$this->options->set( 'media', $media_options );
		}
	}
}