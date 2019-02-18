<?php
/**
 * unit-test:/unit/notfound/action.php
 *
 * @creation  2019-02-02
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
if(!Unit::Load('notfound') ){
	return;
};

//	...
\OP\UNIT\NotFound::Admin();
