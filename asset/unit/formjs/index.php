<?php
/**
 * unit-formjs:/index.php
 *
 * @created   2018-08-03
 * @version   1.0
 * @package   unit-form
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
if(!Unit::Load('webpack') ){
	return;
}

//	...
\OP\UNIT\WebPack::Js(__DIR__.'/form');

//	...
return true;
