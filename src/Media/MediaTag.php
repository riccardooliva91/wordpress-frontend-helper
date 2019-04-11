<?php

namespace Wpfh\Media;

/**
 * Class MediaTag
 * @package Wpfh\Media
 */
class MediaTag {

	/**
	 * @var array
	 */
	protected $media_options = [];

	/**
	 * @var string
	 */
	protected $tag = '';

	/**
	 * @var array
	 */
	protected $meta = [];

	/**
	 * MediaTag constructor.
	 *
	 * @param array $media_options = []
	 */
	private function __construct( array $media_options = [] ) {
		$this->media_options = $media_options;
	}

	/**
	 * MediaTag init.
	 *
	 * @param array $media_options = []
	 *
	 * @return MediaTag
	 */
	public static function init( array $media_options = [] ): MediaTag {
		return new self( $media_options );
	}

	/**
	 * Dynamic property set
	 *
	 * @param string $name
	 * @param mixed $value
	 *
	 * @return MediaTag
	 */
	public function __set( string $name, $value ): MediaTag {
		if ( 'tag' == $name && is_string( $value ) ) {
			$this->tag = strtolower( $value );
		} else {
			$this->meta[ $this->handle_camel_case( $name ) ] = $value;
		}

		return $this;
	}

	/**
	 * Dynamic property get
	 *
	 * @param string $name
	 *
	 * @return mixed
	 */
	public function __get( string $name ) {
		return ( 'tag' === $name ) ? $this->tag : $this->meta[ $this->handle_camel_case( $name ) ] ?? null;
	}

	/**
	 * Echo the HTML. Applies the version
	 *
	 * @return string
	 */
	public function __toString(): string {
		$data = [];
		foreach ( $this->meta as $key => $value ) {
			if ( 'src' === $key && null !== $value ) {
				$value = empty( $this->media_options['enable_version'] ) ? $value : sprintf( '%s?v=%s', $value, $this->media_options['version_tag'] );
			}
			$data[] = null !== $value ? sprintf( '%s="%s"', $key, $value ) : $key;
		}
		if ( ! empty( $data ) ) {
			array_unshift( $data, '' );
			$data[] = '';
		}

		return sprintf( '<%s%s/>', $this->tag, empty( $data ) ? ' ' : implode( ' ', $data ) );
	}

	/**
	 * Converts a camel case string to multiple words separated by '-'
	 *
	 * @param string $name
	 *
	 * @return string
	 */
	protected function handle_camel_case( string $name ): string {
		return strtolower( implode( '-', preg_split( '/(?=[A-Z])/', $name ) ) );
	}

}