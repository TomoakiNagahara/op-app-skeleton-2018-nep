<?php
/**
 * unit-test:/unit/database/scaffold/form.conf.php
 *
 * @creation  2018-06-10
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
$form = [];
$form['name']   = 'testcase-scaffold';
$form['action'] = '';

//	...
$name  = 'prod';
$input = [];
$input['name']	 = $name;
$input['type']	 = 'select';
$input['option'] = ['mysql'];
$input['rule']	 = 'required';
$form['input'][$name] = $input;

//	...
$name  = 'host';
$input = [];
$input['name']	 = $name;
$input['type']	 = 'text';
$input['value']	 = 'localhost';
$input['rule']	 = 'required';
$form['input'][$name] = $input;

//	...
$name  = 'port';
$input = [];
$input['name']	 = $name;
$input['type']	 = 'text';
$input['value']	 = '3306';
$input['rule']	 = 'required';
$form['input'][$name] = $input;

//	...
$name  = 'user';
$input = [];
$input['name']	 = $name;
$input['type']	 = 'text';
$input['rule']	 = 'required';
$form['input'][$name] = $input;

//	...
$name  = 'password';
$input = [];
$input['name']	 = $name;
$input['type']	 = 'password';
$input['rule']	 = 'required';
$form['input'][$name] = $input;

//	...
$name  = 'charset';
$input = [];
$input['name']	 = $name;
$input['type']	 = 'text';
$input['value']	 = 'utf8';
$input['rule']	 = 'required';
$form['input'][$name] = $input;

return $form;
