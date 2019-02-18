<?php
/**
 * unit-test:/index.php
 *
 * @creation  2018-04-12
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
if(!Env::isAdmin() ){
	return;
}

//	Include local functions.
include('index.inc.php');
include('Nav.class.php');

//	Set "testcase" meta URL.
RootPath('testcase', ConvertPath('app:/_testcase'));

//	...
App::WebPack('testcase:/index.css');
App::WebPack('testcase:/nav-right.css');
App::WebPack('testcase:/breadcrumb.css');

//	...
$args = App::Args();

//	...
if( file_exists( $file = join('/', $args).'.php') ){
	//	...
}else if( file_exists( $file = join('/', $args).'/action.php' ) ){
	//	...
}else{
	//	...
	array_pop($args);

	//	...
	if( file_exists( $file = join('/', $args).'/action.php' ) ){
		//	...
	}else{
		$file = null;
	}
}

//	...
App::Title('TEST CASE | '.join(' - ', $args));

//	...
App::Template('index.phtml',['file'=>$file]);
