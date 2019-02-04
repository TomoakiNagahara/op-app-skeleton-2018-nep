<?php
/**
 * unit-notfound:/selftest/database.php
 *
 * @creation  2019-02-02
 * @version   1.0
 * @package   unit-notfound
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
/* @var $configer \OP\UNIT\SELFTEST\Configer */
if( false ){
	$configer = Unit::Instantiate('Selftest')->Configer();
};

//  DSN configuration.
$configer->DSN([
	'host'     => 'localhost',
	'product'  => 'mysql',
	'port'     => '3306',
]);

//  User configuration.
$configer->User([
	'name'     => 'notfound',
	'password' => 'password',
	'charset'  => 'utf8',
]);

//  Privilege configuration.
$configer->Privilege([
	'user'     => 'notfound',
	'database' => 'onepiece',
	'table'    => 't_host, t_uri, t_ua, t_notfound',
	'privilege'=> 'insert, select, update, delete',
	'column'   => '*',
]);

//  Database configuration.
$configer->Database([
	'name'     => 'onepiece',
	'charset'  => 'utf8',
	'collate'  => 'utf8mb4_general_ci',
]);
