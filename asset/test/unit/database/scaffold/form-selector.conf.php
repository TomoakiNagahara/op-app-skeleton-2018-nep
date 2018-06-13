<?php
/**
 * unit-test:/unit/database/scaffold/form-select.conf.php
 *
 * @creation  2018-06-11
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
$config = [];
$config['name'] = 'testcase-scaffold-selector';

/* @var $sql \OP\UNIT\SQL */
if( $sql = Unit::Instance('SQL') ){
	//	...
	$name  = 'database';
	$input = [];
	$input['name']	 = $name;
	$input['type']	 = 'select';
	$input['onchange'] = 'this.form.submit()';
	$config['input'][$name] = $input;

	//	...
	$name  = 'table';
	$input = [];
	$input['name']	 = $name;
	$input['type']	 = 'select';
	$input['onchange'] = 'this.form.submit()';
	$config['input'][$name] = $input;
}

//	...
return $config;
