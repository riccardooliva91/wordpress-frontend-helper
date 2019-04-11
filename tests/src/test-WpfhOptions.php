<?php

namespace Test\Wpfh;

use Brain\Monkey\Filters;
use Brain\Monkey\Functions;

/**
 * Class WpfhOptions
 * @package Test\Wpfh
 *
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class WpfhOptions extends \WpfhTestCase {

	public function test_init_init_options() {
		define( 'WPFH_VERSION', null );
		Functions\expect( 'get_option' )->once()->andReturn( false );
		Functions\expect( 'add_option' )->once()->andReturn( false );
		Functions\expect( 'update_option' )->never();
		Filters\expectAdded( 'wpfh/get_options' )->once();

		$test = \Wpfh\WpfhOptions::init();

		$this->assertInstanceOf( \Wpfh\WpfhOptions::class, $test );
	}

	public function test_init_update_options() {
		define( 'WPFH_VERSION', 1000 );
		Functions\expect( 'get_option' )->once()->andReturn( [ 'plugin_version' => 1 ] );
		Functions\expect( 'add_option' )->never();
		Functions\expect( 'update_option' )->once()->andReturn( false );
		Filters\expectAdded( 'wpfh/get_options' )->once();

		$test = \Wpfh\WpfhOptions::init();

		$this->assertInstanceOf( \Wpfh\WpfhOptions::class, $test );
	}

	public function test_get_object() {
		define( 'WPFH_VERSION', null );
		Functions\expect( 'get_option' )->once()->andReturn( false );
		Functions\expect( 'add_option' )->once()->andReturn( false );
		Filters\expectAdded( 'wpfh/get_options' )->once();

		$test = \Wpfh\WpfhOptions::init();

		$this->assertSame( $test, $test->get_object() );
	}

	public function test_get_group_name() {
		define( 'WPFH_VERSION', null );
		Functions\expect( 'get_option' )->once()->andReturn( false );
		Functions\expect( 'add_option' )->once()->andReturn( false );
		Filters\expectAdded( 'wpfh/get_options' )->once();

		$test = \Wpfh\WpfhOptions::init();

		$this->assertEquals( 'wpfh_options', $test->get_group_name() );
	}

	public function test_get() {
		define( 'WPFH_VERSION', null );
		Functions\expect( 'get_option' )->once()->andReturn( false );
		Functions\expect( 'add_option' )->once()->andReturn( false );
		Functions\expect( 'update_option' )->never();
		Filters\expectAdded( 'wpfh/get_options' )->once();

		$test = \Wpfh\WpfhOptions::init();

		$this->assertIsArray( $test->get( 'media' ) );
	}

	public function test_get_invalid() {
		define( 'WPFH_VERSION', null );
		Functions\expect( 'get_option' )->once()->andReturn( false );
		Functions\expect( 'add_option' )->once()->andReturn( false );
		Functions\expect( 'update_option' )->never();
		Filters\expectAdded( 'wpfh/get_options' )->once();

		$test = \Wpfh\WpfhOptions::init();

		$this->assertFalse( $test->get( 'i_do_not_exist' ) );
	}

	public function test_set() {
		define( 'WPFH_VERSION', null );
		Functions\expect( 'get_option' )->once()->andReturn( false );
		Functions\expect( 'add_option' )->once()->andReturn( false );
		Functions\expect( 'update_option' )->once()->andReturn( false );
		Filters\expectAdded( 'wpfh/get_options' )->once();

		$test = \Wpfh\WpfhOptions::init();

		$this->assertSame( $test, $test->set( 'new', 'value', true ) );
		$this->assertEquals( 'value', $test->get( 'new' ) );
	}

}