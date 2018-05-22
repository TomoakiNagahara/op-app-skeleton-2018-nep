<?php
/**
 * unit-test:/unit/database/insert.php
 *
 * @creation  2018-05-08
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/* @var $db \OP\UNIT\Database */
include('connect.php');

//	New record configuration.
$config = [];
$config['table'] = 't_test';
$config['set']['id'] = Hasha1( Time::Get() );
$config['set']['created'] = Time::GMT();

//	Insert new record.
$ai = $db->Insert($config);

//	...
D('INSERT', $ai, $db->Queries($config));
