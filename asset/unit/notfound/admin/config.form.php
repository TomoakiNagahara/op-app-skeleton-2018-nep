<?php
/**
 * unit-notfound:/config.form.php
 *
 * @creation  2019-01-30
 * @version   1.0
 * @package   unit-notfound
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
$form = [];
$form['name'] = 'notfound';

//	...
$input = [];
$input['name']  = 'host';
$input['type']  = 'select';
$input['label'] = 'Host';
$input['option'][] = '';
$input['option'][] = 'localhost';
$form['input'][] = $input;

//	...
$input = [];
$input['name']  = 'submit';
$input['type']  = 'submit';
$input['label'] = 'Submit';
$input['value'] = ' Submit ';
$form['input'][] = $input;

//	...
return $form;
