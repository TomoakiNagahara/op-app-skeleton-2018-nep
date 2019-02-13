<?php
/**
 * unit-notfound:/config.db.php
 *
 * Default database configuration.
 * Can overwrite by Env::Set('unit-notfound').
 *
 * @creation  2019-02-02
 * @version   1.0
 * @package   unit-notfound
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
$temp = [
	'prod'     => 'mysql',
	'host'     => 'localhost',
	'user'     => 'notfound',
	'password' => 'password',
	'database' => 'onepiece',
];

//	...
foreach( $temp as $key => $val ){
	if(!isset($config[$key]) ){
		$config[$key] = $val;
	};
};
