<?php

namespace Test\Wpfh\Media;

use Brain\Monkey\Functions;

/**
 * Class MediaPrinter
 * @package Test\Wpfh\Media
 */
class MediaPrinter extends \WpfhTestCase {

	public function test_get_write_save_media() {
		Functions\expect( 'get_template_directory' )->andReturn( '/dir' );
		$options = \Mockery::mock( \Wpfh\WpfhOptions::class )
		                   ->shouldReceive( 'get' )->andReturn( [ 'enable_version' => true, 'version_tag' => '123' ] )
		                   ->getMock();
		$test    = \Wpfh\Media\MediaPrinter::init( $options );

		$test->save_media( 'test', 'img' );
		$this->assertEquals( '<img />', $test->get( 'test' ) );

		$this->expectOutputString( '<img />' );
		$test->write( 'test' );
	}

	public function test_get_write_save_media_invalid() {
		Functions\expect( 'get_template_directory' )->andReturn( '/dir' );
		$options = \Mockery::mock( \Wpfh\WpfhOptions::class )
		                   ->shouldReceive( 'get' )->andReturn( [ 'enable_version' => true, 'version_tag' => '123' ] )
		                   ->getMock();
		$test    = \Wpfh\Media\MediaPrinter::init( $options );

		$this->assertFalse( $test->get( 'i_do_not_exist' ) );

		$this->expectOutputString( '' );
		$test->write( 'i_do_not_exist' );
	}

	public function test_write_tag() {
		Functions\expect( 'get_template_directory' )->andReturn( '/dir' );
		$options = \Mockery::mock( \Wpfh\WpfhOptions::class )
		                   ->shouldReceive( 'get' )->andReturn( [ 'enable_version' => true, 'version_tag' => '123' ] )
		                   ->getMock();
		$test    = \Wpfh\Media\MediaPrinter::init( $options );

		$this->expectOutputString( '<img src="example?v=123" />' );
		$test->write_tag( 'img', [ 'src' => 'example' ] );
	}

}