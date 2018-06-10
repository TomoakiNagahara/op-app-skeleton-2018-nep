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
OP\UNIT\SELFTEST\Configer::Column(        'ai',       'int',           'Auto increment number.');

//	...
OP\UNIT\SELFTEST\Configer::Column(  'required',   'varchar',                        'Required.', ['length'=>10, 'null'=>false]);

//	...
OP\UNIT\SELFTEST\Configer::Column(    'number',     'float',                      'Any number.');
OP\UNIT\SELFTEST\Configer::Column(   'integer',       'int',        'Integer only. (not float)');
OP\UNIT\SELFTEST\Configer::Column(  'positive',     'float', 'Positive integer. (not negative)', ['unsigned'=>1]);

//	...
OP\UNIT\SELFTEST\Configer::Column( 'multibyte',      'text',                       'Free text.');
OP\UNIT\SELFTEST\Configer::Column(     'ascii',      'text',            'Ascii character only.');

//	...
OP\UNIT\SELFTEST\Configer::Column(    'select',      'enum',    'null is select.', ['length'=>'y,n','null'=>true] );
OP\UNIT\SELFTEST\Configer::Column(     'radio',      'enum', 'not null is radio.', ['length'=>'y,n','null'=>false]);
OP\UNIT\SELFTEST\Configer::Column(  'checkbox',       'set',          'Checkbox.', ['length'=>'a,b,c']);

//	...
OP\UNIT\SELFTEST\Configer::Column(      'date',      'date',                 'date');
OP\UNIT\SELFTEST\Configer::Column(  'datetime',  'datetime',           'date time.');

//	...
OP\UNIT\SELFTEST\Configer::Column(   'created',  'datetime',           'Created GMT date time.');
OP\UNIT\SELFTEST\Configer::Column(   'updated',  'datetime',           'Updated GMT date time.');
OP\UNIT\SELFTEST\Configer::Column(   'deleted',  'datetime',           'Deleted GMT date time.');
OP\UNIT\SELFTEST\Configer::Column( 'timestamp', 'timestamp', 'Auto update timestamp. (local timestamp)');

//	...
OP\UNIT\SELFTEST\Configer::Index(     'ai',      'ai', 'ai', 'auto incrment');

//	...
OP\UNIT\SELFTEST\Configer::Collate('ascii', 'ascii');
