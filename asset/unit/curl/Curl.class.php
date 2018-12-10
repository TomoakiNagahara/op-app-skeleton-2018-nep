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
					$temp[$key] = self::Escape($val);
				}
				$data = http_build_query($temp, null, '&');
		}

		//	...
		return $data;
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
		$header = [];

		//	...
		$ua = null;

		//	...
		$scheme = 'http';
		$host   = $_SERVER['HTTP_HOST']   ?? 'localhost';
		$uri    = $_SERVER['REQUEST_URI'];
	//	list($uri, $query) = explode('?', $uri.'?');
		$referer = "{$scheme}://{$host}{$uri}";

		//	...
		$option = [
			CURLOPT_URL            =>  $url,
			CURLOPT_HTTPHEADER     =>  $header,
			CURLOPT_USERAGENT      =>  $ua,
			CURLOPT_REFERER        =>  $referer,
			CURLOPT_RETURNTRANSFER =>  true,
			CURLOPT_TIMEOUT        =>  3,
		];

		//	...
		$curl = curl_init();
		curl_setopt_array($curl, $option);

		//	...
		if( $post ){
			curl_setopt( $curl, CURLOPT_CUSTOMREQUEST , 'POST' );
			curl_setopt( $curl, CURLOPT_POST          ,  true  );
			curl_setopt( $curl, CURLOPT_POSTFIELDS    ,  self::_Data($post, $format) );
		}

		//	...
		$body  = curl_exec($curl);
		$info  = curl_getinfo($curl);
		$errno = curl_errno($curl);

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

	/** Escape of string.
	 *
	 * @param  string $string
	 * @return string $string
	 */
	static function Escape($string)
	{
		$string = preg_replace('/&/' , '%26', $string);
		$string = preg_replace('/ /' , '%20', $string);
		$string = preg_replace('/\t/', '%09', $string);
		$string = preg_replace('/\s/', '%20', $string);
		return $string;
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
