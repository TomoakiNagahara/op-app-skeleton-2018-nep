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
$ai = $request['ai'] ?? 0;

//	...
$config = [];
$config['table'] = 't_chat';
$config['where']['ai']['value'] = $ai;
$config['where']['ai']['evalu'] = '>';
$config['limit'] = 10;
$config['order'] = 'timestamp desc';

//	...
$result = $db->Select($config);

//	...
if( $result === false ){
	throw new Exception("Select was failed.");
};
