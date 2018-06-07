<?php
/**
 * unit-test:/unit/database/delete.php
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
$config['table'] = 't_orm';
$config['limit'] = 1;
$config['order'] = 'timestamp desc';
$config['where']['deleted'] = null;

//	Update record.
$count = $db->delete($config);

//	...
D('DELETE', $count, $db->Queries($config));
