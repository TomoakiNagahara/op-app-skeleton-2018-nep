<?php
/**
 * unit-test:/core/functions/json.php
 *
 * @creation  2018-05-29
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
App::Template('json.phtml');

//	...
$json = [];
$json['array'][] = '<h1>XSS</h1>';
$json['assoc']['quote']['single'] = "<h1>'message'</h1>";
$json['assoc']['quote']['double'] = '<h1>"message"</h1>';
$json['assoc']['quote']['ampsnd'] = '<h1>&</h1>';

//	...
$json = Encode($json);

//	...
$class = ( $_GET['dump'] ?? 0 ) ? 'OP_DUMP': '';

//	...
Json($json, $class);

//	...
D($json);
