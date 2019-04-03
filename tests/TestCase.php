<?php

use Brain\Monkey;
use \PHPUnit\Framework\TestCase;

/**
 * Class WpfhTestCase
 */
class WpfhTestCase extends TestCase {

	public function setUp() {
		parent::setUp();
		Monkey\setUp();
	}

	protected function tearDown() {
		parent::tearDown();
		Monkey\tearDown();
	}

}