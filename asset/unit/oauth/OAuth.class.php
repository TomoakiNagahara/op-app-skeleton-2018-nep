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

	/**
	 *
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

	private function _Key()
	{
		return Hasha1( $this->_service .','. __FILE__ );
	}

	function __construct($service)
	{
		//	...
		$this->_service = $service;

		//	...
		$this->_user_info = $this->Session($this->_Key());
	}

	function isLogin()
	{
		return $this->isLoggedIn();
	}

	function isLoggedIn()
	{
		return $this->_user_info ? true: false;
	}

	function Login()
	{
		//	...
		if(!$service = \Unit::Instance($this->_service) ){
			return false;
		}

		//	...
		$scheme = 'http';
		$host = $_SERVER['HTTP_HOST'];
		list($uri, $query) = explode('?', $_SERVER['REQUEST_URI']);
		$url = "{$scheme}://{$host}{$uri}";

		//	...
		if( $this->_user_info = $service->OAuth($url) ){
			$this->Session($this->_Key(), $this->_user_info);
		}

		//	...
		return $this->_user_info;
	}

	function UserInfo()
	{
		return $this->_user_info;
	}
}
