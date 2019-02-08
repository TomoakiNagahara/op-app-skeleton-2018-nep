<?php
/**
 * unit-notfound:/Common.class.php
 *
 * @creation  2019-02-06
 * @version   1.0
 * @package   unit-notfound
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @creation  2019-02-06
 */
namespace OP\UNIT\NOTFOUND;

/** Common
 *
 * @creation  2019-02-06
 * @version   1.0
 * @package   unit-notfound
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Common
{
	/** trait.
	 *
	 */
	use \OP_CORE;

	/** Get configuration.
	 *
	 * @return string|number|boolean|array|object
	 */
	static private function _Config()
	{
		//	...
		$config = \Env::Get(__CLASS__);

		//	...
		if( empty($config) ){
			//	...
			foreach( $config = include(__DIR__.'/config/db.php') as $key => $val ){
				//	If not set.
				if(!isset($config[$key]) ){
					//	Set default value.
					$config[$key] = $val;
				};
			};
		};

		//	...
		\Env::Set(__CLASS__, $config);

		//	...
		return $config;
	}

	/** Get IF_DATABASE object.
	 *
	 * @return \IF_DATABASE
	 */
	static function DB()
	{
		//	...
		static $_DB;

		//	...
		if(!$_DB ){
			$_DB = \Unit::Instantiate('Database');
			$_DB->Connect( self::_Config() );
		};

		//	...
		return $_DB->isConnect() ? $_DB: false;
	}

	/** Generate common hash.
	 *
	 * @param	 string		 $str
	 * @return	 string		 $hash
	 */
	static function Hash(string $str):string
	{
		/** CAUTION
		 *
		 *  Salt is commonlize.
		 *  Because that for sharing with all applications.
		 *
		 */
		return Hasha1($str, 10, '');
	}
}
