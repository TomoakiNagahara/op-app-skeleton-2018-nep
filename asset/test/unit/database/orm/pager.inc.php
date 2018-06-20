<?php
/**
 * unit-test:/unit/database/orm/pager.php
 *
 * @creation  2018-06-20
 * @division  2018-06-20 from pager.phtml
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	Get database and table from form of selector.
$database = 'testcase';
$table    = 't_orm';

/* @var $pager \OP\UNIT\Pager */
$pager  = Unit::Instance('Pager');
$config = [
	'database' => $database,
	'table'    => $table,
	'order'    => 'timestamp desc',
];
$config = $pager->Config($config, $orm->DB());
$records= $orm->DB()->Select($config);

//	...
include('pager.phtml');

//	...
App::WebPack('unit:/dump/dump.js');
App::WebPack('unit:/dump/dump.css');
