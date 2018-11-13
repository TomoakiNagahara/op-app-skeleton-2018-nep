<?php
/**
 * module-testcase:/unit/selftest/configer/chat@db.php
 *
 * @creation  2018-11-03
 * @version   1.0
 * @package   module-testcase
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
$configer = OP\UNIT\Selftest::Configer();

//  DSN configuration.
$configer->DSN([
	'host'     => 'localhost',
	'product'  => 'mysql',
	'port'     => '3306',
]);

//  User configuration.
$configer->User([
	'name'     => 'chat',
	'password' => 'password',
	'charset'  => 'utf8',
]);

//  Database configuration.
$configer->Database([
	'name'     => 'chat',
	'charset'  => 'utf8',
]);

//  Privilege configuration.
$configer->Privilege([
	'user'     => 'chat',
	'database' => 'chat',
	'table'    => '*',
	'privilege'=> 'insert, select, update, delete',
	'column'   => '*',
]);

//	...
include('chat@t_chat.inc.php');

//	...
return $configer::Get();
