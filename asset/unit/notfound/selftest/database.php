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
//	...
$config = Env::Get('notfound');

//  DSN configuration.
$configer->DSN([
	'host'     => $config['host'] ?? 'localhost',
	'product'  => $config['prod'] ?? 'mysql',
	'port'     => $config['port'] ?? '3306',
]);

//  Database configuration.
$configer->Database([
	'name'     => $config['database'] ?? 'onepiece',
	'charset'  => $config['charset']  ?? 'utf8',
	'collate'  => $config['collate']  ?? 'utf8mb4_general_ci',
]);
