<?php
/**
 * SharingFixture
 *
 */
class SharingFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'album_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'manager' => array('type' => 'integer', 'null' => false, 'default' => null),
		'accessCode' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'album_id' => 1,
			'manager' => 1,
			'accessCode' => 'Lorem ipsum dolor sit amet',
			'created' => '2014-02-06 09:14:26'
		),
	);

}
