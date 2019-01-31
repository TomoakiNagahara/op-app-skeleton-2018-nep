<?php
/**
 * unit-admin:/notfound/action.php
 *
 * @creation  2019-01-30
 * @version   1.0
 * @package   unit-admin
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
if( Unit::Load('notfound') ){
	\OP\UNIT\NotFound::Admin();
};
