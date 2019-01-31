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
//	...
if(!Env::isAdmin() ){
	App::Template( ConvertPath('app:/404.php') );
	return;
};

//	...
_GetRootsPath('admin', __DIR__);

//	...
$args = App::Args();

//	...
$action = __DIR__.'/'.join('/',$args).'/action.php';

//	...
if( file_exists($action) ){
	App::Template($action);
}else{
	D($args, CompressPath($action) );
};
