<?php
/**
 * unit-test:/unit/google/translate.php
 *
 * @creation  2018-07-04
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
$to      = 'ja';
$from    = 'en';
$strings[] = 'This is blue.';

//	...
D( $google->translate($to, $from, $strings), $google->Languages('ja') );

//	...
$google->Debug();
