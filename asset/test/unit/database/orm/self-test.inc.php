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
D(__FILE__);

/* @var $db \OP\UNIT\Database */
include('../connect.php');

//	Load selftest unit.
if(!Unit::Load('selftest') ){
	return;
}

/* @var $orm \OP\UNIT\ORM */
$config = $orm->Selftest('config.inc.php');

//	Set configuration.
\OP\UNIT\SELFTEST\Inspector::Auto( $config );

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
if( ($_GET['debug'] ?? false) or Notice::Has() ){
	\OP\UNIT\SELFTEST\Inspector::Debug();
}
