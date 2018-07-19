<?php
/**
 * unit-test:/unit/database/orm/self-test.php
 *
 * @creation  2018-06-21
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/* @var $db \OP\UNIT\Database */
include('../connect.php');

//	Load selftest unit.
if(!Unit::Load('selftest') ){
	return;
}

/* @var $orm \OP\UNIT\ORM */
$orm->Selftest('config.inc.php');
