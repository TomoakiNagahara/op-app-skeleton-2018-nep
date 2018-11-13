<?php
/**
 * unit-newworld:/Router.class.php
 *
 * @creation  2017-05-09
 * @version   1.0
 * @package   unit-newworld
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2018-04-13
 */
namespace OP\UNIT\NEWWORLD;

/** Router
 *
 * @creation  2015-01-30 --> 2016-11-26
 * @version   1.0
 * @package   unit-newworld
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Router
{
	/** trait.
	 *
	 */
	use \OP_CORE;

	/** Use for route table's associative array key name.
	 *
	 * @var string
	 */
	const _ARGS_ = 'args';

	/** Use for route table's associative array key name.
	 *
	 * @var string
	 */
	const _END_POINT_ = 'end-point';

	/** Route table.
	 *
	 * @var array
	 */
	private static $_route;

	/** Init route table.
	 *
	 * <pre>
	 * 1. Search end-point by request uri.
	 * 2. Generate smart-url's arguments by request uri.
	 *
	 * Structure:
	 * {
	 *   "args" : [],
	 *   "end-point" : "/index.html"
	 * }
	 * </pre>
	 *
	 * @return array
	 */
	static private function _InitRouteTable()
	{
		global $_OP;

		//	...
		$file  = 'index.php'; // Env::Get(Router::_END_POINT_FILE_NAME_, 'index.php');

		//	...
		self::$_route = [];
		self::$_route['args'] = [];

		//	Generate real full path.
		$full_path = $_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI'];
	//	$full_path = str_replace('\\', '/', $full_path); // For Windows

		//	Check url query.
		if( $pos = strpos($full_path, '?') ){
			//	Separate url query.
			$query = substr($full_path, $pos+1);
			$full_path = substr($full_path, 0, $pos);
		}

		//	HTML path through.
		if( true ){
			//	Get extension.
			$extension = substr($full_path, strrpos($full_path, '.')+1);

			//	In case of html.
			if( $extension === 'html' ){
				if( file_exists($full_path) ){
					self::$_route[Router::_END_POINT_] = $full_path;
					return;
				}
			}
		}

		//	Added slash to tail. /www/foo/bar --> /www/foo/bar/
	//	$full_path = rtrim($full_path, '/').'/';

		//	Remove application root: /www/htdocs/api/foo/bar/ --> api/foo/bar/
		$uri = str_replace($_OP[APP_ROOT], '', $full_path);

		//	Remove slash from tail: api/foo/bar/ --> api/foo/bar
		$uri  = rtrim($uri, '/');

		//	/foo/bar --> ['foo','bar']
		$dirs = explode('/', $uri);

		//	...
		do{
			//	...
			$path = trim(join(DIRECTORY_SEPARATOR, $dirs).DIRECTORY_SEPARATOR.$file, DIRECTORY_SEPARATOR);

			//	...
			if( isset($dir) ){
				array_unshift(self::$_route['args'], _EscapeString($dir));
			}

			//	...
			$full_path = $_OP[APP_ROOT].$path;

			//	...
			if( file_exists($full_path) ){
				self::$_route[Router::_END_POINT_] = $full_path;
				break;
			}

			//	...
		}while( false !== $dir = array_pop($dirs) );
	}

	/** Get dispatch route by request uri.
	 *
	 * <pre>
	 * Structure:
	 * {
	 *   "args" : [],
	 *   "end-point" : "/index.html"
	 * }
	 * </pre>
	 *
	 * @return array
	 */
	static function Get()
	{
		if(!self::$_route ){
			self::_InitRouteTable();
		}
		return self::$_route;
	}

	/** Set custom route table.
	 *
	 * @param array $route
	 */
	static function Set($route)
	{
		self::$_route = $route;
	}
}
