<?php

namespace Wpfh\Assets;

use \Wpfh\Assets\AssetObserver;
use \Wpfh\Exceptions\MethodNotFound;

/**
 * Class AssetsManager
 * @package Wpfh\Assets
 *
 * @method enqueue_style
 * @method enqueue_script
 * @method register_style
 * @method register_script
 * @method dequeue_style
 * @method dequeue_script
 * @method deregister_style
 * @method deregister_script
 */
class AssetsManager {

	/**
	 * @var AssetObserver
	 */
	protected $observer;

	/**
	 * @var array
	 */
	protected $supported_actions = [
		'enqueue_script',
		'enqueue_style',
		'register_script',
		'register_style',
		'dequeue_script',
		'dequeue_style',
		'deregister_script',
		'deregister_style'
	];

	/**
	 * @var array
	 */
	protected $conditions = [];

	/**
	 * AssetsManager constructor.
	 *
	 * @param AssetObserver $observer
	 */
	protected function __construct( AssetObserver $observer ) {
		$this->observer = $observer;
	}

	/**
	 * Builder
	 *
	 * @param \Wpfh\Assets\AssetObserver $observer
	 *
	 * @return AssetsManager
	 */
	public static function init( AssetObserver $observer ): self {
		static $obj = null;
		if ( ! $obj ) {
			$obj = new static( $observer );
		}

		return $obj;
	}

	/**
	 * Intercepts calls.
	 * Possible functions names are listed on the class PHPDocs
	 *
	 * Each method should be called with these parameters:
	 *      - array $args                   The arguments to pass to the relative wp function. It should be an array in case there are multiple arguments, it can be the handler if there's only one
	 *      - bool|callable $condition      (optional) the value/evaluation in order to perform the wp action
	 *      - array $condition_args         (optional) the array of the arguments the condition uses, if it is a callable
	 *
	 * @param string $name
	 * @param array $arguments
	 *
	 * @return self
	 * @throws MethodNotFound
	 */
	public function __call( string $name, array $arguments ): self {
		if ( ! in_array( $name, $this->supported_actions ) ) {
			throw new MethodNotFound( $name );
		}

		$segments        = explode( '_', $name );
		$wp_action       = 'wp_' . $name;
		$observer_action = $segments[0];
		$type            = $segments[1];
		$args            = $arguments[0];
		$condition       = $arguments[1] ?? true;
		$condition_args  = $arguments[2] ?? [];
		if ( $this->evaluate_condition( $condition, $condition_args ) ) {
			if ( is_array( $args ) ) {
				$wp_action( ...$args );
			} else {
				$wp_action( $args );
			}
			$this->observer->$observer_action( is_array( $args ) ? $args[0] : $args, $type );
		}

		return $this;
	}

	/**
	 * Save a condition
	 *
	 * @param string $name
	 * @param bool|callable $handler
	 * @param array $handler_args
	 *
	 * @return AssetsManager
	 */
	public function add_condition( string $name, $handler = false, array $handler_args = [] ): self {
		$this->conditions[ $name ] = compact( 'handler', 'handler_args' );

		return $this;
	}

	/**
	 * Shorthand, more generic version of 'apply_condition'
	 *
	 * @param string|bool|callable $condition
	 *
	 * @return bool
	 */
	public function if( $condition ): bool {
		if ( is_string( $condition ) ) {
			return $this->apply_condition( $condition );
		} elseif ( is_bool( $condition ) ) {
			return $condition;
		} elseif ( is_callable( $condition ) ) {
			return boolval( $condition() );
		}

		return false;
	}

	/**
	 * Apply a condition
	 *
	 * @param string $name
	 * @param array $handler_args = []
	 *
	 * @return bool
	 */
	public function apply_condition( string $name, array $handler_args = [] ): bool {
		if ( ! isset( $this->conditions[ $name ] ) ) {
			return false;
		}

		if ( is_bool( $this->conditions[ $name ]['handler'] ) ) {
			return $this->conditions[ $name ]['handler'];
		} elseif ( is_callable( $this->conditions[ $name ]['handler'] ) ) {
			$args = empty( $handler_args ) ? $this->conditions[ $name ]['handler_args'] : $handler_args;

			return (bool) $this->conditions[ $name ]['handler']( ... $args );
		}

		return false;
	}

	/**
	 * Evaluates the condition in order to proceed with the requested operation
	 *
	 * @param bool|callable $condition
	 * @param array $condition_args
	 *
	 * @return bool
	 */
	protected function evaluate_condition( $condition, $condition_args ) {
		if ( is_bool( $condition ) ) {
			return $condition;
		} elseif ( is_callable( $condition ) ) {
			return $condition( ...$condition_args );
		}

		return false;
	}
}