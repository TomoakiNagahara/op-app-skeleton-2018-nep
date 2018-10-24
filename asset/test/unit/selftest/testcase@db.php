<?php
/**
 * module-testcase:/unit/selftest/configer/testcase@db.php
 *
 * @creation  2018-04-06
 * @version   1.0
 * @package   module-testcase
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
OP\UNIT\SELFTEST\Configer::Database('testcase');
OP\UNIT\SELFTEST\Configer::Privilege('testcase','testcase','*', 'SELECT, INSERT, UPDATE, DELETE', '*');

//	...
include('testcase@t_test.php');
