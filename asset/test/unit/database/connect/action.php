<?php
/**
 * unit-test:/unit/database/connection.php
 *
 * @creation  2018-12-11
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
$dbs = [];

//	...
foreach( ['mysql','sqlite'] as $prod ){
	$dbs[$prod] = include("{$prod}.php");
};

//	...
foreach( $dbs as $prod => $db ){
	/* @var $db OP\UNIT\Database */
	$io = $db->isConnect() ? true: false;
	$class = $io ? '.success':'.failed';
	$label = $io ? ' success':' failed';
	Html("{$prod} = {$label}", $class);
};

D(ini_get('upload_max_filesize'));
D(ini_get('pdo_mysql.default_socket'));
