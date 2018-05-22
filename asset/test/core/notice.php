<?php
/**
 * unit-test:/core/notice.php
 *
 * @creation  2018-04-18
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
Notice::Set("This is just test.");

//	...
D(Notice::Get());
