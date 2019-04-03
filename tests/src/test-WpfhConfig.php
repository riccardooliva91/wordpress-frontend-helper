<?php

namespace Test\Wpfh;

/**
 * Class WpfhConfig
 * @package Test\Wpfh
 */
class WpfhConfig extends \WpfhTestCase {

	public function test_init() {
		$test = \Wpfh\WpfhConfig::init();

		$this->assertTrue( has_filter( 'wpfh/get_config' ) );
		$this->assertTrue( has_filter( 'wpfh/merge_config' ) );
		$this->assertTrue( has_filter( 'wpfh/get_config_object' ) );
		$this->assertInstanceOf( \Wpfh\WpfhConfig::class, $test );
	}

	public function test_get_default() {
		$test   = \Wpfh\WpfhConfig::init();
		$result = $test->get( 'i_do_not_exist' );

		$this->assertFalse( $result );
	}

	public function test_merge_config() {
		$test   = \Wpfh\WpfhConfig::init();
		$config = $test->get_config();

		$expected = array_merge( $config, [ 'new_option' => 'value' ] );
		$result   = $test->merge_config( [ 'new_option' => 'value' ] );

		$this->assertEquals( $expected, $result->get_config() );
	}

}