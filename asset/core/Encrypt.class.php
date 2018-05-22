<?php
/**
 * Encrypt.class.php
 *
 * @creation  2017-11-22
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** Encrypt
 *
 * @creation  2017-11-22
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Encrypt
{
	/** trait.
	 *
	 */
	use OP_CORE;

	/** Generate Initial vector.
	 *
	 */
	static function _iv()
	{
		return substr(Env::Get(_OP_APP_ID_) . ifset($_SERVER["_APP_OPENSSL_IV_"]) . '1234567890123456', 0, 16);
	}

	/** Generate password.
	 *
	 */
	static function _password()
	{
		return Env::Get(_OP_APP_ID_) . ifset($_SERVER["_APP_OPENSSL_PASSWORD_"]) . '1234567890123456';
	}

	/** Dec is Decoding.
	 *
	 * @param string $str
	 * @param string $str
	 */
	static function Dec($str)
	{
		//	...
		$iv       = self::_iv();
		$password = self::_password();
		$method   = 'aes-256-cbc';
		$option   = 0;

		//	...
		return openssl_decrypt($str, $method, $password, $option, $iv);
	}

	/** Enc is Encoding.
	 *
	 * @param string $str
	 * @param string $str
	 */
	static function Enc($str)
	{
		//	...
		$iv       = self::_iv();
		$password = self::_password();
		$method   = 'aes-256-cbc';
		$option   = 0;

		//	...
		return openssl_encrypt($str, $method, $password, $option, $iv);
	}
}
