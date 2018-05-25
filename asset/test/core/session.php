<?php
/**
 * unit-test:/core/session.php
 *
 * @creation  2018-04-18
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
App::Template('session.phtml');

//	...
switch( $action = $_GET['action'] ?? null ){
	case 'notice':
		Notice::Set(__FILE__);
		break;

	case 'app':
		break;

	case 'whole':
		$_SESSION = [];
		break;

	default:
}

//	...
if( empty($_SESSION['count']) ){
	$_SESSION['count'] = 0;
}

//	...
$count = App::Session('count');
App::Session('count', $count +1);

//	...
D($_SESSION);

//	...
$_SESSION['count']++;
