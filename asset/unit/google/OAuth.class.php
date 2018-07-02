<?php
/**
 * OAuth.class.php
 *
 * @creation  2017-10-30
 * @version   1.0
 * @package   unit-google
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @creation  2018-07-02
 */
namespace OP\UNIT\GOOGLE;

/** OAuth
 *
 * @creation  2017-10-30
 * @version   1.0
 * @package   unit-google
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class OAuth
{
	/** Trait
	 *
	 */
	use \OP_CORE;

	/** Get Google OAuth client ID.
	 *
	 * @throws \Exception
	 * @return  string
	 */
	static private function _ClientID()
	{
		if(!$val = \Env::Get('google-oauth-client-id') ){
			throw new \Exception('Has not been set google-oauth-client-id. Please set to Env::Set("google-oauth-client-id", $id)');
		}
		return $val;
	}

	/** Get Google OAuth client secret.
	 *
	 * @throws \Exception
	 * @return  string
	 */
	static private function _ClientSecret()
	{
		if(!$val = \Env::Get('google-oauth-client-secret') ){
			throw new \Exception('Has not been set google-oauth-client-secret. Please set to Env::Set("google-oauth-client-secret", $secret)');
		}
		return $val;
	}

	/** Automatically do all process.
	 *
	 * @param  string $callback_url
	 * @return array  $userinfo
	 */
	static function Auto($callback_url)
	{
		//	Get code
		if(!$code = $_GET['code'] ?? null ){
			//	Do authorization.
			self::Auth($callback_url);
		}

		//	Get user information.
		return self::Callback($code, $callback_url);
	}

	/** Transfer to user authentication page.
	 *
	 * @param string $redirect_uri
	 */
	static function Auth($redirect_uri, $scope=null)
	{
		//	...
		$params = array(
			'scope'			 => 'https://www.googleapis.com/auth/' . ($scope ?? 'userinfo.email'),
			'client_id'		 => self::_ClientID(),
			'redirect_uri'	 => $redirect_uri,
			'response_type'	 => 'code',
		);

		//	...
		$query = http_build_query($params);

		//	...
		$url = "https://accounts.google.com/o/oauth2/auth?$query";

		//	...
		if( headers_sent($file, $line) ){
			throw new \Exception("Header has already been sent. ($file, $line)");
		}

		//	...
		Header("Location: $url");
	}

	/** Callback from authentication page.
	 *
	 * @param  string  $redirect_uri
	 * @return boolean $io
	 */
	static function Callback($code, $redirect_uri)
	{
		//	...
		if(!\Unit::Load('curl')){
			return;
		}

		//	...
		$post = array(
			'code'			 => $code,
			'grant_type'	 => 'authorization_code',
			'redirect_uri'	 => $redirect_uri,
			'client_id'		 => self::_ClientID(),
			'client_secret'	 => self::_ClientSecret(),
		);

		//	...
		$json = \OP\UNIT\Curl::Post('https://accounts.google.com/o/oauth2/token', $post);
		$json = json_decode($json, true);

		//	...
		if( $json['error'] ?? null ){
			$error		 = $json['error'];
			$description = $json['error_description'];
			throw new \Exception("$description ($error)");
		}

		//	...
		if(!$token = $json['access_token'] ?? null ){
			throw new \Exception("Token has not been return from google.");
		}

		//	...
		$url  = "https://www.googleapis.com/oauth2/v1/userinfo?access_token={$token}";
		$json = \OP\UNIT\Curl::Get($url);
		$json = json_decode($json, true);

		//	...
		if( $json['error'] ?? null ){
			$error		 = $json['error'];
			$description = $json['error_description'];
			throw new \Exception("$description ($error)");
		}

		//	...
		return $json;
	}
}
