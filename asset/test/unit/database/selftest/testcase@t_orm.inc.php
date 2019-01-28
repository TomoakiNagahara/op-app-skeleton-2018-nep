<?php
/**
 * unit-test:/unit/database/selftest/testcase@t_orm.inc.php
 *
 * @creation  2018-05-29
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
OP\UNIT\SELFTEST\Configer::Table('t_orm');

//	...
OP\UNIT\SELFTEST\Configer::Column(        'ai',       'int', null, null, null,           'Auto increment number.');

//	...
OP\UNIT\SELFTEST\Configer::Column(  'required',   'varchar', null, null, null,                        'Required.', ['length'=>10, 'null'=>false]);

//	...
OP\UNIT\SELFTEST\Configer::Column(    'number',     'float', null, null, null,                      'Any number.');
OP\UNIT\SELFTEST\Configer::Column(   'integer',       'int', null, null, null,        'Integer only. (not float)');
OP\UNIT\SELFTEST\Configer::Column(  'positive',     'float', null, null, null, 'Positive integer. (not negative)', ['unsigned'=>1]);

//	...
OP\UNIT\SELFTEST\Configer::Column( 'multibyte',      'text', null, null, null,                       'Free text.');
OP\UNIT\SELFTEST\Configer::Column(     'ascii',      'text', null, null, null,            'Ascii character only.');

//	...
OP\UNIT\SELFTEST\Configer::Column(    'select',      'enum', null, null, null,    'null is select.', ['length'=>'y,n','null'=>true] );
OP\UNIT\SELFTEST\Configer::Column(     'radio',      'enum', null, null, null, 'not null is radio.', ['length'=>'y,n','null'=>false]);
OP\UNIT\SELFTEST\Configer::Column(  'checkbox',       'set', null, null, null,          'Checkbox.', ['length'=>'a,b,c']);

//	...
OP\UNIT\SELFTEST\Configer::Column(      'date',      'date', null, null, null,                 'date');
OP\UNIT\SELFTEST\Configer::Column(  'datetime',  'datetime', null, null, null,           'date time.');

//	...
OP\UNIT\SELFTEST\Configer::Column(   'created',  'datetime', null, null, null,           'Created GMT date time.');
OP\UNIT\SELFTEST\Configer::Column(   'updated',  'datetime', null, null, null,           'Updated GMT date time.');
OP\UNIT\SELFTEST\Configer::Column(   'deleted',  'datetime', null, null, null,           'Deleted GMT date time.');
OP\UNIT\SELFTEST\Configer::Column( 'timestamp', 'timestamp', null, null, null, 'Auto update timestamp. (local timestamp)');

//	...
OP\UNIT\SELFTEST\Configer::Index(     'ai',      'ai', 'ai', 'auto incrment');

//	...
OP\UNIT\SELFTEST\Configer::Collate('ascii', 'ascii');
