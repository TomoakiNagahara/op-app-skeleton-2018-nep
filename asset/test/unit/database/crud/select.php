<?php
/**
 * unit-test:/unit/database/crud/select.php
 *
 * @creation  2019-01-17
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
	'database' => 'testcase',
	'table'    => 't_testcase',
	'limit'    =>  3,
	'order'    => 'timestamp desc',
	'where'    => [
		'ai'   => [
			'value' =>  0,
			'evalu' => '>',
		],
	],
];

//	...
$names = [];
$names[] = 'mysql';
//$names[] = 'pgsql';
//$names[] = 'sqlite';

//	...
foreach( $names as $prod ){
	//	...
	if(!empty($_GET['prod']) and $_GET['prod'] !== $prod ){
		continue;
	};

	/* @var $db \OP\UNIT\Database */
	$db = $dbs[$prod];

	//	...
	$result[$prod] = $db->Select($config);

	$db->Debug();
};

//	...
Html('','hr');
Html('CRUD: Select');
D($result);

//	...
foreach( $names as $prod ){
	if( ($result[$prod] ?? true) === false ){
		$dbs[$prod]->Debug();
	};
};
