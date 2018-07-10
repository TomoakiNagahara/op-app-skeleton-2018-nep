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

	/** Execute Google Translate.
	 *
	 * @param	 string	 $to
	 * @param	 string	 $from
	 * @param	 array	 $strings
	 * @return	 array	 $strings
	 */
	function Translate($to, $from, $strings)
	{
		//	...
		if(!is_array($strings) ){
			\Notice::Set("Strings is not array.");
			return $strings;
		}

		//	...
		include_once('Translate.class.php');

		//	...
		$config['target']  = $to;
		$config['source']  = $from;
		$config['strings'] = $strings;

		//	...
		return GOOGLE\Translate::Translation($config);
	}


	function Debug()
	{
		D(GOOGLE\Translate::Errors());
	}
}
