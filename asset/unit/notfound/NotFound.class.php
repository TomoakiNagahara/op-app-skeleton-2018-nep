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
			$record = $DB->Quick(" {$table}.ai = {$ai} ", ['limit'=>1]);

			/*
			//	...
			if(!$record['os'] ){
				if( $os = self::_OS($ai) ){
					//	...
					$config = [];
					$config['table'] = $table;
					$config['limit'] = 1;
					$config['set'][] = "   os = $os ";
					$config['where'][] = " ua = $ai ";
					$DB->Update($config);
				};
			};

			//	...
			if(!$record['browser'] ){
				if( $browser = self::_Browser($ai) ){
					//	...
					$config = [];
					$config['table'] = $table;
					$config['limit'] = 1;
					$config['set'][] = " browser = $browser ";
					$config['where'][] = " ua = $ai ";
					$DB->Update($config);
				};
			};
			*/
		}else{
			//	...
			$config = [];
			$config['table'] = $table;
			$config['set']['hash']    = $hash;
			$config['set']['ua']      = $ua;
			$config['set']['os']      = self::_OS($DB);
			$config['set']['browser'] = self::_Browser($DB);

			//	...
			$ai = $DB->Insert($config);
		};

		//	...
		return $ai;
	}

	/** OS
	 *
	 * @param	 integer	 $ua_ai
	 * @return	 int|null	 $ai
	 */
	static private function _OS( $ua_ai )
	{
		//	...
		$table = 't_ua_os';

		//	...
		$ua = NOTFOUND\Common::DB()->Quick(" ua <- t_ua.ai = {$ua_ai} ", ['limit'=>1]);

		//	...
		$os = NOTFOUND\Common::DB()->Quick(" os <- {$table}.ua = {$ua_ai} ", ['limit'=>1]);

		//	...
		if( $os ){ return; };

		//	...
		foreach( ['Mac','Win','Linux','BSD','iOS','Android'] as $os ){
			//	...
			if(!preg_match("/$os/", $ua) ){
				continue;
			};

			//	...
			$config = [];
			$config['table'] = $table;
			$config['set'][] = "ua = $ua_ai";
			$config['set'][] = "os = $os";
			NOTFOUND\Common::DB()->Insert($config);
		};

		//	...
		return $os;
	}

	/** Browser
	 *
	 * @param	 integer	 $ua_ai
	 * @return	 int|null	 $ai
	 */
	static private function _Browser( $ua_ai )
	{
		//	...
		$table = 't_ua_browser';

		//	...
		$ua = NOTFOUND\Common::DB()->Quick(" ua <- t_ua.ai = {$ua_ai} ", ['limit'=>1]);

		//	...
		$browser = NOTFOUND\Common::DB()->Quick(" browser <- {$table}.ua = {$ua_ai} ", ['limit'=>1]);

		//	...
		if( $browser ){ return $browser; };

		//	...
		foreach( ['Firefox','Chrome','Safari'] as $name ){
			if( $pos = strpos($ua, $name) ){
				$len = strlen($name);

				//	...
				list($v1, $v2) = explode('.', substr($ua, $pos + $len +1 ));

				//	...
				$config = [];
				$config['table'] = $table;
				$config['set']['ua'] = $ua_ai;
				$config['set']['browser'] = $name;
				$config['set']['version'] = "{$v1}.{$v2}";
				NOTFOUND\Common::DB()->Insert($config);

				//	...
				break;
			};
		};

		//	...
		return $browser;
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
