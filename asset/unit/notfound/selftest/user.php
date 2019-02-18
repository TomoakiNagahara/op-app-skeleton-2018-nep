<?php
/**
 * unit-notfound:/selftest/user.php
 *
 * @creation  2019-02-04
 * @version   1.0
 * @package   unit-notfound
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
/* @var $configer \OP\UNIT\SELFTEST\Configer */

//	...
if( $_SERVER['SERVER_ADDR'] === '127.0.0.1' or $_SERVER['SERVER_ADDR'] === '::1' ){
	$host = 'localhost';
}else if( $host = Env::Get('localhost')){
	//	Local private address.
}else{
	$host = $_SERVER['SERVER_ADDR'];
};

//  User configuration.
$configer->User([
	'host'     =>  $host,
	'name'     => 'notfound',
	'password' => 'password',
	'charset'  => 'utf8',
]);

/*
$configer->User([
	'name'     => 'notfound-insert',
	'password' => Hasha1(__FILE__.':'.__LINE__),
	'charset'  => 'utf8',
]);
$configer->User([
	'name'     => 'notfound-admin',
	'password' => Hasha1(__FILE__.':'.__LINE__),
	'charset'  => 'utf8',
]);
$configer->User([
	'name'     => 'notfound-admin-select',
	'host'     => '192.168.1.%',
	'password' => Hasha1(__FILE__.':'.__LINE__),
	'charset'  => 'utf8',
]);
*/

//  Privilege configuration.
$configer->Privilege([
	'host'     =>  $host,
	'user'     => 'notfound',
	'database' => 'onepiece',
	'table'    => 't_host, t_uri, t_ua, t_ua_os, t_ua_browser, t_notfound',
	'privilege'=> 'insert, select, update, delete',
	'column'   => '*',
]);

/*
$configer->Privilege([
	'user'     => 'notfound-insert',
	'database' => 'onepiece',
	'table'    => 't_host, t_uri, t_ua, t_notfound',
	'privilege'=> 'insert, select, update, delete',
	'column'   => '*',
]);
$configer->Privilege([
	'user'     => 'notfound-admin',
	'database' => 'onepiece',
	'table'    => 't_host, t_uri, t_ua, t_notfound',
	'privilege'=> 'select, update, delete',
	'column'   => '*',
]);
$configer->Privilege([
	'user'     => 'notfound-admin-select',
	'host'     => '192.168.1.%',
	'database' => 'onepiece',
	'table'    => 't_host, t_uri, t_ua, t_notfound',
	'privilege'=> 'select, update, delete',
	'column'   => '*',
]);
*/
