<?php
/**
 * unit-test:/unit/database/orm/config.php
 *
 * @creation  2018-06-20
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
$config  = [];
$configs = [];

//	database
$database = 'testcase';

//	table
$table = 't_orm';

//	ai
$name	 = 'ai';
$column	 = [];
$column['field']	 = $name;
$column['label']	 = 'Auto increment';
$column['type']		 = 'int';
$column['ai']		 = true;
$column['comment']	 = 'Auto increment number.';
$config[$database][$table][$name] = $column;

//	required
$name	 = 'required';
$column	 = [];
$column['field']	 = $name;
$column['type']		 = 'varchar';
$column['length']	 = 10;
$column['null']		 = false;
$column['comment']	 = 'Required.';
$config[$database][$table][$name] = $column;

//	number
$name	 = 'number';
$column	 = [];
$column['field']	 = $name;
$column['type']		 = 'float';
$column['comment']	 = 'Any number.';
$config[$database][$table][$name] = $column;

//	select
$name	 = 'select';
$column	 = [];
$column['field']	 = $name;
$column['type']		 = 'enum';
$column['values']	 = [
	['label'=>''   ,'value'=>'' ],
	['label'=>'Yes','value'=>'y'],
	['label'=>'No' ,'value'=>'n'],
];
$column['comment'] = 'null is select.';
$config[$database][$table][$name] = $column;

//	Radio
$name	 = 'radio';
$column	 = [];
$column['field']	 = $name;
$column['type']		 = 'enum';
$column['values']	 = [
	['label'=>'Yes','value'=>'y'],
	['label'=>'No' ,'value'=>'n'],
];
$column['null']		 = false;
$column['comment']	 = 'not null is radio.';
$config[$database][$table][$name] = $column;

//	checkbox
$name	 = 'checkbox';
$column	 = [];
$column['field']	 = $name;
$column['type']		 = 'set';
$column['values']	 = [
		['label'=>'Apple' ,'value'=>'a' ],
		['label'=>'Banana','value'=>'b'],
		['label'=>'Cocoa' ,'value'=>'c'],
];
$column['comment']	 = 'Checkbox.';
$config[$database][$table][$name] = $column;

//	...
$configs[__DSN__] = $config;

//	...
return $configs;
