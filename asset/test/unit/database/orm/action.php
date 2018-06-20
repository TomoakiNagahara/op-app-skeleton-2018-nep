<?php
/**
 * unit-test:/unit/database/orm/action.php
 *
 * @creation  2018-06-20
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
/* @var $orm \OP\UNIT\ORM */
if(!$orm = Unit::Instance('ORM') ){
	return;
}

//	...
define('__DNS__', 'mysql://testcase:password@localhost:3306?charset=utf8');

//	...
$orm->Connect(__DNS__);
