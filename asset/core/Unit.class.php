<?php
/**
 * Unit.class.php
 *
 * @creation  2016-11-28
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** Unit
 *
 * <pre>
 * //	Set unit directory.
 * Unit::Director('app:/asset/unit');
 *
 * //	Get instance.
 * $obj = Unit::Instance('UnitName');
 *
 * //	Get singleton instance.
 * $obj = Unit::Singleton('UnitName');
 *
 * //	Load static class.
 * Unit::Load('unitname');
 *
 * //	Use static class.
 * $val = OP\UNIT\NAME::Get();
 * </pre>
 *
 * @creation  2016-11-28
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Unit
{
	/** trait.
	 *
	 */
	use OP_CORE;

	/** Get/Set unit directory.
	 *
	 * @param  string|null         $dir
	 * @return string|null|boolean $dir
	 */
	static function Directory($dir=null)
	{
		static $_dir;

		//	...
		if( $dir ){
			//	...
			if( strpos($dir, ':') ){
				$dir = rtrim(ConvertPath($dir), '/').'/';
			}

			//	...
			_GetRootsPath('unit', $dir);

			//	...
			if(!file_exists($dir)){
				$message = "Does not exists unit directory. ($dir)";
				Notice::Set($message);
				return false;
			}

			//	...
			$_dir = $dir;
		}

		//	...
		return $_dir;
	}

	/** Return new instance.
	 *
	 * This method is wrapper method of Instantiate.
	 *
	 * @param  string $name
	 * @return object
	 */
	static function Instance($name)
	{
		return self::Instantiate($name);
	}

	/** Return new instance.
	 *
	 * @param  string $name
	 * @return object
	 */
	static function Instantiate($name)
	{
		//	...
		if(!self::Load($name)){
			return false;
		}

		//	...
		try{
			//	Generate name space path.
			$path = '\OP\UNIT\\'.$name;

			//	Instantiate.
			return new $path();

		}catch( Throwable $e ){
			Notice::Set($e);
			return false;
		}
	}

	/** Return already instantiated instance.
	 *
	 * @param  string $name
	 * @return boolean|object
	 */
	static function Singleton($name)
	{
		static $_pool;

		//	...
		if( isset( $_pool[$name] ) ){
			return $_pool[$name];
		}

		//	Instantiate.
		$_pool[$name] = self::Instance($name);

		//	...
		return $_pool[$name];
	}

	/** Load of unit controller.
	 *
	 * @param string $name
	 */
	static function Load($name)
	{
		static $_result;

		//	...
		$name = strtolower($name);

		//	Why?
	//	$hash = Hasha1($name);
		$hash = $name;

		//	...
		if( isset( $_result[$hash] ) ){
			return $_result[$hash];
		}

		//	...
		if(!$dir = self::Directory() ){
			$message = "Has not been set unit directory.\n".' Example: Unit::Directory("app:/asset/unit");';
			Notice::Set($message);
			return false;
		}

		//	...
		$dir = ConvertPath($dir);
		$dir = realpath($dir);

		//	...
		if(!file_exists($dir)){
			$message = "Does not exists unit directory. ($dir)";
			Notice::Set($message);
			return false;
		}

		//	...
		if(!file_exists("{$dir}/{$name}")){
			//	...
			$message = "Does not exists this unit. ($dir/$name)";
			Notice::Set($message);
			return false;
		}

		//	...
		$path = "{$dir}/{$name}/index.php";

		//	...
		if(!file_exists($path)){
			$message = "Does not exists unit controller. ({$name}/index.php)";
			Notice::Set($message);
			return false;
		}

		//	...
		$_result[$hash] = include($path);

		//	...
		return $_result[$hash];
	}
}
