<?php

namespace Test\Wpfh\Assets;

use Brain\Monkey\Filters;

/**
 * Class AssetObserver
 * @package Test\Wpfh\Assets
 */
class AssetObserver extends \WpfhTestCase {

	public function test_invalid_action() {
		$this->expectException( \Wpfh\Exceptions\MethodNotFound::class );
		$this->expectExceptionMessage( 'The invalid_action method was not found inside Wpfh\Assets\AssetObserver' );

		$test = \Wpfh\Assets\AssetObserver::init();
		$test->invalid_action();
	}

	public function test_exit_empty_args() {
		$test = \Wpfh\Assets\AssetObserver::init();
		$test->register();

		$this->assertFalse( Filters\applied( 'wpfh/on__register' ) > 0 );
		$this->assertFalse( Filters\applied( 'wpfh/on__register' ) > 0 );
	}

}