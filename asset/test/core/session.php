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
if( $_GET['notice'] ?? false ){
	Notice::Set("TEST");
}

//	...
if( $_GET['clear'] ?? false ){
	$_SESSION = [];
}

//	...
printf('<a href="?clear=1">Clear session</a>');

//	...
D($_SESSION);
