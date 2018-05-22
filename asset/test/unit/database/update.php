<?php
/**
 * unit-test:/unit/database/update.php
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
$config['limit'] = 1;
$config['order'] = 'timestamp desc';
$config['where']['updated'] = null;
$config['set']['updated'] = Time::GMT();

//	Update record.
$count = $db->update($config);

//	...
D('UPDATE', $count, $db->Queries($config));
