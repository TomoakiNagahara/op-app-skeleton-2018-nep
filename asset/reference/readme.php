<?php
/**
 * unit-referencet:/readme.php
 *
 * @creation  2018-11-01
 * @version   1.0
 * @package   unit-reference
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
Env::Mime('text/plain');

//	...
App::Layout(false);

//	...
$args = App::Args();

//	...
switch( $args[0] ){
	case 'core':
		echo 'not ready yet...';
		break;

	case 'unit':
		//	...
		$path = ConvertPath("app:/asset/unit/{$args[1]}/README.md");

		//	...
		if(!file_exists($path) ){
			echo "Has not been exists README file.";
			return;
		}

		//	...
		echo file_get_contents($path);

		//	...
		break;

	default:
		var_dump($args);
};
