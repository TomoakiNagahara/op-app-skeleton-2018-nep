<?php
/**
 * unit-formjs:/test.php
 *
 * @created   2018-08-03
 * @version   1.0
 * @package   unit-formjs
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
D($_GET);

//	...
\OP\UNIT\WebPack::Css(__DIR__.'/test');

//	...
include('test-1.html');
include('test-2.html');
include('test-3.html');
include('test.css');
