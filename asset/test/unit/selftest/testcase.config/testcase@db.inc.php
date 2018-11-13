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
OP\UNIT\SELFTEST\Configer::Database([
	'name' => 'testcase'
]);

//	...
OP\UNIT\SELFTEST\Configer::Privilege([
	'user'      => 'testcase',
	'database'  => 'testcase',
	'table'     => '*',
	'privilege' => 'SELECT, INSERT, UPDATE, DELETE',
	'column'    => '*'
]);

//	...
include('testcase@t_test.inc.php');
