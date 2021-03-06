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

	/** Parse config from DSN format.
	 *
	 * @param	 string		 $dsn
	 * @return	 array		 $config
	 */
	static function DSN($dsn)
	{
		//	...
		if( $config = parse_url($dsn) ){
			//	...
			$config['prod']		 = $config['scheme'] ?? null;

			//	...
			if( $config['pass'] ?? null ){
				$config['password'] = $config['pass'];
			};

			//	...
			if( empty($config['port']) ){
				$config['port']	 = '3306';
			};

			//	...
			if( isset($config['query']) ){
				$query = [];
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
	 * @return	 array		 $config
	 */
	static private function _Config()
	{
		//	Get config from Env.
		if(!$config = \Env::Get('notfound') ){
		//	$this->Unit('notfound')->Help('Setup');
			throw new \Exception("See README.md at Setup section.");
		};

		//	If given DSN.
		if( $dsn = $config['dsn'] ?? null ){
			//	Parse DSN.
			$config = array_merge(self::DSN($dsn), $config);
			$config['dsn'] = null;

			//	Save parse result.
			\Env::Set('notfound', $config);
		};

		//	...
		foreach( ['prod','host','user','password','database'] as $key ){
			if( empty($config[$key]) ){
				throw new \Exception("Config has not been set this value. ($key)");
			};
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
		/* @var $_DB \IF_DATABASE */
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
