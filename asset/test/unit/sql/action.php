<?php
/**
 * unit-test:/unit/sql/action.php
 *
 * @creation  2018-05-01
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
/* @var $sql \OP\UNIT\SQL */
if(!$sql = Unit::Instance('SQL') ){
	return;
}

/* @var $db \OP\UNIT\Database */
if(!$db = Unit::Instance('database') ){
	return;
}

//	...
$config = [];
$config['prod'] = 'mysql';
$config['port'] = '3306';
$config['host'] = 'localhost';
$config['user'] = 'testcase';
$config['password'] = 'password';
if(!$io = $db->Connect($config) ){
	return;
}

//	...
$config = [];
$config['table'] = 't_test';
$config['limit'] = 1;
$config['where']['id'] = 1;
D( $sql->Select($config, $db) );

//	...
$config = [];
$config['table'] = 't_test';
$config['set']['id'] = 1;
D( $sql->Insert($config, $db) );

//	...
$config = [];
$config['table'] = 't_test';
$config['limit'] = 1;
$config['set']['id'] = 1;
$config['where']['id'] = 1;
D( $sql->Update($config, $db) );

//	...
$config = [];
$config['table'] = 't_test';
$config['limit'] = 1;
$config['where']['id'] = 1;
D( $sql->Delete($config, $db) );
