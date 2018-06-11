<?php
/**
 * unit-test:/unit/database/scaffold/select.form.php
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
	$values = [''];
	foreach( $db->Query($sql->Show([], $db), 'show') as $value ){
		$values[$value] = $value;
	}

	//	...
	$name  = 'database';
	$input = [];
	$input['name']	 = $name;
	$input['type']	 = 'select';
	$input['values'] = $values;
	$input['onchange'] = 'this.form.submit()';
	$config['input'][$name] = $input;

	//	...
	$values = [''];
	if( $database = filter_input(INPUT_POST, 'database') ){
		foreach( $db->Query($sql->Show(['database'=>$database], $db), 'show') as $value ){
			$values[$value] = $value;
		}
	}

	//	...
	$name  = 'table';
	$input = [];
	$input['name']	 = $name;
	$input['type']	 = 'select';
	$input['values'] = $values;
	$input['onchange'] = 'this.form.submit()';
	$config['input'][$name] = $input;
}

//	...
return $config;
