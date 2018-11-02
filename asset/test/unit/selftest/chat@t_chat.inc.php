<?php
/**
 * module-testcase:/unit/selftest/configer/chat@t_chat.php
 *
 * @creation  2018-11-03
 * @version   1.0
 * @package   module-testcase
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//  Corespond to eclipse notice.
if( false ){
	$configer = OP\UNIT\Selftest::Configer();
};

//	Table
$configer->Table('t_test');

//	Columns
$configer->Column(       'ai',      'int',   11, false, null, 'Auto increment number.');
$configer->Column(       'id',     'char',    8, false, null, '8byte hash key.');
$configer->Column(     'text',     'text', null,  true, null, 'Free text.');
$configer->Column(      'tag',  'varchar',   20,  true, null, 'Search tag. Muximum 20 charcter. Correspond to multi byte charcter.');
$configer->Column(   'weight',      'int',   11, false,    1, 'Order weigth.');
$configer->Column(     'flag',      'set','a,b',  true, null, 'flags');
$configer->Column(    'valid',     'enum','y,n',  true, null, 'valid record.');
$configer->Column(  'created', 'datetime', null, false, null, 'Created date time.');
$configer->Column(  'updated', 'datetime', null,  true, null, 'Updated date time.');
$configer->Column(  'deleted', 'datetime', null,  true, null, 'Deleted date time.');
$configer->Column('timestamp','timestamp', null, false, null, 'Auto update current timestamp.');

//  Add auto incrment id configuration.
$configer->Index([
	'name'    => 'ai',
	'type'    => 'ai',
	'column'  => 'ai',
	'comment' => 'auto incrment',
]);
