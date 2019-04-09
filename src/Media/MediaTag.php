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
	 * TagGenerator constructor.
	 *
	 * @param array $media_options = []
	 */
	public function __construct( array $media_options = [] ) {
		$this->media_options = $media_options;
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
		return $this->meta[ $name ] ?? null;
	}

	/**
	 * Echo the HTML
	 *
	 * @return string
	 */
	public function __toString(): string {
		$data = [];
		foreach ( $this->meta as $key => $value ) {
			$data[] = is_null( $value ) ? $key : sprintf( '%s="%s"', $key, $value );
		}
		$data[] = '/';

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