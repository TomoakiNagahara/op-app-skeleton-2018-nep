<?php
/**
 * unit-curl:/Curl.class.php
 *
 * @creation  2017-06-01
 * @version   1.0
 * @package   app-skeleton
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @creation  2018-07-02
 */
namespace OP\UNIT;

/** Curl
 *
 * @creation  2017-06-01
 * @version   1.0
 * @package   app-skeleton
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Curl
{
	/** trait.
	 *
	 */
	use \OP_CORE;

	/** Convert to string from array at post data.
	 *
	 * @param  array  $post
	 * @param  string $format
	 * @return string $data
	 */
	static private function _Data($post, $format=null)
	{
		switch( $format ){
			case 'json':
				$data = json_encode($post);
				break;

			default:
				//	Content-Type: application/x-www-form-urlencoded
				$temp = [];
				foreach( $post as $key => $val ){
					$temp[$key] = self::_Escape($val);
				}
				$data = http_build_query($temp, null, '&');
		}

		//	...
		return $data;
	}

	/** Escape of string.
	 *
	 * @param  string $string
	 * @return string $string
	 */
	static private function _Escape($string)
	{
		$string = preg_replace('/&/' , '%26', $string);
		$string = preg_replace('/ /' , '%20', $string);
		$string = preg_replace('/\t/', '%09', $string);
		$string = preg_replace('/\s/', '%20', $string);
		return $string;
	}

	/** Execute to Curl.
	 *
	 * @param  string $url
	 * @param  array  $post
	 * @return string $body
	 */
	static private function _Execute($url, $post=null, $format=null)
	{
		//	...
		$option = [
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT        => 3,
		];

		//	...
		$ch = curl_init($url);
		curl_setopt_array($ch, $option);

		//	...
		if( $post ){
			curl_setopt( $ch, CURLOPT_CUSTOMREQUEST , 'POST' );
			curl_setopt( $ch, CURLOPT_POST          ,  true );
			curl_setopt( $ch, CURLOPT_POSTFIELDS    ,  self::_Data($post, $format) );
		}

		//	...
		$body  = curl_exec($ch);
		$info  = curl_getinfo($ch);
		$errno = curl_errno($ch);

		//	...
		switch( $errno ){
			case CURLE_OK:
				break;
			default:
		}

		//	...
		switch( $info['http_code'] ){
			case 200:
				break;
			default:
		}

		//	...
		return $body;
	}

	/** Get method.
	 *
	 * @param  string $url
	 * @param  array  $data
	 * @return string $body
	 */
	static function Get($url, $data=null)
	{
		if( $data ){
			$url .= '?'.http_build_query($data);
		}

		//	...
		return self::_Execute($url);
	}

	/** Post method.
	 *
	 * @param  string $url
	 * @param  array  $post
	 * @return string $body
	 */
	static function Post($url, $post=null)
	{
		return self::_Execute($url, $post);
	}
}
