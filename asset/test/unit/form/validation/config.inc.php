<?php
/**
 * unit-test:/unit/form/validation/config.php
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
$form['error']	 = '$rule is error.';

//	...
$name  = 'required';
$input['label']	 = $label = ucfirst($name);
$input['type']	 = 'text';
$input['name']	 = $name;
$input['rule']	 = $name;
$input['placeholder'] = $name;
$form['input'][$name] = $input;

//	...
$name  = 'number';
$input['label']	 = $label = ucfirst($name);
$input['name']	 = $name;
$input['rule']	 = $name;
$input['placeholder'] = $name;
$form['input'][$name] = $input;

//	...
$name  = 'integer';
$input['label']	 = $label = ucfirst($name);
$input['name']	 = $name;
$input['rule']	 = $name;
$input['placeholder'] = $name;
$form['input'][$name] = $input;

//	...
$name  = 'positive';
$input['label']	 = $label = ucfirst($name);
$input['name']	 = $name;
$input['rule']	 = $name;
$input['placeholder'] = $name;
$form['input'][$name] = $input;

//	...
$name  = 'negative';
$input['label']	 = $label = ucfirst($name);
$input['name']	 = $name;
$input['rule']	 = $name;
$input['placeholder'] = $name;
$form['input'][$name] = $input;

//	...
$name  = 'alphabet';
$input['label']	 = $label = ucfirst($name);
$input['name']	 = $name;
$input['rule']	 = $name;
$input['placeholder'] = $name;
$form['input'][$name] = $input;

//	...
$name  = 'alphanumeric';
$input['label']	 = $label = ucfirst($name);
$input['name']	 = $name;
$input['rule']	 = $name;
$input['error']	 = '$Name is $rule error. ($value)';
$input['placeholder'] = $name;
$form['input'][$name] = $input;

//	...
$name  = 'english';
$input['label']	 = $label = ucfirst($name);
$input['name']	 = $name;
$input['rule']	 = $name;
$input['error']	 = '$Name is $rule error. ($value)';
$input['placeholder'] = "Only $label";
$form['input'][$name] = $input;

//	...
$name  = 'hankaku';
$input['label']	 = $label = ucfirst($name);
$input['name']	 = $name;
$input['rule']	 = "$name, katakana";
$input['error']	 = '<span>$Name is $rule error. ($value)</span>';
$input['placeholder'] = "Only $label character";
$form['input'][$name] = $input;

//	...
$name  = 'zenkaku';
$input['label']	 = $label = ucfirst($name);
$input['name']	 = $name;
$input['rule']	 = $name;
$input['error']	 = '$Name is $rule error. ($value)';
$input['placeholder'] = "Only $label character";
$form['input'][$name] = $input;

//	...
$name  = 'hiragana';
$input['label']	 = $label = ucfirst($name);
$input['name']	 = $name;
$input['rule']	 = $name;
$input['error']	 = '$Name is $rule error. ($value)';
$input['placeholder'] = 'Only Japanese '.$label;
$form['input'][$name] = $input;

//	...
$name  = 'katakana';
$input['label']	 = $label = ucfirst($name);
$input['name']	 = $name;
$input['rule']	 = $name;
$input['error']	 = '$Name is $rule error. ($value)';
$input['placeholder'] = 'Only Japanese '.$label;
$form['input'][$name] = $input;

//	...
$name  = 'kana';
$input['label']	 = ucfirst($name);
$input['name']	 = $name;
$input['rule']	 = $name;
$input['error']	 = '$Name is $rule error. ($value)';
$input['placeholder'] = 'Only Japanese Hiragana and Katakana';
$form['input'][$name] = $input;

//	...
$name  = 'han';
$input['label']	 = ucfirst($name);
$input['name']	 = $name;
$input['rule']	 = $name;
$input['error']	 = '$Name is $rule error. ($value)';
$input['placeholder'] = 'Han character of Chinese, Japanese, Korea and Vietnam';
$form['input'][$name] = $input;

//	...
$name  = 'min';
$input['label']	 = ucfirst($name);
$input['name']	 = $name;
$input['rule']	 = $name.'(10)';
$input['error']	 = 'Minimum 10 number. (Under $value)';
$input['placeholder'] = 'Minimum 10 number';
$form['input'][$name] = $input;

//	...
$name  = 'max';
$input['label']	 = ucfirst($name);
$input['name']	 = $name;
$input['rule']	 = $name.'(10)';
$input['error']	 = 'Maximum 10 number. (Over $value)';
$input['placeholder'] = 'Maximum 10 number';
$form['input'][$name] = $input;

//	...
$name  = 'short';
$input['label']	 = ucfirst($name);
$input['name']	 = $name;
$input['rule']	 = $name.'(10)';
$input['error']	 = 'Minimum 10 character. (Shortage $value character.)';
$input['placeholder'] = 'Minimum 10 character';
$form['input'][$name] = $input;

//	...
$name  = 'long';
$input['label']	 = ucfirst($name);
$input['name']	 = $name;
$input['rule']	 = $name.'(10)';
$input['error']	 = 'Maximum 10 character. (Longer $value character)';
$input['placeholder'] = 'Maximum 10 character';
$form['input'][$name] = $input;

//	...
return $form;
