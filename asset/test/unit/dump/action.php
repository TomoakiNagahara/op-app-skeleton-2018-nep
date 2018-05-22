<?php
/**
 * unit-test:/unit/dump/action.php
 *
 * @creation  2018-04-16
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
D(true, false, null, 0, 1, 1.1, "文字列", " ", "", "true", "false", "null", [true, false, null]);

//	...
$args = [];
$args['boolean'] = [true, false, null];
$args['number']  = [0, 1, 1.1];
$args['string']  = ['true', 'false', 'null', '0', '1', '1.1', '', ' ', "\t", "\r", "\n"];
$args['assoc']   = ['weather'=>['Sunny','Cloudy','Rainy']];
D($args);

//	...
$obj = new stdClass();
$obj->bool   = true;
$obj->array  = [true, false];
$obj->object = new stdClass();
$obj->object->test = true;
D($obj);

//	...
D('<h1>XSS', ['<h1>XSS'=>'<h1>XSS']);
