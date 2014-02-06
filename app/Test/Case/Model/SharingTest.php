<?php
App::uses('Sharing', 'Model');

/**
 * Sharing Test Case
 *
 */
class SharingTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.sharing',
		'app.album'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Sharing = ClassRegistry::init('Sharing');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Sharing);

		parent::tearDown();
	}

}
