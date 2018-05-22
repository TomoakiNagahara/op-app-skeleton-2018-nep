<?php
/**
 * unit-test:/unit/database/select.php
 *
 * @creation  2018-04-27
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/* @var $db \OP\UNIT\Database */
include('connect.php');

//	Count records.
$config = [];
$config['table'] = 't_test';
$config['limit'] = 10;
$config['where']['deleted'] = null;
$count = $db->Count($config);

//	Select records.
$config = [];
$config['table'] = 't_test';
$config['limit'] = 10;
$config['where']['ai']['value'] = null;
$config['where']['ai']['evalu'] = '!';
D('SELECT', "count=$count", $db->Select($config), $db->Queries($config));
