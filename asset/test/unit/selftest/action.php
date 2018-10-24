<?php
/**
 * unit-test:/unit/selftest/action.php
 *
 * @creation  2018-10-25
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	Load Self-test unit.
if(!Unit::Load('selftest') ){
	return;
}

//	Generate configuration json file.
$config = include('config.php');

//	Generate instance.
$selftest = Unit::Instantiate('Selftest');

//	Automatically inspection.
$selftest->Auto($config);
