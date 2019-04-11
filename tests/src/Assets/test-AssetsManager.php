<?php

namespace Test\Wpfh\Assets;

use Brain\Monkey\Filters;
use Brain\Monkey\Functions;

/**
 * Class Assetsmanager
 * @package Test\Wpfh\Assets
 */
class Assetsmanager extends \WpfhTestCase {

	public function test_condition_bool() {
		$test = \Wpfh\Assets\AssetsManager::init( \Wpfh\Assets\AssetObserver::init() );
		$test->add_condition( 'test', true );

		$this->assertTrue( $test->apply_condition( 'test' ) );
	}

	public function test_condition_closure() {
		$closure = function ( $arg ) {
			return $arg;
		};
		$test    = \Wpfh\Assets\AssetsManager::init( \Wpfh\Assets\AssetObserver::init() );
		$test->add_condition( 'test', $closure, [ true ] );

		$this->assertTrue( $test->apply_condition( 'test' ) );
	}

	public function test_condition_closure_args_override() {
		$closure = function ( $arg ) {
			return $arg;
		};
		$test    = \Wpfh\Assets\AssetsManager::init( \Wpfh\Assets\AssetObserver::init() );
		$test->add_condition( 'test', $closure, [ true ] );

		$this->assertFalse( $test->apply_condition( 'test', [ false ] ) );
	}

	public function test_condition_empty_name() {
		$test = \Wpfh\Assets\AssetsManager::init( \Wpfh\Assets\AssetObserver::init() );
		$test->add_condition( 'test', true );

		$this->assertFalse( $test->apply_condition( '' ) );
	}

	public function test_invalid_condition() {
		$test = \Wpfh\Assets\AssetsManager::init( \Wpfh\Assets\AssetObserver::init() );
		$test->add_condition( 'test', 'wrong' );

		$this->assertFalse( $test->apply_condition( 'test' ) );
	}

	public function test_condition_invalid_name() {
		$test = \Wpfh\Assets\AssetsManager::init( \Wpfh\Assets\AssetObserver::init() );
		$test->add_condition( 'test', true );

		$this->assertFalse( $test->apply_condition( 'another' ) );
	}

	public function test_enqueue_script() {
		Functions\expect( 'wp_enqueue_script' )
			->once()
			->with( \Mockery::type( 'string' ) )
			->andReturn( true );

		$closure = function ( $arg ) {
			return $arg;
		};

		$test = \Wpfh\Assets\AssetsManager::init( \Wpfh\Assets\AssetObserver::init() );
		$test->enqueue_script( 'jquery', $closure, [ true ] );

		$this->assertTrue( Filters\applied( 'wpfh/on_script_enqueue' ) > 0 );
		$this->assertTrue( Filters\applied( 'wpfh/on_jquery_enqueue' ) > 0 );
	}

	public function test_enqueue_style() {
		Functions\expect( 'wp_enqueue_style' )
			->once()
			->with( \Mockery::type( 'string' ), \Mockery::type( 'string' ), \Mockery::type( 'array' ), \Mockery::type( 'bool' ), \Mockery::type( 'string' ) )
			->andReturn( true );

		$closure = function ( $arg ) {
			return $arg;
		};

		$test = \Wpfh\Assets\AssetsManager::init( \Wpfh\Assets\AssetObserver::init() );
		$test->enqueue_style( [ 'bootstrap', '', [], false, 'all' ], $closure, [ true ] );

		$this->assertTrue( Filters\applied( 'wpfh/on_style_enqueue' ) > 0 );
		$this->assertTrue( Filters\applied( 'wpfh/on_bootstrap_enqueue' ) > 0 );
	}

	public function test_register_script() {
		Functions\expect( 'wp_register_script' )
			->once()
			->with( \Mockery::type( 'string' ) )
			->andReturn( true );

		$closure = function ( $arg ) {
			return $arg;
		};

		$test = \Wpfh\Assets\AssetsManager::init( \Wpfh\Assets\AssetObserver::init() );
		$test->register_script( 'jquery', $closure, [ true ] );

		$this->assertTrue( Filters\applied( 'wpfh/on_script_register' ) > 0 );
		$this->assertTrue( Filters\applied( 'wpfh/on_jquery_register' ) > 0 );
	}

	public function test_register_style() {
		Functions\expect( 'wp_register_style' )
			->once()
			->with( \Mockery::type( 'string' ), \Mockery::type( 'string' ), \Mockery::type( 'array' ), \Mockery::type( 'bool' ), \Mockery::type( 'string' ) )
			->andReturn( true );

		$closure = function ( $arg ) {
			return $arg;
		};

		$test = \Wpfh\Assets\AssetsManager::init( \Wpfh\Assets\AssetObserver::init() );
		$test->register_style( [ 'bootstrap', '', [], false, 'all' ], $closure, [ true ] );

		$this->assertTrue( Filters\applied( 'wpfh/on_style_register' ) > 0 );
		$this->assertTrue( Filters\applied( 'wpfh/on_bootstrap_register' ) > 0 );
	}

	public function test_dequeue_script() {
		Functions\expect( 'wp_dequeue_script' )
			->once()
			->with( \Mockery::type( 'string' ) )
			->andReturn( true );

		$closure = function ( $arg ) {
			return $arg;
		};

		$test = \Wpfh\Assets\AssetsManager::init( \Wpfh\Assets\AssetObserver::init() );
		$test->dequeue_script( 'jquery', $closure, [ true ] );

		$this->assertTrue( Filters\applied( 'wpfh/on_script_dequeue' ) > 0 );
		$this->assertTrue( Filters\applied( 'wpfh/on_jquery_dequeue' ) > 0 );
	}

	public function test_dequeue_style() {
		Functions\expect( 'wp_dequeue_style' )
			->once()
			->with( \Mockery::type( 'string' ) )
			->andReturn( true );

		$test = \Wpfh\Assets\AssetsManager::init( \Wpfh\Assets\AssetObserver::init() );
		$test->dequeue_style( 'bootstrap', true );

		$this->assertTrue( Filters\applied( 'wpfh/on_style_dequeue' ) > 0 );
		$this->assertTrue( Filters\applied( 'wpfh/on_bootstrap_dequeue' ) > 0 );
	}

	public function test_deregister_script() {
		Functions\expect( 'wp_dequeue_script' )
			->once()
			->with( \Mockery::type( 'string' ) )
			->andReturn( true );

		$closure = function ( $arg ) {
			return $arg;
		};

		$test = \Wpfh\Assets\AssetsManager::init( \Wpfh\Assets\AssetObserver::init() );
		$test->dequeue_script( 'jquery', $closure, [ true ] );

		$this->assertTrue( Filters\applied( 'wpfh/on_script_dequeue' ) > 0 );
		$this->assertTrue( Filters\applied( 'wpfh/on_jquery_dequeue' ) > 0 );
	}

	public function test_deregister_style() {
		Functions\expect( 'wp_deregister_style' )
			->once()
			->with( \Mockery::type( 'string' ) )
			->andReturn( true );

		$test = \Wpfh\Assets\AssetsManager::init( \Wpfh\Assets\AssetObserver::init() );
		$test->deregister_style( 'bootstrap', true );

		$this->assertTrue( Filters\applied( 'wpfh/on_style_deregister' ) > 0 );
		$this->assertTrue( Filters\applied( 'wpfh/on_bootstrap_deregister' ) > 0 );
	}

	public function test_invalid_action() {
		$this->expectException( \Wpfh\Exceptions\MethodNotFound::class );
		$this->expectExceptionMessage( 'The invalid_action method was not found inside Wpfh\Assets\AssetsManager' );

		$test = \Wpfh\Assets\AssetsManager::init( \Wpfh\Assets\AssetObserver::init() );
		$test->invalid_action( 'bootstrap', true );
	}

	public function test_action_not_performed() {
		Functions\expect( 'wp_deregister_style' )
			->times( 0 )
			->with( \Mockery::type( 'string' ) )
			->andReturn( true );

		$test = \Wpfh\Assets\AssetsManager::init( \Wpfh\Assets\AssetObserver::init() );
		$test->deregister_style( 'bootstrap', false );

		$this->assertFalse( Filters\applied( 'wpfh/on_style_deregister' ) > 0 );
		$this->assertFalse( Filters\applied( 'wpfh/on_bootstrap_deregister' ) > 0 );
	}

	public function test_action_not_performed_invalid_condition() {
		Functions\expect( 'wp_deregister_style' )
			->times( 0 )
			->with( \Mockery::type( 'string' ) )
			->andReturn( true );

		$test = \Wpfh\Assets\AssetsManager::init( \Wpfh\Assets\AssetObserver::init() );
		$test->deregister_style( 'bootstrap', 'wrong' );

		$this->assertFalse( Filters\applied( 'wpfh/on_style_deregister' ) > 0 );
		$this->assertFalse( Filters\applied( 'wpfh/on_bootstrap_deregister' ) > 0 );
	}

	public function test_if_string() {
		$test = \Wpfh\Assets\AssetsManager::init( \Wpfh\Assets\AssetObserver::init() );
		$test->add_condition( 'test', true );

		$this->assertTrue( $test->if( 'test' ) );
	}

	public function test_if_bool() {
		$test = \Wpfh\Assets\AssetsManager::init( \Wpfh\Assets\AssetObserver::init() );

		$this->assertTrue( $test->if( true ) );
	}

	public function test_if_callable() {
		$test = \Wpfh\Assets\AssetsManager::init( \Wpfh\Assets\AssetObserver::init() );
		$callable = function() {
			return true;
		};

		$this->assertTrue( $test->if( $callable ) );
	}

	public function test_if_invalid() {
		$test = \Wpfh\Assets\AssetsManager::init( \Wpfh\Assets\AssetObserver::init() );

		$this->assertFalse( $test->if( 0 ) );
	}

}