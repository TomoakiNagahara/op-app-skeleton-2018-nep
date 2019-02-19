<?php
/**
 * unit-selftest:/config.form.php
 *
 * @created   2018-02-12
 * @version   1.0
 * @package   unit-selftest
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
$form = [];
$form['name'] = 'selftest';

//	...
$name  = 'prod';
$input = [];
$input['name']  = $name;
$input['type']  = 'select';
$input['label'] = 'Product';
$input['cookie']   = true;
$input['option'][] = 'mysql';
$form['input'][] = $input;

//	...
$name  = 'host';
$input = [];
$input['name']  = $name;
$input['type']  = 'text';
$input['label'] = ucfirst($name);
$input['value'] = 'localhost';
$input['cookie'] = true;
$form['input'][] = $input;

//	...
$name  = 'port';
$input = [];
$input['name']  = $name;
$input['type']  = 'text';
$input['label'] = ucfirst($name);
$input['value'] = '3306';
$input['cookie'] = true;
$form['input'][] = $input;

//	...
$name  = 'user';
$input = [];
$input['name']  = $name;
$input['type']  = 'text';
$input['label'] = ucfirst($name);
$input['value'] = 'root';
$input['cookie'] = true;
$form['input'][] = $input;

//	...
$name  = 'password';
$input = [];
$input['name']  = $name;
$input['type']  = 'password';
$input['label'] = ucfirst($name);
$form['input'][] = $input;

//	...
$name  = 'charset';
$input = [];
$input['name']  = $name;
$input['type']  = 'text';
$input['label'] = ucfirst($name);
$input['value'] = 'utf8';
$input['cookie'] = true;
$form['input'][] = $input;

return $form;
