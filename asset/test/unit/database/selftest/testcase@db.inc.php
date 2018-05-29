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
OP\UNIT\SELFTEST\Configer::DSN('localhost', 'mysql', '3306');

//	...
OP\UNIT\SELFTEST\Configer::User('testcase', 'password', false, 'utf8');

//	...
OP\UNIT\SELFTEST\Configer::Database('testcase');

//	...
//include(__DIR__.'/testcase@t_test.inc.php');
include(__DIR__.'/testcase@t_orm.inc.php');
