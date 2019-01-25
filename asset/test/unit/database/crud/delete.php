<?php
/**
 * unit-test:/unit/database/crud/delete.php
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
	'where'    => [
		'ai'   => [
			'value' =>  null,
			'evalu' => '!=',
		],
	]
];

//	...
$names = [];
$names[] = 'mysql';
$names[] = 'pgsql';
$names[] = 'sqlite';

//	...
foreach( $names as $prod ){
	//	...
	if(!empty($_GET['prod']) and $_GET['prod'] !== $prod ){
		continue;
	};

	/* @var $db \OP\UNIT\Database */
	$db = $dbs[$prod];

	//	...
	switch( $prod ){
		case 'pgsql':
		case 'sqlite':
			unset($config['limit']);
			unset($config['order']);
			break;

		default:
			$config['limit'] = 1;
			$config['order'] = 'timestamp asc';
			break;
	};

	//	...
	$result[$prod] = $db->Delete($config);
};

//	...
Html('','hr');
Html('CRUD: Delete');
D($result);

//	...
foreach( $names as $prod ){
	if( ($result[$prod] ?? true) === false ){
		$dbs[$prod]->Debug();
	};
};
