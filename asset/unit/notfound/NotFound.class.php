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
 * @package   unit-notfound
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class NotFound implements \IF_UNIT
{
	/** trait.
	 *
	 */
	use \OP_CORE;

	/** Debug.
	 *
	 * @var array
	 */
	static private $_debug;

	/** Will execute automatically.
	 *
	 */
	static function Auto()
	{
		//	...
		if( $DB = NOTFOUND\Common::DB() ){
			$host = self::_Host( $DB );
			$uri  = self::_URI(  $DB );
			$ua   = self::_UA(   $DB );
					self::_NotFound( $DB, $host, $uri, $ua );
		};
	}

	/** Host name
	 *
	 * @param	\IF_DATABASE $DB
	 * @return	 int		 $ai
	 */
	static private function _Host( \IF_DATABASE $DB ):int
	{
		//	...
		$host  = $_SERVER['SERVER_NAME'];
	//	$port  = $_SERVER['SERVER_PORT'];

		//	...
		$table = 't_host';
		$hash  = NOTFOUND\Common::Hash($host);

		//	...
		if( $ai = $DB->Quick(" ai <- {$table}.hash = {$hash} ", ['limit'=>1]) ){
			//	Exists
		}else{
			//	...
			$config = [];
			$config['table'] = $table;
			$config['set']['hash'] = $hash;
			$config['set']['host'] = $host;

			//	...
			$ai = $DB->Insert($config);
		};

		//	...
		return $ai;
	}

	/** URI
	 *
	 * @param	\IF_DATABASE $DB
	 * @return	 int		 $ai
	 */
	static private function _URI( \IF_DATABASE $DB ):int
	{
		//	...
		$uri   = $_SERVER['REQUEST_URI'];
		$parse = parse_url($uri);
		$path  = $parse['path'];
	//	$query = $parse['query'];

		//	...
		$table = 't_uri';
		$hash  = NOTFOUND\Common::Hash($path);

		//	...
		if( $ai = $DB->Quick(" ai <- {$table}.hash = {$hash} ", ['limit'=>1]) ){
			//	Exists
		}else{
			//	...
			$config = [];
			$config['table'] = $table;
			$config['set']['hash'] = $hash;
			$config['set']['uri']  = $path;

			//	...
			$ai = $DB->Insert($config);
		};

		//	...
		return $ai;
	}

	/** User agent
	 *
	 * @param	\IF_DATABASE $DB
	 * @return	 int		 $ai
	 */
	static private function _UA( \IF_DATABASE $DB ):int
	{
		//	...
		$ua    = $_SERVER['HTTP_USER_AGENT'];

		//	...
		$table = 't_ua';
		$hash  = NOTFOUND\Common::Hash($ua);

		//	...
		if( $ai = $DB->Quick(" ai <- {$table}.hash = {$hash} ", ['limit'=>1]) ){
			//	Exists
		}else{
			//	...
			$config = [];
			$config['table'] = $table;
			$config['set']['hash'] = $hash;
			$config['set']['ua']   = $ua;

			//	...
			$ai = $DB->Insert($config);
		};

		//	...
		return $ai;
	}

	/** OS
	 *
	 * @param	\IF_DATABASE $DB
	 * @param	 string		 $ua
	 * @return	 int		 $ai
	 */
	static private function _OS( \IF_DATABASE $DB, string $ua ):int
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

	/** Browser
	 *
	 * @param	\IF_DATABASE $DB
	 * @param	 string		 $ua
	 * @return	 int		 $ai
	 */
	static private function _Browser(  \IF_DATABASE $DB, string $ua ):int
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

	/** NotFound
	 *
	 * @param	\IF_DATABASE $DB
	 * @param	 string		 $host
	 * @param	 string		 $uri
	 * @param	 string		 $ua
	 * @return	 int		 $count
	 */
	static private function _NotFound( \IF_DATABASE $DB, int $host, int $uri, int $ua ):int
	{
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
		$count = ( $record = $DB->Select($config) ) ? $record['count']: 0;
		$count++;

		//	...
		if( $count === 1 ){
			//	insert
			$config['set'] = $config['where'];
			$config['set'][] = "count = $count";
			unset($config['where']);
			unset($config['limit']);

			//	...
			$DB->Insert($config);
		}else{
			//	update
			$config['set'][] = "count = $count";

			//	...
			$DB->Update($config);
		};

		//	...
		return $count;
	}

	/** Will execute automatically of Admin.
	 *
	 */
	static function Admin()
	{
		//	...
		if( $db = NOTFOUND\Common::DB() ){
			//	...
			if( include(__DIR__.'/admin/Admin.class.php') ){
				NOTFOUND\Admin::Auto($db);
			};
		}else{
			//	Throw away connection error notice.
			\Notice::Pop();

			//	...
			if( include(__DIR__.'/selftest/Selftest.class.php') ){
				Html('Connection was failed', '.error');
				NOTFOUND\Selftest::Auto($db);
			};
		};
	}

	/** For developers.
	 *
	 *
	 * @see \IF_UNIT::Help()
	 * @param	 string		 $topic
	 */
	function Help($topic=null)
	{
		echo '<pre><code>';
		echo file_get_contents(__DIR__.'/README.md');
		echo '</code></pre>';
	}

	/** For developers.
	 *
	 * @see \IF_UNIT::Debug()
	 * @param	 string		 $topic
	 */
	function Debug($topic=null)
	{
		D( self::$_debug );
	}
}
