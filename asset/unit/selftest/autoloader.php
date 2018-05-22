<?php
/**
 * unit-selftest:/autoloader.php
 *
 * @creation  2017-12-09
 * @version   1.0
 * @package   unit-selftest
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
spl_autoload_register( function($name){
	//	...
	$UNIT = 'SELFTEST';
	$unit = strtolower($UNIT);
	$Unit = ucfirst($unit);

	//	...
	$name = trim($name, '\\');

	//	...
	$namespace = "OP\UNIT\\{$UNIT}";

	//	...
	if( $name === "OP\UNIT\\{$Unit}" ){
		$name  =  $Unit;
	}else if( strpos($name, $namespace) === 0 ){
		$name = substr($name, strlen($namespace)+1);
	}else{
		return;
	}

	//	...
	$path = __DIR__."/{$name}.class.php";

	//	...
	if( file_exists($path) ){
		include($path);
	}else{
		Notice::Set("Does not exists this file. ($path)");
	}
});
