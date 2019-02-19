<?php
/**
 * unit-notfound:/config/browser.php
 *
 * Use from NotFound::_browser()
 *
 * @creation  2019-02-08
 * @version   1.0
 * @package   unit-notfound
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
$configs = [];

//	...
$configs['vivaldi'] = 'Vivaldi\/(\d+)\.(\d+)';
$configs['opera']   = 'OPR\/(\d+)\.(\d+)';
$configs['chrome']  = 'Chrome\/(\d+)\.(\d+)';
$configs['safari']  = 'Safari\/(\d+)\.(\d+)';
$configs['firefox'] = 'Firefox\/(\d+)\.(\d+)';
$configs['googlebot'] = 'Googlebot\/(\d+)\.(\d+)';

//	...
return $configs;
