<?php

namespace Test\Wpfh\Commands;

/**
 * Class EnableMediaVersion
 * @package Test\Wpfh\Commands
 */
class EnableMediaVersion extends \WpfhTestCase {

	/**
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function test_invoke() {
		\Mockery::mock( 'overload:' . \WP_CLI::class )->shouldReceive( 'success' )->once()->andReturnNull();
		\Mockery::mock( 'overload:' . \Wpfh\WpfhOptions::class )
		        ->shouldReceive( 'init' )->once()->andReturnSelf()
		        ->shouldReceive( 'get' )->once()->andReturn( [ 'enable_version' => false, 'auto_bust_interval' => 0 ] )
		        ->shouldReceive( 'set' )->once()->andReturnSelf();
		$test = new \Wpfh\Commands\EnableMediaVersion();

		$this->assertNull( $test( [ 'on', 10000 ] ) );
	}

}