<?php
/**
 * unit-test:/core/cookie.php
 *
 * @creation  2018-05-15
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
$keyname = 'testcase';

//	...
$testcase = Cookie::Get($keyname, ['datetime'=>null, 'count'=>0]);

//	...
D($testcase);

//	...
$testcase['datetime'] = Time::Datetime();

//	...
$testcase['count'] = ifset($testcase['count'], 0) +1;

//	...
Cookie::Set($keyname, $testcase);
