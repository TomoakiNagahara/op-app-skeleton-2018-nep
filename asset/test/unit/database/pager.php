<?php
/**
 * unit-test:/unit/database/pager.php
 *
 * @creation  2018-06-01
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
/* @var $db OP\UNIT\Database */
include('_connect.php');

//	...
if(!$db->isConnect() ){
	return;
}

/* @var $pager \OP\UNIT\Pager */
$pager  = Unit::Instance('Pager');
$config = $pager->Config([
	'database' => 'testcase',
	'table'    => 't_orm',
	'limit'    =>  $_GET['limit'] ?? 10,
	'wings'    =>  $_GET['wings'] ??  2,
], $db);

//  Display pager.
$pager->Display();

//  Select pagenation target record.
$record = $db->Select($config);

//	...
$pager->Debug();

//	...
D( $record );
