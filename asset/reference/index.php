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
$args = App::Args();

//	...
switch( $count = count($args) ){
	case 0:
	case 1:
		include('menu.phtml');
		break;

	case 2:
		include('index.phtml');
		break;

	case 3:
		include('readme.php');
		break;

	default:
		D($count, $args);
};
