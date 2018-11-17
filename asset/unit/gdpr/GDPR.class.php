<?php
/**
 * unit-gdpr:/GDPR.class.php
 *
 * @creation  2018-11-15
 * @version   1.0
 * @package   unit-gdpr
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
/** namespace
 *
 * @creation  2018-11-15
 */
namespace OP\UNIT;

/** GDPR
 *
 * @creation  2018-11-15
 * @version   1.0
 * @package   unit-gdpr
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class GDPR
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** Get confirm confirmation.
	 *
	 */
	static function Confirmation()
	{
		return \Cookie::Get( Hasha1(__DIR__) ) ? true: false;
	}

	/** Get default description html.
	 *
	 * @param  string  $locale
	 */
	static function Html($locale='en-us')
	{
		//	...
		$dir = __DIR__.'/';

		//	...
		$file = "index.{$locale}.phtml";

		//	...
		if(!file_exists($dir.$file) ){
			//	...
			\Notice::Set("Has not been support this locale. ($locale)");

			//	...
			$file = "index.en-us.phtml";
		}

		//	...
		include($dir.$file);

		//	...
		\OP\UNIT\WebPack::Js( $dir.'gdpr');
		\OP\UNIT\WebPack::Css($dir.'gdpr');
	}
}
