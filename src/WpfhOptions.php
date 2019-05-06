<?php

namespace Wpfh;

use Wpfh\Media\MediaTag;

/**
 * Class WpfhOptions
 * @package Wpfh
 */
class WpfhOptions {

	/**
	 * @var string
	 */
	private $options_group_name = 'wpfh_options';

	/**
	 * @var array
	 */
	private $options;

	/**
	 * Init object
	 *
	 * @return WpfhOptions
	 */
	public static function init(): WpfhOptions {
		static $obj = null;
		if ( ! $obj ) {
			$obj          = new static();
			$obj->options = get_option( $obj->options_group_name );
			if ( false === $obj->options ) {
				$obj->init_options();
			} elseif ( $obj->options['plugin_version'] < WPFH_VERSION ) {
				$obj->version_update();
			}

			add_filter( 'wpfh/get_options', [ $obj, 'get_object' ] );
		}

		return $obj;
	}

	/**
	 * Returns an instance of this class
	 *
	 * @return WpfhOptions
	 */
	public function get_object(): WpfhOptions {
		return $this;
	}

	/**
	 * Returns the option group name
	 *
	 * @return string
	 */
	public function get_group_name(): string {
		return $this->options_group_name;
	}

	/**
	 * Get option
	 *
	 * @param string $option_name
	 * @param mixed $default = false
	 *
	 * @return mixed
	 */
	public function get( string $option_name, $default = false ) {
		return $this->options[ $option_name ] ?? $default;
	}

	/**
	 * Set an option
	 *
	 * @param string $option_name
	 * @param mixed $value
	 * @param bool $save = false
	 *
	 * @return WpfhOptions
	 */
	public function set( string $option_name, $value, bool $save = false ): WpfhOptions {
		$this->options[ $option_name ] = $value;
		if ( $save ) {
			update_option( $this->options_group_name, $this->options );
		}

		return $this;
	}

	/**
	 * Default options values
	 *
	 * @return array
	 */
	protected function get_defaults(): array {
		return [
			'media' => [
				'enable_version'      => false,
				'version_tag'         => '',
				'auto_bust_threshold' => 0,
				'auto_bust_interval'  => 0,
			]
		];
	}

	/**
	 * Init options on first activation
	 *
	 * @return void
	 */
	protected function init_options() {
		$this->options                   = $this->get_defaults();
		$this->options['plugin_version'] = WPFH_VERSION;
		add_option( $this->options_group_name, $this->options );
	}

	/**
	 * Update existing options on plugin update
	 *
	 * @return void
	 */
	protected function version_update() {
		$this->options                   = array_replace_recursive( $this->get_defaults(), $this->options );
		$this->options['plugin_version'] = WPFH_VERSION;
		update_option( $this->options_group_name, $this->options );
	}
}