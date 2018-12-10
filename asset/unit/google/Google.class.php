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
	 * @param	 string|null $apikey
	 * @return	 array	 $strings
	 */
	function Translate(string $to, string $from, array $strings, $apikey=null)
	{
		//	...
		include_once('Translate.class.php');

		//	...
		$config = [];
		$config['target']  = $to;
		$config['source']  = $from;
		$config['strings'] = $strings;
		$config['apikey']  = $apikey;

		//	...
		return GOOGLE\Translate::Translation($config);
	}

	/** Get language list for translate.
	 *
	 * @param	 string	 $lang
	 * @return	 array	 $strings
	 */
	function Languages($lang=null)
	{
		return GOOGLE\Translate::Language(['target'=>$lang]);
	}

	/** Debug is for developers.
	 *
	 */
	function Debug()
	{
		D(GOOGLE\Translate::Errors());
	}
}
