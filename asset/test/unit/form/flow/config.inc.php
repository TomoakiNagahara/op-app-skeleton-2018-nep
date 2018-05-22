<?php
/**
 * unit-test:/unit/form/flow/config.php
 *
 * @creation  2018-05-15
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
$form = [];
$form['name']	 = 'testcase-validation';
$form['error']	 = '$Name is $rule error.';

//	...
$name  = 'nickname';
$input['label']	 = $label = ucfirst($name);
$input['type']	 = 'text';
$input['name']	 = $name;
$input['rule']	 = 'required';
$input['placeholder'] = $name;
$form['input'][$name] = $input;

//	...
return $form;
