<?php
/**
 * unit-test:/unit/form/config.php
 *
 * @creation  2018-05-15
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
$form = [];
$form['name'] = 'testcase';

//	...
$name  = 'text';
$input = [];
$input['label']	 = 'Text';
$input['name']	 = $name;
$input['type']	 = 'text';
$form['input'][$name] = $input;

//	...
$name  = 'textarea';
$input = [];
$input['label']	 = 'Textarea';
$input['name']	 = $name;
$input['type']	 = 'textarea';
$form['input'][$name] = $input;

//	...
$name  = 'select';
$input = [];
$input['label']	 = 'Select';
$input['name']	 = $name;
$input['type']	 = 'select';
$input['option'] = ['','Android','Blackberry','Cymbian'];
$form['input'][$name] = $input;

//	...
$name  = 'multiple';
$input = [];
$input['label']	 = 'Multiple';
$input['name']	 = $name;
$input['type']	 = 'select';
$input['multiple'] = true;
$input['option'] = ['a'=>'Android','b'=>'Blackberry','c'=>'Cymbian'];
$form['input'][$name] = $input;

//	...
$name  = 'radio';
$input = [];
$input['label']	 = 'Radio';
$input['name']	 = $name;
$input['type']	 = 'radio';
$input['option'] = ['a'=>'Android','b'=>'Blackberry','c'=>'Cymbian'];
$form['input'][$name] = $input;

//	...
$name  = 'checkbox';
$input = [];
$input['label']	 = 'Checkbox';
$input['name']	 = $name;
$input['type']	 = 'checkbox';
$input['option'] = ['a'=>'Android','b'=>'Blackberry','c'=>'Cymbian'];
$form['input'][$name] = $input;

//	...
$name  = 'cookie';
$input = [];
$input['label']	 = 'Cookie';
$input['name']	 = $name;
$input['type']	 = 'checkbox';
$input['cookie'] = true;
$input['option'] = ['agree'=>'Save to cookie. (Cross over sessions)'];
$form['input'][$name] = $input;

//	...
$name  = 'session';
$input = [];
$input['label']	 = 'Session';
$input['name']	 = $name;
$input['type']	 = 'checkbox';
$input['session']= false;
$input['option'] = ['agree'=>'Does not save value. (Do not save to session)'];
$form['input'][$name] = $input;

//	...
$name  = 'file';
$input = [];
$input['label']	 = 'File';
$input['name']	 = $name;
$input['type']	 = 'file';
$form['input'][$name] = $input;

//	...
return $form;
