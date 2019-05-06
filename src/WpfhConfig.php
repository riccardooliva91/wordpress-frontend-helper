<?php

namespace Wpfh;

/**
 * Class WpfhConfig
 * @package Wpfh
 */
class WpfhConfig {

	/**
	 * @var array
	 */
	protected $config = [
		'wpfh_init_hook'             => 'after_setup_theme',
		'wpfh_helper_class'          => \Wpfh\Wpfh::class,
		'wpfh_assets_manager_class'  => \Wpfh\Assets\AssetsManager::class,
		'wpfh_assets_observer_class' => \Wpfh\Assets\AssetObserver::class,
		'wpfh_media_printer_class'   => \Wpfh\Media\MediaPrinter::class,
		'wpfh_media_tag_class'       => \Wpfh\Media\MediaTag::class,
	];

	/**
	 * WpfhConfig constructor.
	 */
	protected function __construct() {
		// Nothing to do here
	}

	/**
	 * Init method
	 *
	 * @return WpfhConfig
	 */
	public static function init(): WpfhConfig {
		static $obj = null;
		if ( ! $obj ) {
			$obj = new static();

			add_filter( 'wpfh/get_config', [ $obj, 'get_config' ] );
			add_filter( 'wpfh/merge_config', [ $obj, 'merge_config' ] );
			add_filter( 'wpfh/get_config_object', [ $obj, 'get_object' ] );
		}

		return $obj;
	}

	/**
	 * Returns this
	 *
	 * @return WpfhConfig
	 *
	 * @codeCoverageIgnore
	 */
	public function get_object(): WpfhConfig {
		return $this;
	}

	/**
	 * Returns the current config
	 *
	 * @return array
	 *
	 * @codeCoverageIgnore
	 */
	public function get_config(): array {
		return $this->config;
	}

	/**
	 * Returns a specific config
	 *
	 * @param string $name
	 * @param mixed $default = false
	 *
	 * @return mixed
	 */
	public function get( string $name, $default = false ) {
		return $this->config[ $name ] ?? $default;
	}

	/**
	 * Updates the config
	 *
	 * @param array $custom
	 *
	 * @return WpfhConfig
	 */
	public function merge_config( array $custom ): WpfhConfig {
		$this->config = array_merge( $this->config, $custom );

		return $this;
	}
}