<?php
/**
 * unit-NotFound:/NotFound.class.php
 *
 * @creation  2019-01-29
 * @version   1.0
 * @package   unit-NotFound
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

	static private function _Config()
	{
		//	...
		$config = \Env::Get(__CLASS__);

		//	...
		foreach([
			'prod'     => 'mysql',
			'host'     => 'localhost',
			'user'     => 'notfound',
			'password' => 'password',
			'database' => 'onepiece',
		] as $key => $val ){
			//	If not set.
			if(!isset($config[$key]) ){
				//	Set default value.
				$config[$key] = $val;
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
	static private function _DB()
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

	static private function _Host(string $host):int
	{
		//	...
		if(!$db = self::_DB() ){
			return;
		};

		//	...
		$table = 't_host';

		//	...
		$hash = Hasha1($host, 10, '');

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
		$hash = Hasha1($uri, 10, '');

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
		$hash = Hasha1($ua, 10, '');

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

	function Help()
	{
		echo '<pre><code>';
		echo file_get_contents(__DIR__.'/README.md');
		echo '</code></pre>';
	}

	function Debug()
	{
		D();
	}
}
