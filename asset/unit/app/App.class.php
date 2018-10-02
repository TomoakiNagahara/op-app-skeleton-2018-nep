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
		//	Execute end-point.
		$content = self::$_DISPATCH_::Get();

		//	For developers.
		if( Env::isLocalhost() ){
			$etag  = $_GET['etag'] ?? true;
			$cache = false;
		}

		//	...
		switch( $mime = Env::Mime() ){
			case 'text/css':
			case 'text/javascript':
				$etag  = $etag  ?? true; // Add Etag to URL Query for JS and CSS.
				$cache = $cache ?? true;
				break;

			default:
				//	Set mime.
				Env::Mime('text/html');

				//	Etag flag.
				$etag = $etag ?? true;

				//	Get unique hash key.
				$hash_js  = \OP\UNIT\WebPack::Hash('js');
				$hash_css = \OP\UNIT\WebPack::Hash('css');

				//	Add unique hash key.
				$content .= "<!-- $hash_js, $hash_css -->\n";
			//	$content .= "$hash_js, $hash_css";
			break;
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
			/*
			$date   = time();
			$time   = $date + $age;
			$date   = gmdate('D, j M Y H:i:s ', $date) . 'GMT';
			$expire = gmdate('D, j M Y H:i:s ', $time) . 'GMT';
			header("Date: {$date}", true);
			header("Expires: {$expire}", true);
			*/
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

				//	...
				if( $name ){
					self::$_LAYOUT_::Execute(true);
				}
				break;

			default:
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
}
