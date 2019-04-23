<?php

namespace Wpfh;

use Wpfh\Media\MediaPrinter;
use Wpfh\Assets\AssetsManager;
use Wpfh\Templating\TemplatingEngine;

/**
 * Class Wpfh
 * @package Wpfh
 */
class Wpfh {

	/**
	 * @var AssetsManager
	 */
	private $assets_manager;

	/**
	 * @var MediaPrinter
	 */
	private $media_printer;

	/**
	 * Builder
	 *
	 * @return Wpfh
	 */
	public static function init(): self {
		$obj = null;
		if ( ! $obj ) {
			$obj = new static();

			add_filter( 'wpfh/get_helper', [ $obj, 'get_helper' ] );
			add_filter( 'wpfh/get_assets_manager', [ $obj, 'get_assets_manager' ] );
			add_filter( 'wpfh/get_media_printer', [ $obj, 'get_media_printer' ] );
		}

		return $obj;
	}

	/**
	 * Returns an instance of this wrapper
	 *
	 * @return Wpfh
	 *
	 * @codeCoverageIgnore
	 */
	public function get_helper(): self {
		return $this;
	}

	/**
	 * Get the assets manager
	 *
	 * @return AssetsManager
	 *
	 * @codeCoverageIgnore
	 */
	public function get_assets_manager(): AssetsManager {
		return $this->assets_manager;
	}

	/**
	 * Set the assets manager
	 *
	 * @param AssetsManager $assets
	 *
	 * @return Wpfh
	 *
	 * @codeCoverageIgnore
	 */
	public function set_assets_manager( AssetsManager $assets ): Wpfh {
		$this->assets_manager = $assets;

		return $this;
	}

	/**
	 * Get the assets manager
	 *
	 * @return MediaPrinter
	 *
	 * @codeCoverageIgnore
	 */
	public function get_media_printer(): MediaPrinter {
		return $this->media_printer;
	}

	/**
	 * Set the assets manager
	 *
	 * @param MediaPrinter $printer
	 *
	 * @return Wpfh
	 *
	 * @codeCoverageIgnore
	 */
	public function set_media_printer( MediaPrinter $printer ): Wpfh {
		$this->media_printer = $printer;

		return $this;
	}

}
