<?php
/**
 * unit-test:/api/chat/save.php
 *
 * @creation  2018-10-10
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	For Eclipse (Undefined error)
if( false ){
	$db = $sql = null;
};

//	...
$request = App::Request();

//	...
$nickname = $request['nickname'] ?? null;
$comment  = $request['comment']  ?? null;

//	...
if(!$nickname or !$comment ){
	throw new Exception("Has not been set nickname or comment.");
};

//	...
$config = [];
$config['table'] = 't_chat';
$config['set']['nickname'] = $nickname;
$config['set']['comment']  = $comment;

//	...
if(!$sql = $sql->Insert($config, $db) ){
	throw new Exception("Generate SQL was failed.");
};

//	...
if(!$result = $db->Query($sql) ){
	throw new Exception("Execute SQL query was failed.");
};
