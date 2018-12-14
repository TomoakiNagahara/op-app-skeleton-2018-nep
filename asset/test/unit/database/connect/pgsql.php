<?php
/**
 * unit-test:/unit/database/pgsql.php
 *
 * @creation  2018-12-14
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
/* @var $db OP\UNIT\Database */
$db = Unit::Instantiate('Database');

//	...
$config = [
	'prod'     => 'pgsql',
	'host'     => 'localhost',
	'port'     => '5432',
	'database' => 'database_name',
	'role'     => 'testuser',
	'password' => 'password',
	'charset'  => 'utf-8',
];

//	...
$db->Connect($config);

//	...
return $db;
