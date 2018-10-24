<?php
/**
 * unit-test:/unit/selftest/config.php
 *
 * @creation  2018-10-25
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
OP\UNIT\SELFTEST\Configer::Dsn('localhost', 'mysql', '3306');
OP\UNIT\SELFTEST\Configer::User('testcase', 'password', 'utf8');

//	...
include('testcase@db.php');

//	...
return OP\UNIT\SELFTEST\Configer::Get();
