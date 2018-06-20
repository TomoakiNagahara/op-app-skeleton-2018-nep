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
$config = [];

//	database
$database = 'testcase';

//	table
$table = 't_orm';

//	ai
$name	 = 'ai';
$column	 = [];
$column['field'] = $name;
$column['label'] = 'Auto increment';
$column['type']  = 'int';
$column['comment'] = 'Auto increment number.';
$config[$database][$table][$name] = $column;

//	required
$name	 = 'required';
$column	 = [];
$column['field']	 = $name;
$column['type']		 = 'varchar';
$column['length']	 = 10;
$column['null']		 = false;
$config[$database][$table][$name] = $column;

//	number
$name	 = 'number';
$column	 = [];
$column['field']	 = $name;
$column['type']		 = 'float';
$config[$database][$table][$name] = $column;

//	...
return $config;
