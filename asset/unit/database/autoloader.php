<?php
/**
 * unit-database:/autoloader.php
 *
 * @created   2018-05-18
 * @version   1.0
 * @package   unit-database
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
spl_autoload_register( function($name){
	//	...
	$namespace = 'OP\UNIT\DATABASE\\';

	//	...
	if( strpos($name, $namespace) !== 0 ){
		return;
	}

	//	...
	$class = str_replace($namespace, '', $name);

	//	...
	$path = __DIR__."/{$class}.class.php";

	//	...
	if( file_exists($path) ){
		include($path);
	}else{
		Notice::Set("Does not exists this file. ($path)");
	}
});
