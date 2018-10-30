<?php
/**
 * unit-referencet:/index.php
 *
 * @creation  2018-10-30
 * @version   1.0
 * @package   unit-reference
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
$endpoint  = App::EndPoint();
$reference = basename(dirname($endpoint));

//	...
App::Breadcrumbs(['href'=>'app:/','text'=>'TOP']);

//	...
App::Breadcrumbs(['href'=>'app:/'.$reference,'text'=>'Reference']);

//	...
$args = [$reference];
foreach( App::Args() as $arg ){
	$args[] = $arg;
	$list['text'] = ucfirst($arg);
	$list['href'] = 'app:/'.join('/', $args);
	App::Breadcrumbs($list);
}

//	...
include('menu.phtml');

//	...
if( count($args) < 2 ){
	return;
}

//	...
$action = $args[1]."/action.php";

//	...
if( file_exists($action) ){
	include($action);
}
