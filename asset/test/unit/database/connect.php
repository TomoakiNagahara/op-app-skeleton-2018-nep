<?php
/**
 * unit-test:/unit/database/connection.php
 *
 * @creation  2018-04-24
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

//	...
if(!Unit::Load('database') ){
	return;
}

/* @var $db \OP\UNIT\Database */
if(!$db = Unit::Instance('Database') ){
	return;
}

//	...
$config = [
	'prod'	 => 'mysql',
	'host'	 => 'localhost',
	'port'	 => '3306',
	'user'	 => 'testcase',
	'password' => 'password',
	'database' => 'testcase',
];

//	...
$io = $db->Connect($config);

//	...
D('Connect', $io);
