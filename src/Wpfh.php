<?php

namespace Wpfh;

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
	 * Wpfh constructor.
	 *
	 * @param AssetsManager $assets
	 */
	private function __construct( AssetsManager $assets ) {
		$this->assets_manager    = $assets;
	}

	/**
	 * Builder
	 *
	 * @param AssetsManager $assets
	 *
	 * @return Wpfh
	 */
	public static function init( AssetsManager $assets ): self {
		$obj = null;
		if ( ! $obj ) {
			$obj = new static( $assets );

			add_filter( 'wpfh/get_helper', [ $obj, 'get_helper' ] );
			add_filter( 'wpfh/get_assets_manager', [ $obj, 'get_assets_manager' ] );
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

}
