<?php
/**
 * unit-test:/unit/database/selftest.php
 *
 * @creation  2018-05-11
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

//	Setup configuration.
include('testcase@db.inc.php');

//	Set configuration.
\OP\UNIT\SELFTEST\Inspector::Auto( OP\UNIT\SELFTEST\Configer::Get() );

//	Get result.
$build  = \OP\UNIT\SELFTEST\Inspector::Build();
$failed = \OP\UNIT\SELFTEST\Inspector::Failed();

//	...
while( $message = \OP\UNIT\SELFTEST\Inspector::Error() ){
	printf('<p class="testcase selftest bold error">%s</p>', $message);
}

//	...
if( $failed !== false ){
	\OP\UNIT\SELFTEST\Inspector::Form();
}

//	...
\OP\UNIT\SELFTEST\Inspector::Result();

// ...
if( ifset($_GET['debug']) or Notice::Has() ){
	\OP\UNIT\SELFTEST\Inspector::Debug();
}
