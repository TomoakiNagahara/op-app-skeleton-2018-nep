<?php
/**
 * unit-sql:/autoloader.php
 *
 * @created   2017-12-12
 * @version   1.0
 * @package   unit-sql
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
spl_autoload_register( function($name){
	//	...
	$unit = 'SQL';

	//	...
	$namespace = "OP\UNIT\\{$unit}";

	//	...
	if( $name === $namespace ){
		$class = $unit;
	}else
		if( strpos($name, $namespace) === 0 ){
			$class = substr($name, strlen($namespace) +1);
	}else{
		return;
	}

	//	...
	$path = __DIR__."/{$class}.class.php";

	//	...
	if( file_exists($path) ){
		include($path);
	}else{
		Notice::Set("Does not exists this file. ($path)");
	}
});
