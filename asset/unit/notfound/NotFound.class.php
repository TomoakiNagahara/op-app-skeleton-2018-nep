<?php
/**
 * unit-notfound:/NotFound.class.php
 *
 * @creation  2019-01-29
 * @version   1.0
 * @package   unit-notfound
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @creation  2019-01-29
 */
namespace OP\UNIT;

/** NotFound
 *
 * @creation  2019-01-29
 * @version   1.0
 * @package   unit-NotFound
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class NotFound implements \IF_UNIT
{
	/** trait.
	 *
	 */
	use \OP_CORE;

	static private $_debug;

	static private function _Config()
	{
		//	...
		$config = \Env::Get(__CLASS__);

		//	...
		if( empty($config) ){
			//	...
			foreach( $config = include(__DIR__.'/config.db.php') as $key => $val ){
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

	/**
	 *
	 * @return \IF_DATABASE
	 */
	static function _DB()
	{
		//	...
		static $_DB;

		//	...
		if(!$_DB){
			$_DB = \Unit::Instantiate('Database');
			$_DB->Connect( self::_Config() );
		};

		//	...
		return $_DB->isConnect() ? $_DB: false;
	}

	static function Auto()
	{
		//	...
		$host  = $_SERVER['SERVER_NAME'];
	//	$port  = $_SERVER['SERVER_PORT'];
		$uri   = $_SERVER['REQUEST_URI'];
		$parse = parse_url($uri);
		$path  = $parse['path'];
	//	$query = $parse['query'];
		$ua    = $_SERVER['HTTP_USER_AGENT'];

		//	...
		$host = self::_Host($host);
		$uri  = self::_URI($path);
		$ua   = self::_UA($ua);
		self::_NotFound($host, $uri, $ua);
	}

	static function Hash(string $str):string
	{
		return Hasha1($str, 10, '');
	}

	static private function _Host(string $host):int
	{
		//	...
		if(!$db = self::_DB() ){
			return;
		};

		//	...
		$table = 't_host';

		//	...
		$hash = self::Hash($host);

		//	...
		if( $ai = $db->Quick(" ai <- {$table}.hash = {$hash} ", ['limit'=>1]) ){
			//	Exists
		}else{
			//	...
			$config = [];
			$config['table'] = $table;
			$config['set']['hash'] = $hash;
			$config['set']['host'] = $host;

			//	...
			$ai = $db->Insert($config);
		};

		//	...
		return $ai;
	}

	static private function _URI(string $uri):int
	{
		//	...
		if(!$db = self::_DB() ){
			return;
		};

		//	...
		$table = 't_uri';

		//	...
		$hash = $hash = self::Hash($uri);

		//	...
		if( $ai = $db->Quick(" ai <- {$table}.hash = {$hash} ", ['limit'=>1]) ){
			//	Exists
		}else{
			//	...
			$config = [];
			$config['table'] = $table;
			$config['set']['hash'] = $hash;
			$config['set']['uri']  = $uri;

			//	...
			$ai = $db->Insert($config);
		};

		//	...
		return $ai;
	}

	static private function _UA(string $ua):int
	{
		//	...
		if(!$db = self::_DB() ){
			return;
		};

		//	...
		$table = 't_ua';

		//	...
		$hash = $hash = self::Hash($ua);

		//	...
		if( $ai = $db->Quick(" ai <- {$table}.hash = {$hash} ", ['limit'=>1]) ){
			//	Exists
		}else{
			//	...
			$config = [];
			$config['table'] = $table;
			$config['set']['hash'] = $hash;
			$config['set']['ua']   = $ua;

			//	...
			$ai = $db->Insert($config);
		};

		//	...
		return $ai;
	}

	static function _OS($ua)
	{
		//	...
		$result = null;

		//	...
		foreach( ['Macintosh','Windows','Linux','BSD','iOS','Android'] as $name ){
			D($name);
		};

		//	...
		return $result;
	}

	static function _Browser($ua)
	{
		//	...
		$result = null;

		//	...
		foreach( ['Firefox','Chrome','Safari'] as $name ){
			if( $pos = strpos($ua, $name) ){
				$len = strlen($name);

				//	...
				list($v1, $v2) = explode('.', substr($ua, $pos + $len +1 ));

				//	...
				$result['name']    = strtolower($name);
				$result['version'] = "{$v1}.{$v2}";

				//	...
				break;
			};
		};

		//	...
		return $result;
	}

	static function _NotFound(int $host, int $uri, int $ua)
	{
		//	...
		if(!$db = self::_DB() ){
			return;
		};

		//	...
		$table = 't_notfound';

		//	...
		$config = [];
		$config['table'] = $table;
		$config['where'][] = "host = $host";
		$config['where'][] = "uri  = $uri";
		$config['where'][] = "ua   = $ua";
		$config['limit'] = 1;

		//	...
		$count = ( $record = $db->Select($config) ) ? $record['count']: 0;
		$count++;

		//	...
		if( $count === 1 ){
			//	insert
			$config['set'] = $config['where'];
			$config['set'][] = "count = $count";
			unset($config['where']);
			unset($config['limit']);

			//	...
			$db->Insert($config);
		}else{
			//	update
			$config['set'][] = "count = $count";

			//	...
			$db->Update($config);
		};

		//	...
		return $count;
	}

	static function Admin()
	{
		//	...
		if(!$io = \Cookie::Get(__METHOD__) ){
			if(!$io = self::Selftest() ){
				return $io;
			};
		};

		//	Save selftest result.
		\Cookie::Set(__METHOD__, true, 60*60*24);

		//	...
		$db = \OP\UNIT\NotFound::_DB();

		//	...
		\App::Template(__DIR__.'/admin.phtml', ['db'=>$db]);
	}

	static function Selftest()
	{
		//	...
		if(!\Unit::Load('selftest') ){
			return;
		};

		/* @var $selftest \OP\UNIT\Selftest */
		if( $io = $selftest = \Unit::Instantiate('Selftest') ){
			$io = $selftest->Auto(__DIR__.'/config.selftest.php');
		};

		//	...
		if( false ){
		//	$selftest->Help();
		//	$selftest->Debug();
		};

		//	...
		return $io;
	}

	function Help($topic=null)
	{
		echo '<pre><code>';
		echo file_get_contents(__DIR__.'/README.md');
		echo '</code></pre>';
	}

	function Debug($topic=null)
	{
		D( self::$_debug );
	}
}
