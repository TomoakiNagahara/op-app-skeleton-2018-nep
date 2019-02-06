<?php
/**
 * unit-notfound:/selftest/t_ua_os.php
 *
 * @creation  2019-02-05
 * @version   1.0
 * @package   unit-notfound
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
/* @var $configer \OP\UNIT\SELFTEST\Configer */

//  Table configuration.
$configer->Set('table', [
	'name'		 => 't_ua_os',
	'charset'	 => 'utf8',
	'collate'	 => 'utf8mb4_general_ci',
	'comment'	 => 'Stack each host name.',
]);

//  Auto incrment id.
$configer->Set('column', [
	'name'		 =>  'ai',
	'ai'		 =>  true,
	'comment'	 => 'Auto increment id.',
]);

//  Reference of t_ua.ai.
$configer->Set('column', [
	'name'		 => 'ua',
	'type'		 => 'int',
	'unsigned'	 =>  true,
	'null'		 =>  false,
	'comment'	 => 'Reference of t_ua.ai.',
	'reference'	 => 't_ua.ai'
]);

//  OS.
$configer->Set('column', [
	'name'		 => 'os',
	'type'		 => 'enum',
	'length'	 => 'win, mac, linux, bsd, ios, android',
	'null'		 =>  true,
	'collate'	 => 'ascii_general_ci',
	'comment'	 => 'OS Name. Unknown OS is null.',
]);

//  OS version.
$configer->Set('column', [
	'name'		 => 'version',
	'type'		 => 'float',
	'unsigned'	 =>  true,
	'null'		 =>  true,
	'comment'	 => 'Version of OS.',
]);

//  Timestamp.
$configer->Set('column', [
	'name'		 => 'timestamp',
	'type'		 => 'timestamp',
	'comment'	 => 'On update current timestamp.',
]);

//  Auto incrment id.
$configer->Set('index', [
	'name'		 => 'ai',
	'type'		 => 'ai',
	'column'	 => 'ai',
	'comment'	 => 'auto incrment',
]);
