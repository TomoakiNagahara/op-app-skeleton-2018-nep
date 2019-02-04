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

//  Add table configuration.
$configer->Set('table', [
	'name'    => 't_host',
	'charset' => 'utf8',
	'collate' => 'utf8mb4_general_ci',
	'comment' => 'Stack each host name.',
]);

//  Add auto incrment id.
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

//  Add hash key.
$configer->Set('column', [
	'name'    => 'hash',
	'type'    => 'char',
	'length'  =>     10,
	'null'    =>  false,
	'collate' => 'ascii_general_ci',
	'comment' => 'Hash by host name.',
	'unique'  =>   true,
]);

//  Add host name.
$configer->Set('column', [
	'name'    => 'host',
	'type'    => 'text',
	'null'    =>  false,
	'collate' => 'ascii_general_ci',
	'comment' => 'host name.',
]);

//  Add timestamp.
$configer->Set('column', [
	'name'    => 'timestamp',
	'type'    => 'timestamp',
	'comment' => 'On update current timestamp.',
]);

/*
//  Add auto incrment id configuration.
$configer->Set('index', [
	'name'    => 'ai',
	'type'    => 'ai',
	'column'  => 'ai',
	'comment' => 'auto incrment',
]);

//  Add search index configuration.
$configer->Set('index', [
	'name'    => 'search index',
	'type'    => 'index',
	'column'  => 'flags, choice',
	'comment' => 'Indexed by two columns.',
]);
*/
