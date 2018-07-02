<?php
/**
 * unit-google:/Google.class.php
 *
 * @creation  2018-07-02
 * @version   1.0
 * @package   unit-google
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @creation  2018-07-02
 */
namespace OP\UNIT;

/** Google
 *
 * @creation  2018-07-02
 * @version   1.0
 * @package   unit-google
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Google
{
	/** trait
	 *
	 */
	use \OP_CORE;

	private $_google_oauth_user_info;

	/** Execute Google OAuth.
	 *
	 * @param	 string	 $callback_url
	 */
	function OAuth($callback_url)
	{
		//	...
		if(!$this->_google_oauth_user_info ){
			//	...
			include_once('OAuth.class.php');

			//	...
			$this->_google_oauth_user_info = GOOGLE\OAuth::Auto($callback_url);
		}

		//	...
		return $this->_google_oauth_user_info;
	}
}
