<?php
/**
 * unit-test:/unit/oauth/google.php
 *
 * @creation  2018-07-03
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
/* @var $oauth \OP\UNIT\OAuth */
if(!$oauth = Unit::Instance('OAuth') ){
	return;
}

//	...
if( $_GET['logout'] ?? false ){
	$user_info = $oauth->Google()->Logout();
}else{
	$user_info = $oauth->Google()->isLogin() ? $oauth->Google()->UserInfo(): $oauth->Google()->Login();
}

//	...
D($user_info);
