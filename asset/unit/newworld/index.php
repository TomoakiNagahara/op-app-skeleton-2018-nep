<?php
/**
 * unit-newworld:/index.php
 *
 * The NewWorld is new world.
 *
 * @creation  2009-09-27 at Kozhikode in India.
 * @version   1.0
 * @package   unit-newworld
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
foreach(['Dispatch','Layout','Router','Template'] as $name){
	$path = __DIR__."/{$name}.class.php";
	if( file_exists($path) ){
		include($path);
	}else{
		throw new Exception("Does not found this file. ($path)");
	}
}
return true;