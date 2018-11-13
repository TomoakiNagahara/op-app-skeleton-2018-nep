<?php
/**
 * unit-newworld:/Dispatcher.class.php
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

/** Dispatcher
 *
 * @creation  2017-02-15
 * @version   1.0
 * @package   unit-newworld
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Dispatch
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** Execute end-point and get end-point result.
	 *
	 * @param  string $endpoint
	 * @return string
	 */
	static function Get($endpoint=null)
	{
		//	Endpoint is not specified.
		if(!$endpoint ){
			//	Get default end-point.
			$endpoint = Router::Get()[Router::_END_POINT_];
		}

		//	Get current directory.
		$cdir = getcwd();

		//	Change current directory.
		chdir(dirname($endpoint));

		//	Execute content.
		try{
			//	Execute end-point.
			$content = Template::Get($endpoint);
		}catch( Exception $e ){
			\Notice::Set($e);
		}

		//	Recovery current directory.
		chdir($cdir);

		//	...
		return $content;
	}
}
