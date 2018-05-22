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
	 * @return string
	 */
	static function Get()
	{
		//	Execute app's end point. (app's controller)
		$route = Router::Get();

		//	Get current directory.
		$cdir = getcwd();

		//	Change current directory.
		chdir(dirname($route[Router::_END_POINT_]));

		//	Execute content.
		try{
			//	Execute end-point.
			$content = Template::Get($route[Router::_END_POINT_]);
		}catch( Exception $e ){
			\Notice::Set($e);
		}

		//	Recovery current directory.
		chdir($cdir);

		//	...
		return $content;
	}
}
