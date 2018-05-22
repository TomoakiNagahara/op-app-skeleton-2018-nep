<?php
/**
 * unit-notice:index.php
 *
 * @creation  2018-04-13
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
include(__DIR__.'/Notice.class.php');

//	Execute
register_shutdown_function('\OP\UNIT\Notice::Shutdown');
