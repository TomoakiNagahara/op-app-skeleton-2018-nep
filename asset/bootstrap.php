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
call_user_func(function(){
	try {
		//	Bootstrap the onepiece-framework's core.
		require(__DIR__.'/core/Bootstrap.php');

		//	Checking rewrite setting.
		if( 'app.php' !== basename($_SERVER['SCRIPT_FILENAME']) ){
			//	Has not been setting rewrite.
			include(__DIR__.'/bootstrap/op/rewrite.php');
		}

		//	Check mbstring installed.
		if(!function_exists('mb_language') ){
			include(__DIR__.'/bootstrap/php/mbstring.php');
		}

		//	Reset application root.
		global $_OP;
		$_OP[APP_ROOT] = dirname(__DIR__).'/';

		//	Reset entry point.
		$_SERVER['SCRIPT_NAME'] = dirname($_SERVER['SCRIPT_NAME']);

		//	For Eclipse (Never used error)
		if( false ){ var_dump($_OP); };

	} catch ( Throwable $e ){
		$file    = $e->getFile();
		$line    = $e->getLine();
		$message = $e->getMessage();
		exit("$file #$line, $message");
	}
});
