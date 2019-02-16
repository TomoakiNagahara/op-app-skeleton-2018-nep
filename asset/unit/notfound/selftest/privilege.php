<?php
/**
 * unit-notfound:/selftest/privilege.php
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
}else{
	$host = $_SERVER['SERVER_ADDR'];
};

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
