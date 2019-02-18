<?php
/**
 * unit-admin:/index.php
 *
 * @creation  2019-01-30
 * @version   1.0
 * @package   unit-admin
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	Get saved cookie value.
$count = (int)Cookie::Get(__FILE__);

//	Are you admin?
if(!Env::isAdmin() ){
	//	Did you login in the past?
	if( $count ){
		//	Is login by cookie allowed?
		if( Env::Get('admin')['cookie'] ){
			//	Overwrite Admin IP-Address.
			Env::Set(Env::_ADMIN_IP_, $_SERVER['REMOTE_ADDR']);
		}else{
			//	Message.
			Html("Cookie was false.");
		};
	}else{
		//	Message.
		Html("Your IP-Address is {$_SERVER['REMOTE_ADDR']}.");

		//	Display 404 page.
		App::Template( ConvertPath('app:/404.php') );
		return;
	};
};

//	...
$doc  = $_SERVER['DOCUMENT_ROOT'];
$app  = ConvertURL('app:/');
$len  = strlen($app);
$uri  = $_SERVER['REQUEST_URI'];
$path = substr($uri, $len);
$pos  = strpos($path, '/');
$dir  = substr($path, 0, $pos);
RootPath('admin', $doc.$app.$dir);

//	Adding it makes tracking difficult.
Cookie::Set(__FILE__, $count+1, 60*60*24*7);

//	...
$args = App::Args();

//	...
$action = __DIR__.'/'.join('/',$args).'/action.php';

//	...
if( file_exists($action) ){
	App::Template($action);
}else{
	App::Template('index.phtml');
};
