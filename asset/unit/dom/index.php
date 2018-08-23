<?php
/**
 * unit-dom:/index.php
 *
 * @created   2018-08-23
 * @version   1.0
 * @package   unit-dom
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
if(!Unit::Load('webpack') ){
	return;
}

//	...
\OP\UNIT\WebPack::Js(__DIR__.'/dom');

//	...
return true;
