<?php
/**
 * unit-dom:/test.php
 *
 * @created   2018-08-23
 * @version   1.0
 * @package   unit-dom
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
D($_GET);

//	...
\OP\UNIT\WebPack::Css(__DIR__.'/test');

//	...
include('test.html');
include('test.css');
