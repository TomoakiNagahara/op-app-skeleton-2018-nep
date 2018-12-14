<?php
/**
 * unit-app:/App.class.php
 *
 * @creation  2018-04-04
 * @version   1.0
 * @package   unit-app
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** App
 *
 * @creation  2018-04-04
 * @version   1.0
 * @package   unit-app
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class App
{
	/** trait.
	 *
	 */
	use OP_CORE, OP_SESSION;

	//	...
	static private $_DISPATCH_	 = 'OP\UNIT\NEWWORLD\Dispatch';
	static private $_LAYOUT_	 = 'OP\UNIT\NEWWORLD\Layout';
	static private $_ROUTER_	 = 'OP\UNIT\NEWWORLD\Router';
	static private $_TEMPLATE_	 = 'OP\UNIT\NEWWORLD\Template';

	/** Automatically run.
	 *
	 */
	static function Auto()
	{
		//	End-point file path.
		$endpoint = null;

		//	Each http status code
		switch( $status = $_SERVER['REDIRECT_STATUS'] ){
			//	Error status.
			case '403':
		//	case '404':
				//	Overwrite end-point file path.
				$endpoint = ConvertPath("app:/{$status}.php");
				break;
		}

		//	Execute end-point.
		$content = OP\UNIT\NEWWORLD\Dispatch::Get($endpoint);

		//	For developers.
		if( Env::isLocalhost() ){
			$etag  = $_GET['etag'] ?? true;
			$cache = false;
		}

		//	Get mime
		list($type, $ext) = explode('/', strtolower(Env::Mime() ?? '/') );

		//	...
		if( $type === 'text' ){
			//	...
			switch( $ext  ){
				case 'plain':
				case 'css':
				case 'json':
				case 'jsonp':
				case 'javascript':
					$etag  = $etag  ?? true; // Add Etag to URL Query for JS and CSS.
					$cache = $cache ?? true;
					break;

				default:
					//	Set mime.
					Env::Mime('text/html');

					//	Etag flag.
					if( $etag = $etag ?? true ){
						//	Check if Notice occurring.
						if( Notice::Has() ){
							//	Finger print is microtime.
							$fp = microtime();
						}else{
							//	Get unique hash key.
							Unit::Load('webpack');
							$hash_js  = \OP\UNIT\WebPack::Hash('js');
							$hash_css = \OP\UNIT\WebPack::Hash('css');

							//	Finger print is unique hash key.
							$fp = "$hash_js, $hash_css";
						}

						//	Add finger print for reload.
						$content .= "<!-- $fp -->";
					}
				break;
			}
		}else{
			//	image
			$etag  = true;
			$cache = true;
		}

		//	Generate 304 Not Modified hash key by content.
		if( $etag ){
			$etag = Hasha1($content);
		}

		//	Cache control.
		if( $etag || ($cache ?? false) ){
			//	Overwrite at empty.
			header('Pragma: ', true);

			//	Cache control.
			$age    = 60*60*1;
			header("Cache-Control: max-age={$age}", true);

			/** This section is for http 1.0.
			 *
			 *  If not set "Cache-Control" header then search "Expires".
			 *  If exists "Expires" header then subtraction from "Date" header. (Will to max-age)
			 *  If has not been set both header then search "Last-modified" header. (Do automatic calculate)
			 */
			$date   = time();
			$time   = $date + $age;
			$date   = gmdate('D, j M Y H:i:s ', $date) . 'GMT';
			$expire = gmdate('D, j M Y H:i:s ', $time) . 'GMT';
			header("Date: {$date}", true);
			header("Expires: {$expire}", true);
		}

		//	Submit Etag header.
		if( $etag ){
			/*
			//	...
			$last_modified = filemtime( __FILE__ );
			$last_modified = gmdate( "D, d M Y H:i:s T", $last_modified);

			//	...
			header("Last-Modified: {$last_modified}", true);
			*/
			header("Etag: {$etag}", true);
		}

		//	Check 304 Not Modified.
		if( $etag === filter_input( INPUT_SERVER, 'HTTP_IF_NONE_MATCH' ) ){
			header('HTTP/1.1 304 Not Modified');
			return;
		}

		//	The content is wrapped in the Layout.
		echo self::$_LAYOUT_::Get($content);
	}

	/** Get SmartURL arguments.
	 *
	 * @return	 array	 $args
	 */
	static function Args()
	{
		return self::$_ROUTER_::Get()['args'];
	}

	/** Get end-point directory name.
	 *
	 * @return	 string	 $endpoint
	 */
	static function EndPoint()
	{
		return self::$_ROUTER_::Get()['end-point'];
	}

	/** Template
	 *
	 * @param	 string	 $path
	 * @param	 string	 $args
	 */
	static function Template($path, $args=null)
	{
		//	...
		if( $args and !is_array($args)){
			$type = is_object($args) ? get_class($args) : gettype($args);
			D("Argument is not array. ($type)");
			return;
		}

		//	...
		if( $path ){
			self::$_TEMPLATE_::Run($path, $args);
		}
	}

	/** Layout
	 *
	 * <pre>
	 * App::Layout(true);       // Execute layout.
	 * App::Layout(false);      // Does not execute layout.
	 * App::Layout('name');     // Set layout name.
	 * $layout = App::Layout(); // Get layout name.
	 * </pre>
	 *
	 * @param	 null|boolean|string	 $value
	 */
	static function Layout($name=null)
	{
		//	...
		switch( $type = gettype($name) ){
			case 'NULL':
				break;

			case 'boolean':
				//	...
				self::$_LAYOUT_::Execute($name);

				//	...
				if(!$name ){
					self::$_LAYOUT_::Name('');
				}
				break;

			case 'string':
				//	...
				self::$_LAYOUT_::Name($name);
				break;

			default:
				Notice::Set("Has not been support this type. ($type)");
		}

		//	...
		return self::$_LAYOUT_::Execute() ? self::$_LAYOUT_::Name() : false;
	}

	/** WebPack
	 *
	 * @param	 string	 $path
	 */
	static function WebPack($path)
	{
		//	...
		if(!class_exists('OP\UNIT\WebPack') ){
			if(!Unit::Load('webpack') ){
				return;
			}
		}

		//	...
		list($path, $ext) = explode('.', $path);

		//	...
		$path = ConvertPath($path);

		//	...
		OP\UNIT\WebPack::Set($ext, $path);
	}

	/** Get to transparently GET or POST.
	 *
	 * @return array $request
	 */
	static function Request()
	{
		//	...
		$method = $_SERVER['REQUEST_METHOD'];

		//	...
		switch( $method ){
			case 'GET':
				$request = $_GET;
				break;

			case 'POST':
				$request = $_POST;
				break;
		}

		//	...
		return Escape( $request ?? [] );
	}

	/** Get/Set title.
	 *
	 * @param	 string	 $title
	 * @param	 string	 $separator
	 * @return	 string	 $title
	 */
	static function Title($title=null)
	{
		static $_titles, $separator=' | ';
		if( $title ){
			$_titles[] = $title;
		}
		return join($separator, array_reverse($_titles));
	}

	/** Get/Set breadcrumbs arguments.
	 *
	 * @param  array $list
	 * @return array $lists
	 */
	static function Breadcrumbs($list=null)
	{
		static $_list = [];
		if( $list ){
			$_list[] = $list;
		}else{
			return $_list;
		}
	}
}
