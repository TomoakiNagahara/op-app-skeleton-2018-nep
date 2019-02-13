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

	static function DSN($dsn)
	{
		//	...
		if( $config = parse_url($dsn) ){
			$config['prod']		 = $config['scheme'] ?? null;
			$config['password']	 = $config['pass'];

			//	...
			if( empty($config['port']) ){
				$config['port']	 = '3306';
			};

			//	...
			if( isset($config['query']) ){
				parse_str($config['query'], $query);
				foreach( $query as $key => $val ){
					$config[$key] = $val;
				};
			};
		};

		//	...
		unset($config['scheme']);
		unset($config['pass']);

		//	...
		return $config;
	}

	/** Get configuration.
	 *
	 * @return string|number|boolean|array|object
	 */
	static private function _Config()
	{
		//	...
		static $config;

		//	...
		if(!$config ){
			//	...
			$config = \Env::Get('notfound');

			//	...
			if( $dsn = $config['dsn'] ?? null ){
				$config = self::DSN($dsn);
			};

			//	...
			include(__DIR__.'/config/db.php');

			//	...
			\Env::Set('notfound', $config);
		};

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
