<?php

namespace Wpfh\Assets;

use \Wpfh\Exceptions\MethodNotFound;

/**
 * Class AssetObserver
 * @package Wpfh\Assets
 *
 * @method enqueue
 * @method register
 * @method dequeue
 * @method deregister
 */
class AssetObserver {

	/**
	 * @var array
	 */
	protected $supported_actions = [ 'enqueue', 'register', 'dequeue', 'deregister' ];

	/**
	 * Init
	 *
	 * @return AssetObserver
	 */
	public static function init(): self {
		static $obj = null;
		if ( ! $obj ) {
			$obj = new static();
		}

		return $obj;
	}

	/**
	 * Intercepts styles and scripts actions. Registers a dedicated filter.
	 *
	 * @param string $name
	 * @param array $arguments [ 'handle', 'type' ]
	 *
	 * @return void
	 * @throws MethodNotFound
	 */
	public function __call( string $name, array $arguments ) {
		if ( ! in_array( $name, $this->supported_actions ) ) {
			throw new MethodNotFound( $name );
		}
		if ( empty( $arguments ) ) {
			return;
		}

		apply_filters( sprintf( 'wpfh/on_%s_%s', $arguments[1], $name ), null );  // Generic (i.e. 'on_script_enqueue')
		apply_filters( sprintf( 'wpfh/on_%s_%s', $arguments[0], $name ), null );  // Specific (i.e. 'on_jquery_enqueue')
	}

}
