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
		self::$_TEMPLATE_::Run($path, $args);
	}

	/** Layout
	 *
	 * @param	 string	 $name
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
			//	D($type);
		}

		//	...
		return self::$_LAYOUT_::Name();
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
		$path = ConvertPath($path);

		//	...
		list($path, $ext) = explode('.', $path);

		//	...
		\OP\UNIT\WebPack::Set($ext, $path);
	}

	/** Get/Set title.
	 *
	 * @param	 string	 $title
	 * @param	 string	 $separator
	 * @return	 string	 $title
	 */
	static function Title($title=null, $separator=' | ')
	{
		static $_title;
		if( $title ){
			$_title = $title . $separator . $_title;
		}
		return $_title;
	}
}
