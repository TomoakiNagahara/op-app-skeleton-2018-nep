<?php
/**
 * unit-notfound:/selftest/t_notfound.php
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
	'name'    => 't_notfound',
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

//  Count of access.
$configer->Set('column', [
	'name'     => 'count',
	'type'     => 'int',
	'length'   =>  10,
	'unsigned' =>  true,
	'null'     =>  false,
	'comment'  => 'Count of access.',
]);

//  Reference of t_host.ai.
$configer->Set('column', [
	'name'      => 'host',
	'type'      => 'int',
	'unsigned'  =>  true,
	'null'      =>  false,
	'comment'   => 'Reference of t_host.ai.',
	'reference' => 't_host.ai'
]);

//  Reference of t_uri.ai.
$configer->Set('column', [
	'name'      => 'uri',
	'type'      => 'int',
	'unsigned'  =>  true,
	'null'      =>  false,
	'comment'   => 'Reference of t_uri.ai.',
	'reference' => 't_uri.ai'
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

//  Add timestamp.
$configer->Set('column', [
	'name'    => 'timestamp',
	'type'    => 'timestamp',
	'comment' => 'On update current timestamp.',
]);

//  Add auto incrment id configuration.
$configer->Set('index', [
	'name'    => 'ai',
	'type'    => 'ai',
	'column'  => 'ai',
	'comment' => 'auto incrment',
]);

//  Unique index.
$configer->Set('index', [
	'name'    => 'host-uri-ua',
	'type'    => 'unique',
	'column'  => 'host, uri, ua',
	'comment' => 'Compound index.',
]);

//  Group index.
$configer->Set('index', [
	'name'    => 'uri',
	'type'    => 'index',
	'column'  => 'uri',
	'comment' => 'Use for grouprize.',
]);

//  ...
$configer->Set('index', [
	'name'    => 'ua',
	'type'    => 'index',
	'column'  => 'ua',
	'comment' => 'User agent.',
]);
