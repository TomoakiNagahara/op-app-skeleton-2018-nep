<?php
/**
 * unit-database:/ErrorInfo.class.php
 *
 * @creation  2018-05-08
 * @version   1.0
 * @package   unit-database
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @creation  2018-05-08
 */
namespace OP\UNIT\DATABASE;

/** Database
 *
 * @creation  2018-05-08
 * @version   1.0
 * @package   unit-database
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class ErrorInfo
{
	/** trait
	 *
	 */
	use \OP_CORE;


	/** Set PDO error information.
	 *
	 * @param array $errorinfo
	 * @param array $backtrace
	 */
	static function Set($errorinfo, $backtrace)
	{
		$state = $errorinfo[0];
		$errno = $errorinfo[1];
		$error = $errorinfo[2];
		\Notice::Set("[$state($errno)] $error", $backtrace);
	}
}
