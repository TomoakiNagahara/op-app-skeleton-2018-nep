<?php
/**
 * unit-google:/index.php
 *
 * @creation  2017-06-08
 * @version   1.0
 * @package   unit-google
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
if(!\Unit::Load('curl')){
	return false;
}

//	...
include('Google.class.php');
