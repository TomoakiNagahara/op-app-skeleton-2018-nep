<?php
/**
 * unit-gdpr:/index.php
 *
 * @creation  2018-11-15
 * @version   1.0
 * @package   unit-gdpr
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	Generate hash key.
$key = Hasha1(__DIR__);

//	Confirm confirmation.
if( Cookie::Get($key) ){
	return false;
}

//	Confirmation.
if( $_GET[$key] ?? null ){
	Cookie::Set($key, 1);
}

//	Load GDPR
include(__DIR__.'/GDPR.class.php');

//	GDPR is not yet confirmation.
return true;
