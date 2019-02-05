<?php
/**
 * unit-notfound:/selftest/t_ua_browser.php
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
	'name'    => 't_ua_browser',
	'charset' => 'utf8',
	'collate' => 'utf8mb4_general_ci',
	'comment' => 'Stack each host name.',
]);

//  Auto incrment id.
$configer->Set('column', [
	'name'    =>  'ai',
	/*
	'type'    => 'int',
	'length'  =>    11,
	'null'    => false,
	'default' =>  null,
	*/
	'ai'      =>  true,
	'comment' => 'Auto increment id.',
]);

//  Reference of t_ua.ai.
$configer->Set('column', [
	'name'      => 'ua',
	'type'      => 'int',
	'unsigned'  =>  true,
	'null'      =>  false,
	'comment'   => 'Reference of t_ua.ai.',
	'reference' => 't_ua.ai'
]);

//  Browser name.
$configer->Set('column', [
	'name'    => 'browser',
	'type'    => 'enum',
	'length'  => 'ie, edge, chrome, firefox, safari, opera, vivaldi, other',
	'null'    =>  true,
	'collate' => 'ascii_general_ci',
	'comment' => 'host name.',
]);

//  Browser version.
$configer->Set('column', [
	'name'      => 'version',
	'type'      => 'float',
	'unsigned'  =>  true,
	'null'      =>  false,
	'comment'   => 'Reference of t_ua.ai.',
	'reference' => 't_ua.ai'
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
