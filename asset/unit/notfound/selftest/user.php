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

//  User configuration.
$configer->User([
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
