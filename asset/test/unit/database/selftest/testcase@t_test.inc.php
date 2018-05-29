<?php
/**
 * unit-test:/unit/database/selftest/testcase@t_test.inc.php
 *
 * @creation  2018-05-29
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
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
