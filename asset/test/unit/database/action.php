<?php
/**
 * unit-test:/unit/database/action.php
 *
 * @creation  2018-04-24
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

//	...
$args = App::Args();

//	...
switch( $file = $args[0] ){
	case 'connect':
	case 'selftest':
	case 'select':
	case 'insert':
	case 'update':
	case 'delete':
	case 'quick':
		$file = "{$file}.php";
		if( file_exists($file) ){
			include($file);
		}else{
			D("File does not exists. ($file)");
		}
		break;
	default:
		D($file);
}
