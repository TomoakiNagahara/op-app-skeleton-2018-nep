<?php
/**
 * unit-oauth:/OAuth.class.php
 *
 * @creation  2018-07-03
 * @version   1.0
 * @package   unit-oauth
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @creation  2018-07-03
 */
namespace OP\UNIT;

/** OAuth
 *
 * @creation  2018-07-03
 * @version   1.0
 * @package   unit-oauth
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class OAuth
{
	/** trait
	 *
	 */
	use \OP_CORE;

	/** Google OAuth
	 *
	 * @var \OP\UNIT\GOOGLE\OAuth
	 */
	private $_instances;

	/** OAuth of Google.
	 *
	 * @return \OP\UNIT\OAuthChild
	 */
	function Google()
	{
		//	...
		if(!$this->_instances[__FUNCTION__] ?? null ){
			$this->_instances[__FUNCTION__] = new OAuthChild(__FUNCTION__);
		}

		//	...
		return $this->_instances[__FUNCTION__];
	}
}

/** OAuthChild
 *
 * @creation  2018-07-03
 * @version   1.0
 * @package   unit-oauth
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class OAuthChild
{
	/** trait
	 *
	 */
	use \OP_CORE, \OP_SESSION;

	/** Service
	 *
	 */
	private $_service;

	/** User information.
	 *
	 * @var array
	 */
	private $_user_info;

	/** Generate unique key.
	 *
	 */
	private function _Key()
	{
		return Hasha1( $this->_service .','. __FILE__ );
	}

	/** Generate callback url.
	 *
	 */
	private function _CallbackURL()
	{
		//	...
		$scheme = 'http';

		//	...
		$host = $_SERVER['HTTP_HOST'];

		//	...
		$uri = $_SERVER['REQUEST_URI'];

		//	...
	//	list($uri, $query) = explode('?', $uri);

		//	...
		return "{$scheme}://{$host}{$uri}";
	}

	/** Construct
	 *
	 * @param string $service
	 */
	function __construct($service)
	{
		//	...
		$this->_service = $service;

		//	...
		$this->_user_info = $this->Session($this->_Key());
	}

	/** Wrapper method.
	 *
	 * @return boolean
	 */
	function isLogin()
	{
		return $this->isLoggedIn();
	}

	/** Wrapper method.
	 *
	 * @return boolean
	 */
	function isLoggedIn()
	{
		return $this->_user_info ? true: false;
	}

	/** Do login.
	 *
	 * @return boolean
	 */
	function Login()
	{
		//	...
		if(!$service = \Unit::Instance($this->_service) ){
			return false;
		}

		//	...
		$url = $this->_CallbackURL();

		//	...
		return $this->UserInfo( $service->OAuth($url) );
	}

	/** Do logout.
	 *
	 */
	function Logout()
	{
		//	...
		$key = $this->_Key();

		//	...
		$this->Session($key, null);
	}

	/** Get user information.
	 *
	 * @param  array  $user_info
	 * @return array  $user_info
	 */
	function UserInfo($user_info=null)
	{
		//	...
		$key = $this->_Key();

		//	...
		if( $user_info ){
			if( $this->_user_info ){
				D("Already has been set user info.");
			}else{
				//	...
				$this->_user_info = $user_info;

				//	...
				$this->Session($key, $user_info);
			}
		}

		//	...
		return $this->_user_info ?? [];
	}
}
