<?php

namespace Test\Wpfh\Commands;

/**
 * Class MediaVersionBust
 * @package Test\Wpfh\Commands
 */
class MediaVersionBust extends \WpfhTestCase {

	/**
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function test_invoke() {
		\Mockery::mock( 'overload:' . \WP_CLI::class )->shouldReceive( 'success' )->once()->andReturnNull();
		\Mockery::mock( 'overload:' . \Wpfh\WpfhOptions::class )
		        ->shouldReceive( 'init' )->once()->andReturnSelf()
		        ->shouldReceive( 'get' )->once()->andReturn( [ 'version_tag' => '123' ] )
		        ->shouldReceive( 'set' )->once()->andReturnSelf();
		$test = new \Wpfh\Commands\MediaVersionBust();

		$this->assertNull( $test( [] ) );
	}

}