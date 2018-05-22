<?php
use OP\UNIT\NEWWORLD\Template;

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
include('common.php');

//	...
include('menu.phtml');

//	...
$args = App::Args();

//	...
if( file_exists( $file = join('/', $args).'.php') ){
	//	...
}else if( file_exists( $file = join('/', $args).'/action.php' ) ){
	//	...
}else{
	$file = 'index.phtml';
}

//	...
App::Template($file);
