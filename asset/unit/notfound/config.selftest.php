<?php
/**
 * unit-notfound:/config.selftest.php
 *
 * @creation  2019-02-02
 * @version   1.0
 * @package   unit-notfound
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
/* @var $configer \OP\UNIT\SELFTEST\Configer */
$configer = Unit::Instantiate('Selftest')->Configer();

//	...
include(__DIR__.'/selftest/database.php');
include(__DIR__.'/selftest/t_host.php');

//	...
return $configer->Get();
