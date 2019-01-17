<?php
/**
 * unit-test:/unit/database/sqlite.php
 *
 * @creation  2018-12-11
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
/* @var $db OP\UNIT\Database */
$db = Unit::Instantiate('Database');

//	...
$config = [
	'prod' => 'sqlite',
//	'path' => ':memory:',
	'path' => ConvertPath('asset:/.cache/testcase.sqlite3'),
];

//	...
$db->Connect($config);

//	...
return $db;
