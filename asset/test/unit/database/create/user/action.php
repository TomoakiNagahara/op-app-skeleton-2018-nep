<?php
/**
 * unit-test:/unit/database/create/user.php
 *
 * @creation  2018-12-17
 * @version   1.0
 * @package   unit-test
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
//	...
$result = [];

//	...
$dbs = include(ConvertPath('asset:/test/unit/database/connect/action.php'));

//	...
$config = [
	'host'     => 'localhost',
	'user'     => 'testcase',
	'password' => 'password',
];

//	...
foreach( ['mysql'] as $prod ){
	/* @var $db \OP\UNIT\Database */
	$db = $dbs[$prod];

	//	...
	$show = $db->Show(['user'=>true]);

	//	...
	$host = $config['host'];
	$user = $config['user'];

	//	...
	if( $show[$host][$user] ?? true ){
		$result[$prod] = $db->Drop()->User($config);
	};

	//	...
	$result[$prod] = $db->Create()->User($config);
};

//	...
D($result);
