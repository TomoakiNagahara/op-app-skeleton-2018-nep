<?php
/**
 * unit-orm:/index.php
 *
 * @creation  2017-03-16
 * @version   1.0
 * @package   unit-orm
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
include('autoloader.php');

//	...
if(!Unit::Load('sql') ){
	throw new Exception("SQL unit was not found.");
}

//	...
return true;
