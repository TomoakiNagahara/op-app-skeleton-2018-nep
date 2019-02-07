<?php
/**
 * unit-notfound:/selftest/t_ua.php
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
	'name'    => 't_ua',
	'charset' => 'utf8',
	'collate' => 'utf8mb4_general_ci',
	'comment' => 'Stack each host name.',
]);

//  Auto incrment id.
$configer->Set('column', [
	'name'    =>  'ai',
	'ai'      =>  true,
	'comment' => 'Auto increment id.',
]);

//  Hash key.
$configer->Set('column', [
	'name'    => 'hash',
	'type'    => 'char',
	'length'  =>     10,
	'null'    =>  false,
	'collate' => 'ascii_general_ci',
	'comment' => 'Hash by host name.',
	'unique'  =>   true,
]);

//  User agent.
$configer->Set('column', [
	'name'    => 'ua',
	'type'    => 'text',
	'null'    =>  false,
	'collate' => 'ascii_general_ci',
	'comment' => 'User agent.',
]);

//  Timestamp.
$configer->Set('column', [
	'name'    => 'timestamp',
	'type'    => 'timestamp',
	'comment' => 'On update current timestamp.',
]);

//  Auto incrment id.
$configer->Set('index', [
	'name'    => 'ai',
	'type'    => 'ai',
	'column'  => 'ai',
	'comment' => 'auto incrment',
]);

//  Search unique index key.
$configer->Set('index', [
	'name'    => 'hash',
	'type'    => 'unique',
	'column'  => 'hash',
	'comment' => 'unique index key',
]);
