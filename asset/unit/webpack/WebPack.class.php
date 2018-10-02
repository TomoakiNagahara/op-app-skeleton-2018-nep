<?php
/**
 * unit-webpack:/WebPack.class.php
 *
 * @creation  2018-04-12
 * @version   1.0
 * @package   unit-webpack
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2018-04-13
 */
namespace OP\UNIT;

/** WebPack
 *
 * @creation  2018-04-12
 * @version   1.0
 * @package   unit-webpack
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class WebPack
{
	/** trait
	 *
	 */
	use \OP_CORE, \OP_SESSION;

	/** Set js file path.
	 *
	 * @param string $path
	 */
	static function Js($path)
	{
		self::Set('js', $path);
	}

	/** Set css file path.
	 *
	 * @param string $path
	 */
	static function Css($path)
	{
		self::Set('css', $path);
	}

	/** Set file path. Store to session.
	 *
	 * @param string       $extension
	 * @param string|array $file_path
	 * @param boolean      $prepend true is head, false is foot.
	 */
	static function Set($ext, $path, $prepend=false)
	{
		//	Check extension.
		if( empty($ext) ){
			Notice::Set("Has not been set extension.");
			return;
		}

		//	Get session by extension.
		$session = self::Session($ext);

		//	Convert to array list.
		if( is_string($path) ){
			$list[] = $path;
		}else if( is_array($path) ){
			$list = $path;
		}else{
			$list = [];
		}

		//	Add to head or foot.
		if( empty($list) ){
			//	...
		}else if( empty($session) ){
			$session = $list;
		}else if( $prepend ){
			$session = array_merge( $list, $session );
		}else{
			$session = array_merge( $session, $list );
		}

		//	Set session by extension.
		self::Session($ext, $session);
	}

	/** Get packed string each extension.
	 *
	 * @param  string $extension
	 * @return string $string
	 */
	static function Get($ext)
	{
		//	...
		if(!ob_start()){
			\Notice::Set("ob_start was failed.");
			return;
		}

		//	...
		self::Out($ext);

		//	...
		return ob_get_clean();
	}

	/** Output packed string each extension.
	 *
	 * @param string $extension
	 */
	static function Out($ext)
	{
		//	...
		foreach( self::Session($ext) as $file_path ){
			\App::Template($file_path.'.'.$ext);
			echo "\n";
		}

		//	Set empty array.
		self::Session($ext, []);
	}

	/** Generate unique hash key by stacked files.
	 *
	 * @param	 string		 $extension
	 * @return	 string		 $hash
	 */
	static function Hash($ext)
	{
		$temp = self::Session($ext);
		$temp = json_encode($temp);
		$temp = md5($temp);
		$temp = substr($temp, 0, 8);
		return $temp .'.'. \Env::Get('OP\UNIT\WebPack\Serial');
	}
}
