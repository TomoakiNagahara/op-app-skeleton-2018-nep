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

//  DSN configuration.
$configer->DSN([
	'host'     => 'localhost',
	'product'  => 'mysql',
	'port'     => '3306',
]);

//  Database configuration.
$configer->Database([
	'name'     => 'onepiece',
	'charset'  => 'utf8',
	'collate'  => 'utf8mb4_general_ci',
]);
