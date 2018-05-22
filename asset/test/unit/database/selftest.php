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
include('connect.php');

//	...
if(!Unit::Load('selftest') ){
	return;
}

//	...
OP\UNIT\SELFTEST\Configer::Host('localhost', 'mysql', '3306');

//	...
OP\UNIT\SELFTEST\Configer::User('testcase', 'password', false, 'utf8');

//	...
OP\UNIT\SELFTEST\Configer::Database('testcase');

//	...
OP\UNIT\SELFTEST\Configer::Table('t_test');

//	...
OP\UNIT\SELFTEST\Configer::Column(       'ai',      'int',   11, false, null, 'Auto increment number.');
OP\UNIT\SELFTEST\Configer::Column(       'id',     'char',    8, false, null, '8byte hash key.');
OP\UNIT\SELFTEST\Configer::Column(     'text',     'text',    8,  true, null, 'Free text.');
OP\UNIT\SELFTEST\Configer::Column(      'tag',  'varchar',   20,  true, null, 'Search tag. Muximum 20 charcter. Correspond to multi byte charcter.');
OP\UNIT\SELFTEST\Configer::Column(   'weight',      'int',   11, false,    1, 'Order weigth.');
OP\UNIT\SELFTEST\Configer::Column(     'flag',      'set','a,b',  true, null, 'Any flags.');
OP\UNIT\SELFTEST\Configer::Column(    'valid',     'enum','y,n',  true, null, 'valid record.');
OP\UNIT\SELFTEST\Configer::Column(  'created', 'datetime', null, false, null, 'Created GMT date time.');
OP\UNIT\SELFTEST\Configer::Column(  'updated', 'datetime', null,  true, null, 'Updated GMT date time.');
OP\UNIT\SELFTEST\Configer::Column(  'deleted', 'datetime', null,  true, null, 'Deleted GMT date time.');
OP\UNIT\SELFTEST\Configer::Column('timestamp','timestamp', null, false, null, 'Auto update timestamp. (local timestamp)');

//	...
OP\UNIT\SELFTEST\Configer::Index(     'ai',      'ai', 'ai', 'auto incrment');
OP\UNIT\SELFTEST\Configer::Index(     'id',  'unique', 'id', 'unique 8byte hash id');
OP\UNIT\SELFTEST\Configer::Index( 'search',   'index', 'tag, weight', 'search index');

//	...
OP\UNIT\SELFTEST\Configer::Collate('id', 'ascii');

//	...
\OP\UNIT\SELFTEST\Inspector::Auto( OP\UNIT\SELFTEST\Configer::Get() );

//	...
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
if( ifset($_GET['debug']) ){
	\OP\UNIT\SELFTEST\Inspector::Debug();
}

//	...
D($build, $failed);
