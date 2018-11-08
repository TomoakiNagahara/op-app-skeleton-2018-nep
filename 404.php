<?php
/**
 * app-skeleton-2018-nep:/404.php
 *
 * @creation  2018-10-30
 * @version   1.0
 * @package   app-skeleton
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
if( Time::Format('n') === '10' ){
	$path = '404-Halloween.phtml';
}else{
	$path = '404_not_found.phtml';
}

//	...
App::Template($path);
