<?php
/**
 * index.php
 *
 * @creation  2017-06-08
 * @version   1.0
 * @package   unit-google
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	Setup auto loader.
spl_autoload_register( function ($name){
	try {
		//	...
		$path = __DIR__."/{$name}.class.php";

		//	...
		if( file_exists($path) ){
			include($path);
		}
	} catch ( Throwable $e ){
		Notice::Set($e);
	}
});
return true;