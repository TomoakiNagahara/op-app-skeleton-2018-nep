<?php
/**
 * Autoloader.class.php
 *
 * @creation  2014-11-29 --> 2016-06-09
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/**
 * Autoloader
 *
 * @creation  2014-11-29 --> 2016-06-09
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Autoloader
{
	/** trait.
	 *
	 */
	use OP_CORE;

	/** Autoload.
	 *
	 * @param string $class_name
	 */
	static function Autoload($class_name)
	{
		//	...
		if( strpos($class_name, 'OP\\') === 0 ){
			$class_name = substr($class_name, 3);
		}

		//	...
		if( class_exists($class_name, false) ){
			return;
		}

		//	Which to class or trait.
		if( strpos($class_name, 'OP_') === 0 ){
			$file_name = "{$class_name}.trait.php";
		}else if( strpos($class_name, 'IF_') === 0 ){
			$file_name = "{$class_name}.interface.php";
		}else{
			$file_name = "{$class_name}.class.php";
		}

		//	Generate full path.
		$file_path = __DIR__.'/'.$file_name;

		//	...
		if( file_exists( $file_path) ){
			include_once($file_path);
		}
	}
}

/** Register autoload.
 *
 */
spl_autoload_register('Autoloader::Autoload',true,true);
