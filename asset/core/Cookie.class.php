<?php
/**
 * Cookie.class.php
 *
 * @creation  2017-02-25
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** Cookie
 *
 * FEATURE:
 * 1. Even the same key name is separated by AppID.
 *    That is, Even in the same domain, the same key name can be used.
 *    Because AppleID is different. Value is do not conflict.
 *
 * 2. Value is encrypted.
 *    Cookie is stored user's browser. That is, User can change freely.
 *
 * @creation  2017-02-25
 * @version   1.0
 * @package   core
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Cookie
{
	/** trait.
	 *
	 */
	use OP_CORE;

	/** Debug information.
	 *
	 * @var array
	 */
	static $_debug;

	/** Initialize App ID.
	 *
	 */
	static private function _AppID()
	{
		static $app_id;

		if(!$app_id ){
			if(!$app_id = Env::Get(_OP_APP_ID_) ){
				$app_id = Hasha1(ConvertPath('app:/'));
			}
		}

		return $app_id;
	}

	/** Generate unique key by AppID and original key name.
	 *
	 * @param  string $key
	 * @return string $key
	 */
	static function _Key($key)
	{
		//	...
		$hash = Hasha1($key.', '.self::_AppID());

		//	...
		if( Env::isAdmin() ){
			self::$_debug['keys'][$key]['hash'] = $hash;
		};

		//	...
		return $hash;
	}

	/** Get cookie value of key.
	 *
	 * @param  string $key
	 * @param  mixed  $default
	 * @return mixed
	 */
	static function Get($key, $default=null)
	{
		//	...
		$key = self::_Key($key);

		//	...
		return isset($_COOKIE[$key]) ? unserialize( Encrypt::Dec($_COOKIE[$key]) ): $default;
	}

	/** Set cookie value.
	 *
	 * @param string $key
	 * @param mixed  $val
	 */
	static function Set($key, $val, $expire=null, $option=null)
	{
		//	For Eclipse (Undefined error)
		$file = $line = null;

		//	Failed.
		if( headers_sent($file, $line) ){
			Notice::Set("Header has already been sent. ($file, $line)");
			return;
		}

		//	...
		$key = self::_Key($key);

		//	...
		$time = Time::Get();

		//	...
		switch( $type = gettype($expire) ){
			case 'NULL':
				$expire = $time + (60*60*24*365*10);
				break;

			case 'string':
				$expire = strtotime($expire, $time);
				break;

			case 'integer':
				if( $expire <  $time ){
					$expire += $time;
				};
				break;

			default:
				Notice::Set("Has not been support this variable type. ($type)");
		};

		//	...
		$path = ifset( $option['path'], '/');

		//	...
		$domain = ifset( $option['domain'], $_SERVER['SERVER_NAME']);

		//	...
		$secure = false;

		//	...
		$httponly = false;

		//	...
		$val = serialize($val);

		//	...
		$val = Encrypt::Enc($val);

		//	...
		if( setcookie($key, $val, $expire, $path, $domain, $secure, $httponly) ){
			//	Successful.
			$_COOKIE[$key] = $val;
		}else{
			Notice::Set("Set cookie was failed.");
		}
	}

	/** Unique User ID.
	 *
	 * @return string
	 */
	static function UUID()
	{
		//	...
		if(!$uuid = self::Get('uuid') ){
			$uuid = Hasha1( $_SERVER['REMOTE_ADDR'] . microtime() );
			self::Set('uuid', $uuid);
		}
		return $uuid;
	}

	/** For developers.
	 *
	 * @param	 null	$config
	 */
	static function Debug($config=null)
	{
		//	...
		$info = [];

		//	...
		foreach( self::$_debug['keys'] as $key => $val ){
			//	...
			$hash = $val['hash'];
			$orig = Cookie::Get($key);

			//	...
			$temp = [];
			$temp['key']   = $key;
			$temp['hash']  = $hash;
			$temp['value'] = $orig;
			$info[] = $temp;
		};

		//	...
		D( $info );
	}
}
