<?php
/**
 * app-skeleton-2018-nep:/app.php
 *
 * @creation  2018-03-27
 * @version   1.0
 * @package   app-skeleton
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
try {
	//	Bootstrap - Initialize onepiece-framework application.
	require(__DIR__.'/bootstrap.php');

	//	Set unit directory.
	Unit::Directory(__DIR__.'/unit');

	//	Load of the Unit of App.
	Unit::Load('app');

	//	Load of the NewWorld.
	Unit::Load('newworld');

	//	Closure
	(function(){

	//	Include configuration file.
	include(__DIR__.'/config.php');

	//	Include private configuration file.
	if( file_exists(__DIR__.'/_config.php') ){
		include(__DIR__.'/_config.php');
	}

	})();

	//	Launch application.
	App::Auto();

} catch ( Throwable $e ){
	Notice::Set($e);
	require(__DIR__.'/bootstrap/op/failed.phtml');
}
