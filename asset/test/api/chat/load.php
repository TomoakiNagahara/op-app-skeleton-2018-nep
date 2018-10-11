<?php
/**
 * unit-test:/api/chat/load.php
 *
 * @creation  2018-10-10
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
/* @var $db  \OP\UNIT\Database */
/* @var $sql \OP\UNIT\SQL      */

//	...
$config = [];
$config['table'] = 't_chat';
$config['where']['ai']['value'] = 1;
$config['where']['ai']['evalu'] = '>';
$config['limit'] = 10;
$config['order'] = 'timestamp desc';

//	...
if(!$result = $db->Select($config) ){
	throw new Exception("Select was failed.");
};
