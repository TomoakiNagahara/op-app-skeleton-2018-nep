<?php
/**
 * unit-db:/autoloader.php
 *
 * @creation  2017-12-18
 * @version   1.0
 * @package   unit-db
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
spl_autoload_register( function($name){
	//	...
	$namespace = 'OP\UNIT\DB';

	//	...
	if( $name === 'OP\UNIT\DB' ){
		$name  =  'DB';
	}else
		if( strpos($name, $namespace) === 0 ){
			$name = substr($name, strlen($namespace) +1);
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
