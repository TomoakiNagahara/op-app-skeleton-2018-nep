<?php
/**
 * unit-test:/unit/database/mysql.php
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
	'prod'	 => 'mysql',
	'host'	 => 'localhost',
	'port'	 => '3306',
	'user'	 => 'root',
	'password' => 'hogehoge',
];

//	...
$db->Connect($config);

//	...
return $db;
