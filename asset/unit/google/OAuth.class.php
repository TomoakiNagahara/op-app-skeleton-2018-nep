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
	use OP_CORE, OP_SESSION;

	/** Automatically do all process.
	 *
	 * @param  string $callback_url
	 * @return array  $userinfo
	 */
	static function Auto($callback_url)
	{
		//	If already got.
		if( $userinfo = self::UserInfo() ){
			return $userinfo;
		}

		//	Get code
		if(!$code = ifset($_GET['code']) ){
			//	Do authorization.
			self::Auth($callback_url);
		}

		//	Get token.
		if(!self::Callback($code, $callback_url)){
			return false;
		}

		//	Get user info.
		return self::UserInfo();
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
			'client_id'		 => Env::Get('google-oauth-client-id'),
			'redirect_uri'	 => $redirect_uri,
			'response_type'	 => 'code',
		);

		//	...
		$query = http_build_query($params);

		//	...
		$url = "https://accounts.google.com/o/oauth2/auth?$query";

		//	...
		if( headers_sent($file, $line) ){
			Notice::Set("Header has already been sent. ($file, $line)");
		}else{
			Header("Location: $url");
		}
	}

	/** Callback from authentication page.
	 *
	 * @param  string  $redirect_uri
	 * @return boolean $io
	 */
	static function Callback($code, $redirect_uri)
	{
		//	...
		$post = array(
			'code'			 => $code,
			'grant_type'	 => 'authorization_code',
			'redirect_uri'	 => $redirect_uri,
			'client_id'		 => Env::Get('google-oauth-client-id'),
			'client_secret'	 => Env::Get('google-oauth-client-secret'),
		);

		//	...
		$json = Curl::Post('https://accounts.google.com/o/oauth2/token', $post);
		$json = json_decode($json, true);

		//	...
		if( ifset($json['error']) ){
			$error		 = ifset($json['error']);
			$description = ifset($json['error_description']);
			self::Error("$description ($error)");
			return false;
		}

		//	...
		if(!$token = ifset($json['access_token'])){
			return false;
		}

		//	...
		$url  = "https://www.googleapis.com/oauth2/v1/userinfo?access_token={$token}";
		$json = Curl::Get($url);
		$json = json_decode($json, true);

		//	...
		if( ifset($json['error']) ){
			$error		 = ifset($json['error']);
			$description = ifset($json['error_description']);
			self::Error("$description ($error)");
			return false;
		}

		//	...
		self::Session('userinfo', $json);

		//	...
		return true;
	}

	/**
	 *
	 * @param  string $error
	 * @return array  $errors
	 */
	static function Error($error=null)
	{
		static $_errors;
		if( $error ){
			$_errors[] = $error;
		}
		return $_errors;
	}

	/** Get user information.
	 *
	 * @return array
	 */
	static function UserInfo()
	{
		return self::Session('userinfo');
	}

	/** Logout
	 *
	 */
	static function Logout()
	{
		self::Session('userinfo', []);
	}
}
