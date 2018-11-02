<?php
/**
 * unit-test:/unit/selftest/config.php
 *
 * @creation  2018-10-25
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
$path = $_GET['target'] ?? 'testcase';

//	...
$path .= '.inc.php';

//	...
if(!file_exists($path)){
	return;
};

//	...
return include($path);
