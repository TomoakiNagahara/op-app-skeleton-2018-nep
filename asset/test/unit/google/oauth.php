<?php
/**
 * unit-test:/unit/google/oauth.php
 *
 * @creation  2018-07-02
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
/* @var $google \OP\UNIT\Google */
if(!$google = Unit::Instance('Google') ){
	return;
}

//	...
$url = 'http://localhost/op/7/app-skeleton-2018-nep/_testcase/unit/google/oauth';

//	...
$json = $google->OAuth($url);

D($json);
