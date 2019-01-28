<?php
/**
 * unit-test:/unit/database/selftest/testcase@db.inc.php
 *
 * @creation  2018-05-11
 * @separate  2018-05-29
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
OP\UNIT\SELFTEST\Configer::DSN(['host'=>'localhost','prod'=>'mysql']);

//	...
OP\UNIT\SELFTEST\Configer::User(['name'=>'testcase', 'password'=>'password']);

//	...
OP\UNIT\SELFTEST\Configer::Database(['name'=>'testcase']);

//	...
//include(__DIR__.'/testcase@t_test.inc.php');
include(__DIR__.'/testcase@t_orm.inc.php');
