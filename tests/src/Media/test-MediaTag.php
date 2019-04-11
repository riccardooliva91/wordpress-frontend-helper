<?php

namespace Test\Wpfh\Media;

/**
 * Class MediaTag
 * @package Test\Wpfh\Media
 */
class MediaTag extends \WpfhTestCase {

	public function test_setter_getter_camelcase() {
		$test = \Wpfh\Media\MediaTag::init( [] );

		$test->tag = 'tag';
		$this->assertEquals( $test->tag, 'tag' );

		$test->dataSrc = 'src';
		$this->assertEquals( $test->dataSrc, 'src' );

		$this->assertNull( $test->not_declared );
	}

	public function test_toString() {
		$test         = \Wpfh\Media\MediaTag::init( [ 'enable_version' => true, 'version_tag' => '1234' ] );
		$test->tag    = 'img';
		$test->src    = 'example.src';
		$test->height = 50;
		$test->width  = 50;
		$test->dataJs = 'some-data';
		$test->alt    = 'Example';
		$test->class  = 'some__class';

		$this->expectOutputString( '<img src="example.src?v=1234" height="50" width="50" data-js="some-data" alt="Example" class="some__class" />' );
		echo $test;
	}

}