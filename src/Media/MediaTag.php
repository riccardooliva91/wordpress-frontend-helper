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
	 * @var string
	 */
	protected $src = '';

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
		$this->media_options  = $media_options;
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
		if('tag' == $name && is_string($value)) {
			$this->tag = strtolower( $value );
		} elseif ('src' == $name && is_string($value)) {
			$this->src = $value;
		} else {

		}

		return $this;
	}

	/**
	 * Echo the HTML
	 *
	 * @return string
	 */
	public function __toString(): string {
		// TODO: Implement __toString() method.
	}
}