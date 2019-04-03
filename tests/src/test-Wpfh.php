<?php

namespace Test\Wpfh;

/**
 * Class Wpfh
 * @package Test\Wpfh
 */
class Wpfh extends \WpfhTestCase {

	public function test_init() {
		$assets = \Mockery::mock( \Wpfh\Assets\AssetsManager::class );

		$test = \Wpfh\Wpfh::init( $assets );

		$this->assertTrue( has_filter( 'wpfh/get_helper' ) );
		$this->assertTrue( has_filter( 'wpfh/get_assets_manager' ) );
		$this->assertInstanceOf( \Wpfh\Wpfh::class, $test );
	}

}