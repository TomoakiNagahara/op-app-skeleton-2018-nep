<?php
/**
 * unit-api:/Api.class.php
 *
 * @creation  2018-10-25
 * @version   1.0
 * @package   unit-api
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @creation  2018-10-25
 */
namespace OP\UNIT;

/** Api
 *
 * @creation  2018-10-25
 * @version   1.0
 * @package   unit-api
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Api
{
	/** trait.
	 *
	 */
	use \OP_CORE;

	/** Result
	 *
	 * @var array
	 */
	static private $_result;

	/** Whether to output in HTML.
	 *
	 * @var boolean
	 */
	static private $_html;

	/** Do initialization.
	 *
	 * @throws \Exception
	 */
	static function Init()
	{
		//	Initialize the result.
		self::$_result = [
			'status' => true,
			'errors' => [],
			'result' => [],
		];

		//	Whether to output in HTML.
		self::$_html = empty($_GET['html']) ? false: true;

		//	Does not output in HTML.
		if( self::$_html === false ){
			//	Catch leak output.
			if(!ob_start() ){
				throw new \Exception('ob_start was failed.');
			}
		}

		//	If localhost, will automatically wait one second.
		if( \Env::isLocalhost() ){
			if( $sleep = $_GET['sleep'] ?? 1 ){
				self::$_result['sleep'] = $sleep;
				sleep($sleep);
			}
		}
	}

	/** Stack the errors.
	 *
	 * @param string $error
	 */
	static function Error(string $error)
	{
		//	...
		if(!isset(self::$_result['errors']) ){
			self::$_result['errors'] = [];
		}

		//	...
		self::$_result['errors'][] = $error;
	}

	/** Set multiple values.
	 *
	 * @param array $result
	 */
	static function Result($result)
	{
		self::$_result['result'] = $result;
	}

	/** Set the result value of the key.
	 *
	 * @param string $key
	 * @param mixed  $val
	 */
	static function Set(string $key, $val)
	{
		self::$_result['result'][$key] = $val;
	}

	/** Get the result value of the key.
	 *
	 * @param  string $key
	 * @return mixed
	 */
	static function Get($key)
	{
		return self::$_result[$key];
	}

	static function Dump($label, $value)
	{
		//	Only just admin.
		if(!\Env::isAdmin() ){
			return;
		}

		//	Set dump info.
		self::$_result['dump'][] = [$label, $value];
	}

	/** Output JSON string to stdout. (Default is JSON)
	 *
	 */
	static function Finish()
	{
		//	...
		if( self::$_html === false ){
			//	Only for admin.
			if( \Env::isAdmin() ){
				//	Get leaked content.
				if( $leak = ob_get_clean() ){
					self::$_result['__LEAKED__'] = $leak;
				}

				//	Get Notice message.
				if( \Notice::Has() ){
					self::$_result['notice'][] = \Notice::Get();
				}
			}else{
				//	Throw away.
				ob_end_clean();
			}
		}

		//	...
		if( $_GET['html'] ?? null ){
			//	...
			D(self::$_result);
		}else{
			//	...
			\App::Layout(false);

			//	...
			\Env::Mime('text/json');

			//	...
			echo json_encode(self::$_result);
		};
	}
}
