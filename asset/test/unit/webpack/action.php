<?php
/**
 * unit-test:/unit/webpack/action.php
 *
 * @creation  2018-04-12
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
if(!Unit::Load('webpack') ){
	return;
}

//	...
\OP\UNIT\WebPack::Js(__DIR__.'/test');

//	...
\OP\UNIT\WebPack::Css(__DIR__.'/test');

//	...
\OP\UNIT\WebPack::Out('js');

//	...
\OP\UNIT\WebPack::Out('css');

//	...
\OP\UNIT\WebPack::Js(__DIR__.'/test');

//	...
\OP\UNIT\WebPack::Css(__DIR__.'/test');

//	...
echo \OP\UNIT\WebPack::Get('js');

//	...
echo \OP\UNIT\WebPack::Get('css');
