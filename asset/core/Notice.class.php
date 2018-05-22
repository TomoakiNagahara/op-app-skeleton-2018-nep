<?php
/**
 * Notice.class.php
 *
 * @creation  2016-11-17
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/**
 * Notice
 *
 * @creation  2016-11-17
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Notice
{
	/** trait.
	 *
	 */
	use OP_CORE, OP_SESSION;

	/** Namespace
	 *
	 * @var string
	 */
	const _NAME_SPACE_ = 'STORE';

	/** Get notice array.
	 *
	 * @return array
	 */
	static function Get()
	{
		//	Get
		$session = self::Session(self::_NAME_SPACE_);

		//	Shift
		$notice  = array_shift($session);

		//	Set
		self::Session(self::_NAME_SPACE_, $session);

		//	Return
		return $notice;
	}

	/** Set notice array.
	 *
	 * @param string $message
	 */
	static function Set($e, $backtrace=null)
	{
		//	...
		if( $e instanceof Throwable ){
			$message   = $e->getMessage();
			$backtrace = $e->getTrace();
			$file      = $e->getFile();
			$line      = $e->getLine();
			array_unshift($backtrace, ['file'=>$file, 'line'=>$line]);
		}else{
			$message   = $e;
		}

		//	...
		$key		 = Hasha1($message);
		$timestamp	 = gmdate('Y-m-d H:i:s', time()+date('Z'));

		//	...
		$session	 = self::Session(self::_NAME_SPACE_);

		//	...
		$reference	 = isset($session[$key]) ? $session[$key]: null;

		//	...
		if( empty($reference) ){
			//	...
			$reference['count']		 = 1;
			$reference['created']	 = $timestamp;
			$reference['message']	 = $message;
			$reference['backtrace']	 = $backtrace ?? debug_backtrace(false);
		}else{
			$reference['count']		+= 1;
			$reference['updated']	 = $timestamp;
		}

		//	...
		$session[$key] = $reference;

		//	...
		self::Session(self::_NAME_SPACE_, $session);
	}

	/** Load notice unit.
	 *
	 */
	static function Shutdown()
	{
		Unit::Load('notice');
	}
}

/** Register shutdown function.
 *
 * Moved from Bootstrap.php
 * So far, This routine has always been called up.
 * Currently, This shutdown function is called only when there is the Notice.
 *
 * @creation  2016-11-17
 * @moved     2017-01-19
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
register_shutdown_function('Notice::Shutdown');
